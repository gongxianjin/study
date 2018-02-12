<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <link rel="stylesheet" href="/mobile/css/weui.css">
    <link rel="stylesheet" href="/mobile/css/weui_reset.css">
    <link rel="stylesheet" href="/mobile/fonts/iconfont.css">
    <link rel="stylesheet" href="/mobile/style/person_manager.css">
    <title>用户管理</title>
</head>
<body>
<div class="header">
    <!--左侧图标-->
        <span class="header-back" onclick="window.history.go(-1)">
            <i class="txh icon-xiangzuo"></i>
        </span>
    <!--中间文字-->
    <span class="header-text">用户管理</span>
    <!--右侧按钮-->
     <span class="header-btn">
            <a style="font-weight: normal">
                <i class="txh icon-share"></i>
            </a>
    </span>

</div>
<div class="choice-person-box">
    <div class="choice-person-list active" >学生</div>
    <div class="choice-person-list">老师</div>
</div>
<div class="page">
<!--     <div class="search-box">
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
    </div> -->
    <div class="content-tab-box">
        <table class="imagetable">
            <thead>
            <tr class="th_bg">
                <th>排名</th>
                <th>学员</th>
                <th class="flexWidth">昵称</th>
                <th class="flexWidth">手机号</th>
                <th class="flexWidth">积分</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($stuList)): $i = 0; $__LIST__ = $stuList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$stu): $mod = ($i % 2 );++$i;?><tr class="first-td">
                    <td>
                        <?php if($i < 4): ?><img src="/mobile/images/integral/left<?php echo ($i); ?>.png" alt="">
                        <?php else: ?>
                            <?php echo ($i); endif; ?>
                    </td>
                    <td>
                        <img src="<?php echo imageDomain($stu['head_img']);?>" alt="">
                    </td>
                    <td><?php echo ($stu['nickname']); ?></td>
                    <td><?php echo ($stu['phone']); ?></td>

                    <td>
                        <?php echo ($stu['score']); ?>
                    </td>
                    <td>
                        <input type="hidden" name="id" value="<?php echo ($stu['id']); ?>">
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </div>
    <div class="content-tab-box" style="display: none">
        <table class="imagetable">
            <thead>
            <tr class="th_bg">
                <th>排名</th>
                <th>老师</th>
                <th class="flexWidth">昵称</th>
                <th class="flexWidth">手机号</th>
                <th class="flexWidth">积分</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($teaList)): $i = 0; $__LIST__ = $teaList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$t): $mod = ($i % 2 );++$i;?><tr class="first-td">
                    <td>
                         <?php if($i < 4): ?><img src="/mobile/images/integral/left<?php echo ($i); ?>.png" alt="">
                        <?php else: ?>
                            <?php echo ($i); endif; ?>
                    </td>
                    <td>
                        <img src="<?php echo imageDomain($t['head_img']);?>" alt="">
                    </td>
                    <td><?php echo ($t['nickname']); ?></td>
                    <td><?php echo ($t['phone']); ?></td>

                    <td>
                        <?php echo ($t['score']); ?>
                    </td>
                    <td>
                        <input type="hidden" name="id" value="<?php echo ($t['id']); ?>">
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
    $(".choice-person-box").on("click",".choice-person-list",function () {
        if(!$(this).hasClass("active")){
            $(this).addClass("active").siblings().removeClass("active");
            $($(".content-tab-box")[$(this).index()]).css("display","block").siblings().css("display","none");
        }
    });
    $(".imagetable").on("click","tr",function () {
        var Index = $(this).index();
        // if(Index !== 0){
        var res = confirm("您确定删除"+$(this).find("td").eq(2).html()+"的账号？");
        if (res == true) {
            $.post("<?php echo U('User/deleteUser');?>",{id:$(this).find("input[name='id']").val()},function(res){
                weui.alert(res.message,function(){
                    window.location.reload();
                })
            });
        };
        // }
    })
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