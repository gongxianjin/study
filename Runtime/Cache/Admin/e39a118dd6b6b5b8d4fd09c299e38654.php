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
                <button class="layui-btn" lay-submit="">查询</button>
                <button type="button" class="layui-btn layui-btn-normal"
                        onclick="ck.addClassify(0, '', '');">添加分类</button>
            </div>
        </div>
    </form>
</blockquote>

<table class="layui-table">
    <thead>
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>图标</th>
        <th>创建时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php if(is_array($showData)): foreach($showData as $key=>$item): ?><tr>
            <td><?php echo ($item["id"]); ?></td>
            <td><?php echo ($item["name"]); ?></td>
            <td>
                <?php if( $item.head_img): ?><img src="<?php echo C('aliyun.oss_host'); echo ($item["head_img"]); ?>" style="width: 50px; height: 50px;" /><?php endif; ?>
            </td>
            <td><?php echo date('Y-m-d H:i:s', $item['time']);?></td>
            <td>
                <a class="layui-btn layui-btn-xs" lay-event="edit" onclick="ck.addClassify('<?php echo ($item["id"]); ?>','<?php echo ($item["name"]); ?>', '<?php echo ($item["head_img"]); ?>');">编辑</a>
                <!--<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>-->
            </td>
        </tr><?php endforeach; endif; ?>
    </tbody>
</table>
<div class="layui-laypage"  style="position: absolute; right: 15px;">
    <?php echo ($page); ?>
</div>

<script>
    layui.use(['layer', 'form', 'upload'], function(){
        var $ = layui.jquery, layer = layui.layer;
        var uploadConfig = {
            elem: '#search',
            url: '<?php echo U("upload/files");?>',
            auto: false,
            field: 'files',
            bindAction: '#upload',
            choose: function(obj)
            {
                obj.preview(function(index, file, result){
                    $('#img_src').html($("<img src='"+result+"' " +
                            "style='width: 100%; height: 100%;' data-index='"+index+"' />"));
                });
            },before: function(){
                if( $('input[data-index]').length ){
                    layer.msg('资源上传中...', {icon: 16, shade: 0.3});
                }
            }, done: function(res){
                $('input[name="upload_img"]').val(res.info);
                if( ! $('input[data-index]').length ) {
                    layer.alert('上传成功');
                }
            }
        };

        (function(_){
            _.addClassify = function(classify_id, classify_name, img)
            {
                layer.open({
                    type: 1,
                    area: ['350px' , '350px'],
                    content: '<div class="layui-form" style="padding: 5px;"> ' +
                    '<div class="layui-form-item">' +
                    '<label class="layui-form-label">分类名称</label>' +
                    '<div class="layui-input-inline">' +
                    '<input type="text" class="layui-input" name="classify_name" ' +
                    'value="' + classify_name + '" required lay-verify="required" /></div></div>' +
                    '<div class="layui-form-item">' +
                    '<label class="layui-form-label">分类图标</label>' +
                    '<div class="layui-input-block">' +
                    '<button type="button" class="layui-btn layui-btn-normal" id="search">选择图片</button>' +
                    '<input  type="hidden" value="'+img+'" name="upload_img" />' +
                    '<button type="button" class="layui-btn" style="margin-left: 10px;" id="upload">图标上传</button></div>' +
                    '<div class="layui-input-block" id="img_src" style="width: 100px; height: 100px; margin-top: 5px;">' +
                    ( !img ?  '' : '<img src="<?php echo C("aliyun.oss_host");?>'+ img +'" style="width: 100%; height: 100%;" />')
                    + '</div></div>' +

                    '<div class="layui-form-item">' +
                    '<label class="layui-form-label"></label>' +
                    '<div class="layui-input-inline">' +
                    '<button class="layui-btn" onclick="ck.save('+classify_id+');" style="width: 100%;">保存</button>' +
                    '</div>' +
                    '</div>' +
                    '</div>'
                });
                layui.upload.render(uploadConfig);
            };
            _.save = function(classify_id)
            {
                var classify_name = $('input[name="classify_name"]').val();
                if( ! classify_name){
                    layer.alert('请填写分类名称');
                    return;
                }
                var classify_img = $('input[name="upload_img"]').val();
                if( ! classify_img){
                    layer.alert('请上传分类图标');
                    return;
                }
                $.post("<?php echo U('library/setClassify');?>",{
                    classify_id: classify_id,
                    classify: classify_name,
                    classify_img: classify_img
                }, function(returnData){
                    ajaxReturn(returnData, true);
                },'JSON');
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