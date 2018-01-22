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
            
        </div>
    </div>
</div>
<script>
    layui.use('element', function(){});
</script>
</body>
</html>