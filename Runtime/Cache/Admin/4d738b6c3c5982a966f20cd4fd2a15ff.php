<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php echo C('APP_NAME'); echo W('Menu/getMenuName',array('—'));?></title>
    <link rel="stylesheet" href="/asstes/layui/css/layui.css">
    <script src="/asstes/layui/layui.js"></script>
    <script>
        var layer;
        layui.use('layer', function(){
            layer = layui.layer;
        });
        function ajaxReturn(param, is_reload)
        {
            layer.closeAll('loading');
            if((typeof param.status) == undefined)
            {
                layer.msg('请求失败', {icon: 5});
                return ;
            }
            layer.msg(param.info, {icon: 5 + param.status});
            if(is_reload && param.status)
            {
                setTimeout("window.location.reload();", 1000);
            }
        }
    </script>
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo"><?php echo C('APP_NAME');?></div>
        <ul class="layui-nav layui-layout-left">
            <!--<li class="layui-nav-item"><a href=""></a></li>-->
        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <?php echo session('adminInfo.nickname');?>
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="<?php echo U('login/logout');?>"><i class="fa fa-sign-out"></i> 退出</a></dd>
                </dl>
            </li>
        </ul>
    </div>
    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <ul class="layui-nav layui-nav-tree"  lay-filter="">
                <?php $menuList = W('Menu/getMenuList'); ?>
                <?php if(is_array($menuList)): foreach($menuList as $controller=>$child): ?><li class="layui-nav-item <?php echo isset($child['active']) ? 'layui-nav-itemed':'';?>">
                        <a href="<?php echo isset($child['url']) ? $child['url'] : 'javascript:;';?>"><?php echo ($child["name"]); ?></a>
                        <?php if(isset($child['child'])): ?><dl class="layui-nav-child">
                                <?php if(is_array($child["child"])): foreach($child["child"] as $action=>$item): ?><dd class="<?php echo isset($child['active']) && $child['active'] == $action ? 'layui-this':'';?>">
                                        <a href="<?php echo U($controller .'/'. $action);?>"><?php echo ($item["name"]); ?></a>
                                    </dd><?php endforeach; endif; ?>
                            </dl><?php endif; ?>
                    </li><?php endforeach; endif; ?>
            </ul>
        </div>
    </div>
    <div class="layui-body">
        <div class="layui-tab-content">
            <blockquote class="layui-elem-quote">
    <form class="layui-form" action="">
        <div class="layui-form-item" style="margin: 0;">
            <div class="layui-input-inline">
                <input type="text" name="name" value="<?php echo I('get.name', '');?>" placeholder="分类名称" class="layui-input">
            </div>
            <div class="layui-input-inline">
                <select name="classify_id"><?php echo W('Select/selectClassify', array(I('classify_id', 0, 'intval')));?></select>
            </div>
            <div class="layui-input-inline">
                <button class="layui-btn" lay-submit="">查询</button>
                <button type="button" class="layui-btn layui-btn-normal"
                        onclick="ck.setLevel(0, '', 0);">添加分级</button>
            </div>
        </div>
    </form>
</blockquote>

<table class="layui-table">
    <thead>
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>创建时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php if(is_array($showData)): foreach($showData as $key=>$item): ?><tr>
            <td><?php echo ($item["id"]); ?></td>
            <td><?php echo ($item["name"]); ?></td>
            <td><?php echo date('Y-m-d H:i:s', $item['time']);?></td>
            <td>
                <a class="layui-btn layui-btn-xs" lay-event="edit" onclick="ck.setLevel('<?php echo ($item["classify_id"]); ?>', '<?php echo ($item["name"]); ?>', '<?php echo ($item["id"]); ?>');">编辑</a>
                <!--<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>-->
            </td>
        </tr><?php endforeach; endif; ?>
    </tbody>
</table>
<div class="layui-laypage"  style="position: absolute; right: 15px;">
    <?php echo ($page); ?>
</div>

<script>
    layui.use(['layer', 'form'], function(){
        var $ = layui.jquery, layer = layui.layer;
        (function(_){
            _.setLevel = function(classify_id, level_name, level_id)
            {
                var classify = $.parseJSON('<?php echo json_encode(W("List/classify"));?>');
                var strings  = "<option value='0'>请选择...</option>";
                for (var _classify_id in classify)
                {
                    var selected = '';
                    if(_classify_id == classify_id){
                        selected = 'selected';
                    }
                    strings += "<option value='" + _classify_id + "' " + selected + " >"+ classify[_classify_id] +"</option>";
                }
                var div = $('<div></div>');
                div.append($('<div class="layui-form-item" style="margin-top: 20px;"></div>').html(
                        $('<div class="layui-inline"><label class="layui-form-label">所属分类</label></div>').append(
                                $('<div class="layui-input-inline"></div>').html(
                                        $('<select class="layui-input" name="classify_select" style="max-height: 50px;"></select>').html(strings)
                                ))
                ));
                div.append($('<div class="layui-form-item"></div>').html(
                        $('<div class="layui-inline"><label class="layui-form-label">分级名称</label></div>').append(
                                $('<div class="layui-input-inline"></div>').html(
                                        $('<input type="text" name="classify_level" value="'+level_name+'" class="layui-input" />')
                                ))
                ));
                div.append($('<div class="layui-form-item"></div>').html(
                        $('<div class="layui-inline"><label class="layui-form-label"></label></div>').append(
                                $('<div class="layui-input-inline"></div>').html(
                                        $('<button class="layui-btn" onclick="ck.save('+ level_id +');" style="width: 100%;">保存</button>')
                                ))
                ));
                layer.open({
                    type: 1,
                    title: '编辑图书分级',
                    content: $(div).html()
                });
            };
            _.save = function(level_id)
            {
                var classify_id = $('select[name="classify_select"]').val();
                var level_name = $('input[name="classify_level"]').val();
                if( ! classify_id || ! level_name){
                    return;
                }
                $.post("<?php echo U('library/setLevel');?>", {
                    level_id: level_id,
                    classify_id: classify_id,
                    level_name: level_name
                }, function(returnData){
                    ajaxReturn(returnData, true);
                });
            }
        })(ck={});
    });
</script>
        </div>
    </div>
</div>
<script>
    layui.use('element', function(){});
</script>
</body>
</html>