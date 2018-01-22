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
                <input type="text" name="name" value="<?php echo I('get.name', '');?>" placeholder="等级名称" class="layui-input">
            </div>
            <div class="layui-input-inline">
                <button class="layui-btn" lay-submit="">查询</button>
                <button type="button" class="layui-btn layui-btn-normal"
                        onclick="ck.setClassLevel(false, false);">添加班级</button>
            </div>
        </div>
    </form>
</blockquote>

<table class="layui-table">
    <thead>
    <tr>
        <th>班级名称</th>
        <th>创建者</th>
        <th>创建身份</th>
        <th>所属平台</th>
        <th>班级人数</th>
        <th>创建时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php if(is_array($showData)): foreach($showData as $key=>$item): ?><tr>
            <td><?php echo ($item["class_name"]); ?></td>
            <td><?php echo ($item["nickname"]); ?></td>
            <td><?php echo ($item["grade_range"]); ?></td>
            <td><?php echo ($item["platform_name"]); ?></td>
            <td><?php echo ($item["count"]); ?></td>
            <td><?php echo date('Y-m-d H:i:s', $item['time']);?></td>
            <td>
                <a class="layui-btn layui-btn-xs" lay-event="edit" onclick="ck.setClassLevel(this);">编辑</a>
            </td>
        </tr><?php endforeach; endif; ?>
    </tbody>
</table>

<div class="layui-laypage"  style="position: absolute; right: 15px;">
    <?php echo ($page); ?>
</div>


<div class="site-text site-block" id="editClassGrade" style="display: none;margin-top: 20px;">
    <form class="layui-form"  style="padding: 10px;" action="<?php echo U('group/setClassGrade');?>" method="post">
        <input type="hidden" name="grade_id" />
        <div class="layui-form-item">
            <label class="layui-form-label">等级名称</label>
            <div class="layui-input-block">
                <input type="text" name="grade_name" required="" lay-verify="required"
                       placeholder="等级名称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">等级范围</label>
            <div class="layui-input-block">
                <input type="text" name="grade_range" required="" lay-verify="required"
                       placeholder="等级名称：如 3~6" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">押金金额</label>
            <div class="layui-input-block">
                <input type="text" name="grade_price" placeholder="押金金额: 默认值为: 100.00" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="">立即提交</button>
            </div>
        </div>
    </form>
</div>
<script>
    layui.use(['layer', 'form'], function(){
        var $ = layui.jquery, layer = layui.layer;
        (function(_){
            _.setClassLevel = function(level_id, obj)
            {
                layer.open({type: 1, title: '编辑', area: ['400px', '300px'], content: $('#editClassGrade').html()});
                var td = $(obj).parent().parent().find('td');
                $('input[name="grade_id"]').val(level_id);
                $('input[name="grade_name"]').val(td.eq(1).html());
                $('input[name="grade_range"]').val(td.eq(2).html());
                $('input[name="grade_price"]').val(td.eq(3).html());
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