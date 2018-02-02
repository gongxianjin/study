<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <link rel="stylesheet" href="/mobile/css/weui.css">
    <link rel="stylesheet" href="/mobile/css/weui_reset.css">
    <link rel="stylesheet" href="/mobile/fonts/iconfont.css">
    <link rel="stylesheet" href="/mobile/style/all_student.css">
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
    <title>所有学生</title>
</head>
<body>
<div class="header">
    <!--左侧图标-->
        <span class="header-back" onclick="window.history.go(-1)">
            <i class="txh icon-xiangzuo"></i>
        </span>
    <!--中间文字-->
    <span class="header-text">所有学生</span>
    <!--右侧按钮-->
     <span class="header-btn">
            <a href="#" class="edit">添加</a>
    </span>

</div>
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
<div class="page">
    <div class="library-content">
        <div class="library-box">
            <div class="library-box-content">

                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$user): $mod = ($i % 2 );++$i; if($i%4 == 0): ?></div>
                        <div class="library-box-content"><?php endif; ?>
                    <?php if($i % 3 - 2 == 0): ?><div class="box-content-list list-center">
                    <?php else: ?>
                        <div class="box-content-list"><?php endif; ?>
                        <label>
                            <img src="<?php echo imageDomain($user['head_img']);?>" alt="">
                            <input class="checkcell" type="checkbox"  name="stuCheckBox" value="<?php echo ($user['id']); ?>">
                        </label>

                        <p><?php echo ($user['nickname']); ?></p>
                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>

    </div>
    <input type="hidden" id="class_id" value="<?php echo ($class_id); ?>">
</div>
<div class="footer" style="display: none">
    <div class="weui-cells weui-cells_checkbox" >
        <label  class="weui-cell weui-check__label footer-common" for="checkall">
            <div class="weui-cell__bd">
                <input id="checkall" type="checkbox" class="weui-check" name="checkbox1">
                <i class="weui-icon-checked"></i>
                <p>全选</p>
            </div>
        </label>
        <a class="footer-common" href="#" style="line-height: 40px">取消</a>
    </div>
</div>
</body>
<script src="/mobile/js/zepto.min.js"></script>
<script src="/mobile/js/weui.min.js"></script>
<script src="/mobile/js/jweui.min.js"></script>
<script src="/mobile/js/jquery.min.js"></script>

<script>
    $(".header-btn").on("click",".edit",function(e){
        e.stopPropagation;
        $(this).text("确定");
        $(".footer").css("display","block");
        $(".box-content-list label input").css("display","block");
        $(this).one("click",function(e){
            e.stopPropagation();
            //此时可以获取数据了
            addStudents();

            $(this).text("添加");
            $(".footer").css("display","none");
            $(".box-content-list label input").css("display","none");
        })
    });

    //添加学生
    function addStudents(){
        obj = document.getElementsByName("stuCheckBox");
        check_val = [];
        for(k in obj){
            if (obj[k].checked) {
                check_val.push(obj[k].value);
            }
        }
        if (check_val.length == 0) {
            //没有选中同学
            return ;
        }else{
            $.post("<?php echo U('Home/MyClass/addStuFunc');?>",{list:check_val,class_id:$('#class_id').val()},function(res){
                ajaxReturnMsg(res);
            });
        }
    }

    $(".footer").on("click","#checkall",function(){
        if($(this).is(':checked')){
            $('input[name="stuCheckBox"]').each(function(){
                $(this).prop("checked",true);
            });
        }else{
            $('input[name="stuCheckBox"]').each(function(){
                $(this).removeAttr("checked",false);
            });
        }

    });



    $('input[name="stuCheckBox"]').bind({
        change:function(){
            $('input[name="stuCheckBox"]').each(function()//遍历每个.checkcell的checkbox
            {
                if($(this).prop("checked")==false)//如果checkcell取消选中
                {
                    $(this).removeAttr("checked");//先删除它的checked属性，便于统计被选中的checkcell
                    $("#checkall").removeAttr("checked");
                }
                else
                {
                    $(this).prop("checked",true);//如果checkcell被选中，页面显示选中
                    $(this).attr("checked","checked");//checked属性值设置为checked
                }
            });
            var checkedLength=$(".checkcell[checked='checked']").length;//attr方法赋值checked都为计算出子checkbox的长度
            var subLength=$(".checkcell").length;
            //如果所有的子checkbox个数不等于选中的checkbox的个数，就取消全选框的对号
            if(subLength!=checkedLength)
            {
                $("#checkall").prop("checked",false);
            }
            // else

        }
    });





    /*function checkOne(){
        var count = 0;
        $('input[name="stuCheckBox"]').each(function(){
            if($(this).attr('checked') != 'checked')
        });
        if(count == 0) { // 如果没有未选中的那么全选框被选中
            $('#checkAll').attr('checked', 'true');
        } else {
            $('#checkAll').removeAttr('checked');
        }
        console.log(count)
    }

    $('input[name="stuCheckBox"]').click(function(){
        alert(111)
        checkOne()
    })*/
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