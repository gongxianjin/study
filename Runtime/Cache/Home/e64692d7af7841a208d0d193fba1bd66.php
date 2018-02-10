<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <link rel="stylesheet" href="/mobile/layui/css/layui.css">
    <link rel="stylesheet" href="/mobile/css/weui.css">
    <link rel="stylesheet" href="/mobile/css/weui_reset.css">
    <link rel="stylesheet" href="/mobile/fonts/iconfont.css">
    <link rel="stylesheet" href="/mobile/css/dropload.css">
    <link rel="stylesheet" href="/mobile/css/style.css">
    
    <link rel="stylesheet" href="/mobile/style/student_manager.css">

    <title>学生管理</title>
    <script type="text/javascript" src="/mobile/layui/layui.js"></script>
    <script type="text/javascript" src="/mobile/layer/layer.js"></script>
    <script src="/mobile/js/zepto.min.js"></script>
<script src="/mobile/js/weui.min.js"></script>
<script src="/mobile/js/city-picker.data.js"></script>
<script src="/mobile/js/jweui.min.js"></script>
<script type="text/javascript" src="/mobile/js/dropload.min.js"></script>
<script>
     function ajaxReturnMsg(param, reload)
     {
         if((typeof param.code) == 'undefined')
         {
             weui.alert('网络异常, 请稍后重试');
             return false;
         }

         if((typeof param.data['redirect_url']) != 'undefined')
         {
             window.location.href = param.data['redirect_url'];
             return false;
         }

         weui.alert(param.message, function()
         {
             if(reload && param.code == 0){
                 window.location.reload();
             }
         });
         return param.data;
     }
     function getCode()
     {
         var sendCode = $('#send_code');
         if(sendCode.html() != '发送验证码'){
             return;
         }
         var phone = $('input[name="phone"]').val();
         if( ! /^1[34578]\d{9}$/.test(phone) ){
             weui.alert('手机号码格式不正确');
             return;
         }
         $.getJSON("<?php echo U('login/getCode');?>", {phone: phone}, function(param)
         {
             if((typeof param.code) == undefined)
             {
                 weui.alert('网络异常, 请稍后重试');
                 return ;
             }
             var m = 60;
             var clear = setInterval(function(){
                 m -= 1;
                 sendCode.html( m + "秒");
                 if(m < 0)
                 {
                     sendCode.html('发送验证码');
                     clearInterval(clear);
                 }
             }, 1000);
             weui.alert(param.message);
         });
     }
     function checkPhone(phone)
     {
         if( ! /^1[34578]\d{9}$/.test(phone) ){
             weui.alert('手机号码格式不正确');
             return false;
         }
         return true;
     }

     function province()
     {
         var province = [];
         for(var code_id in ChineseDistricts[86])
         {
             var cityChildren = [];
             for( var city_id in ChineseDistricts[code_id])
             {
                 var countyChildren = [];
                 for( var county_id in ChineseDistricts[city_id])
                 {
                     countyChildren.push({
                         label: ChineseDistricts[city_id][county_id],
                         value: ChineseDistricts[city_id][county_id]
                     });
                 }
                 cityChildren.push({
                     label: ChineseDistricts[code_id][city_id],
                     value: ChineseDistricts[code_id][city_id],
                     children: countyChildren
                 });
             }
             province.push({
                 label: ChineseDistricts[86][code_id],
                 value: ChineseDistricts[86][code_id],
                 children: cityChildren
             });
         }
         return province;
     }

     function checkCode(code)
     {
         if( ! /^\d{6}$/.test(code) ){
             weui.alert('手机验证码不正确');
             return false;
         }
         return true;
     }

     function checkPassword(password)
     {
         if( ! /^[\w\~\!@#$%\^\&\*\(\)_\+|\\=-`\/\.\,\?\>\<';":]{6,20}$/.test(password) ){
             weui.alert('密码格式不正确，密码为6到20的字符');
             return false;
         }
         return true;
     }
</script>
</head>
<body>

<div class="dropload-up"></div>
<div class="header">
        <span class="header-back" onclick="window.history.back();">
            <i class="txh icon-xiangzuo"></i>
        </span>
    <span class="header-text">学生管理</span>
    <span class="header-btn" style="position: absolute; right: 20px;color: #3972a8;">
        
    <a style="font-weight: normal">
     <i class="txh icon-share"></i>
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
                    <th>排名</th>
                    <th>学员</th>
                    <th class="flexWidth">昵称</th>
                    <th class="flexWidth">手机号</th>
                    <th class="flexWidth">积分</th>
                </tr>
                </thead>
                <tbody>
                <?php if(is_array($showData)): foreach($showData as $key=>$item): ?><tr class="first-td">
                        <td>
                            <?php echo ($item["id"]); ?>
                        </td>
                        <td>
                            <?php echo ($item["head_img"]); ?>
                        </td>
                        <td>
                            <?php echo ($item["nickname"]); ?>
                        </td>
                        <td>
                            <?php echo ($item["phone"]); ?>
                        </td>
                        <td>
                            <?php echo ($item["nickname"]); ?>
                        </td>
                    </tr><?php endforeach; endif; ?>


                </tbody>
            </table>
        </div>
    </div>
    <script type="text/javascript">

        $(".imagetable").on("click","tr",function () {
            var Index = $(this).index();
            if(Index !== 0){
                confirm("您确定删除"+$(this).find("td").eq(2).html()+"的账号？");
            }
        })

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

</body>

    <script>
        $(function(){
            $(document.body).dropload({
                scrollArea : window,
                loadUpFn : function(me){
                    document.location.reload();
                    me.resetload();
                }
            });
        });
    </script>

</html>