<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <link rel="stylesheet" href="/mobile/css/weui.css">
    <link rel="stylesheet" href="/mobile/css/weui_reset.css">
    <link rel="stylesheet" href="/mobile/fonts/iconfont.css">
    <link rel="stylesheet" href="/mobile/style/homework_manager.css">
    <title>作业管理</title>
</head>
<body>
<div class="header">
    <!--左侧图标-->
        <span class="header-back" onclick="window.history.go(-1)">
            <i class="txh icon-xiangzuo"></i>
        </span>
    <!--中间文字-->
    <span class="header-text">作业管理</span>
    <!--右侧按钮-->
     <span class="header-btn">
            <a style="font-weight: normal" href="<?php echo U('Home/MyClass/addHomework',array('class_id' => $class_id));?>">
                添加作业
            </a>
    </span>

</div>
<div class="page">
    <div class="search-box">
        <div class="weui-search-bar" id="searchBar">
            <form class="weui-search-bar__form">
                <div class="weui-search-bar__box">
                    <i class="weui-icon-search"></i>
                    <input type="search" class="weui-search-bar__input" id="searchInput" placeholder="搜索" required="">
                    <a href="javascript:" class="weui-icon-clear" id="searchClear"></a>
                </div>
                <label class="weui-search-bar__label" id="searchText" style="transform-origin: 0px 0px 0px; opacity: 1; transform: scale(1, 1);">
                    <i class="weui-icon-search"></i>
                    <span>搜索</span>
                </label>
            </form>
            <a href="javascript:" class="weui-search-bar__cancel-btn" id="searchCancel">取消</a>
        </div>
        <div class="weui-cells searchbar-result" id="searchResult" style="display: none;">
            <div class="weui-cell weui-cell_access">
                <div class="weui-cell__bd weui-cell_primary">
                    <p>实时搜索文本</p>
                </div>
            </div>
            <div class="weui-cell weui-cell_access">
                <div class="weui-cell__bd weui-cell_primary">
                    <p>实时搜索文本</p>
                </div>
            </div>
            <div class="weui-cell weui-cell_access">
                <div class="weui-cell__bd weui-cell_primary">
                    <p>实时搜索文本</p>
                </div>
            </div>
            <div class="weui-cell weui-cell_access">
                <div class="weui-cell__bd weui-cell_primary">
                    <p>实时搜索文本</p>
                </div>
            </div>
        </div>
    </div>
    <div class="content-tab-box">
        <table class="imagetable">
            <thead>
            <tr class="th_bg">
                <th>已布置作业</th>
                <th>起止日期</th>
                <th class="flexWidth">完成状态</th>
                <th class="flexWidth"></th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($homeworks)): $i = 0; $__LIST__ = $homeworks;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$h): $mod = ($i % 2 );++$i;?><tr class="first-td">
                    <td>
                        <?php echo ($h["name"]); ?>
                    </td>
                    <td>
                        <?php echo ($h["start"]); ?>-<?php echo ($h["end"]); ?>
                    </td>
                    <td><a href="<?php echo U('Home/MyClass/SeeHomework',array('id' => $h.id));?>">查看</a></td>
                    <td>
                        <a href="<?php echo U('Home/MyClass/SeeHomework',array('id' => $h.id,'class_id' => $class_id));?>"><i class="txh icon-shanchu1"></i></a>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>

            </tbody>
        </table>
    </div>
</div>

</body>
<script src="/mobile/js/zepto.min.js"></script>
<script src="/mobile/js/weui.min.js"></script>
<script src="/mobile/js/jweui.min.js"></script>
<script>
    // $(".icon-shanchu1").on("click",function () {
    //     confirm("您确定删除？");

    // })
</script>
<script type="text/javascript">
    /*搜索*/
    $(function(){
        var $searchBar = $('#searchBar'),
            $searchResult = $('#searchResult'),
            $searchText = $('#searchText'),
            $searchInput = $('#searchInput'),
            $searchClear = $('#searchClear'),
            $searchCancel = $('#searchCancel');

        function hideSearchResult(){
            $searchResult.hide();
            $searchInput.val('');
        }
        function cancelSearch(){
            hideSearchResult();
            $searchBar.removeClass('weui-search-bar_focusing');
            $searchText.show();
        }

        $searchText.on('click', function(){
            $searchBar.addClass('weui-search-bar_focusing');
            $searchInput.focus();
        });
        $searchInput
            .on('blur', function () {
                if(!this.value.length) cancelSearch();
            })
            .on('input', function(){
                if(this.value.length) {
                    $searchResult.show();
                } else {
                    $searchResult.hide();
                }
            })
        ;
        $searchClear.on('click', function(){
            hideSearchResult();
            $searchInput.focus();
        });
        $searchCancel.on('click', function(){
            cancelSearch();
            $searchInput.blur();
        });
    });
</script>

</html>