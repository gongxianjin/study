<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <title>布置作业</title>
    <link rel="stylesheet" href="/mobile/css/weui.css">
    <link rel="stylesheet" href="/mobile/css/weui_reset.css">
    <link rel="stylesheet" href="/mobile/fonts/iconfont.css">
    <link rel="stylesheet" href="/mobile/style/homework.css">
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
<div class="header">
    <!--左侧图标-->
    <span class="header-back" onclick="window.history.go(-1)">
            <i class="txh icon-xiangzuo"></i>
        </span>
    <!--中间文字-->
    <span class="header-text">布置作业</span>
    <!--右侧按钮-->
    <span class="header-btn">
            <a style="font-weight: normal">
                <i class="txh icon-share"></i>
            </a>
    </span>

</div>

<div class="page">
    <div class="step-list-box">
        <div class="step-list">
            <label>第一步：选择课本</label>
            <select id="bookList">
                <?php if(is_array($bookList)): $i = 0; $__LIST__ = $bookList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$book): $mod = ($i % 2 );++$i;?><option value="<?php echo ($book["id"]); ?>"><?php echo ($book["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>
    <div class="placeholder"></div>
    <div class="step-list-box">
        <div class="step-list">
            <label>第二步：选择起始截止课文</label>
            <div class="choice-list">
                <label>起始课文:</label>
                <select id="start_book">
                    <option value="">海尼曼绘本一</option>
                </select>
            </div>
            <div class="choice-list">
                <label>截止课文:</label>
                <select id="end_book">
                    <option value="">海尼曼绘本十二</option>
                </select>
            </div>
            <div class="aside-text" id="text_count"></div>
            <input type="hidden" name="text_count">

        </div>
    </div>
    <div class="placeholder"></div>
    <div class="lesson-list-box">
        <div class="lesson-list">
            <label>每日录音课文数:</label>
            <input type="text" name="ed_count" value="1">篇
        </div>
        <div class="lesson-list">
            <label>重复天数:</label>
            <input type="text" name="re_day" value="1">天
        </div>
        <div class="lesson-list">
            <label>发布开始时间:</label>
            <input type="date" name="date">
        </div>
        <div class="aside-text" id="day_tip"></div>
        <input type="hidden" name="use_day">
        <input type="hidden" name="class_id" value="<?php echo ($class_id); ?>">
    </div>
</div>
<div class="footer">
    <a href="#" id="save">
        <i class="txh icon-baocun"></i>保存
    </a>
</div>
</body>
<script src="/mobile/js/zepto.min.js"></script>
<script src="/mobile/js/weui.min.js"></script>
<script src="/mobile/js/jweui.min.js"></script>
<script src="/mobile/js/jquery.min.js"></script>
<script>
    var video = document.querySelector('#mainvideo');
    var videobox = document.querySelector('.videobox');
    var setVideoStyle = function (){
        videobox.style.width = '92%';
        videobox.style.left = '-10%';
        video.style.width = '100%';
    }

    $(".choice-list-box").on("click",".choice-list",function(){
        if(!$(this).hasClass("active")){
            $(this).addClass("active").siblings().removeClass("active")
        }
    });

    $('#bookList').change(function(){
        getTextBooks($(this).val());
    });


    function getTextBooks(book_id){
        $.post("<?php echo U('Home/MyClass/getTextBooks');?>",{book_id:book_id},function(data){
            var html = "";
            $.each(JSON.parse(data),function(no,items){
                html += '<option value="' + items.id + '">' + items.name + '</option>';
            });
            $('#start_book').html(html);
            $('#end_book').html(html);
        })
    }
    getTextBooks($('#bookList').val());
    getTextCount();

    $('#start_book').change(function(){
        getTextCount();
    })

    $('#end_book').change(function(){
        getTextCount();
    })

    function getTextCount(){
        var start_index = $('#start_book').find('option:selected').index();
        var end_index = $('#end_book').find('option:selected').index();
        var html = (start_index <= end_index ? "共选择" + (end_index - start_index + 1) + "篇课文" : "截至课本必须大于起始课本");
        
        $("input[name='text_count']").val(end_index - start_index + 1);
        $('#text_count').html(html);
    }
    getUseDay();
    $("input[name='re_day']").change(function(){
        getUseDay();
    });
     $("input[name='ed_count']").change(function(){
        getUseDay();
    });

    function getUseDay(){
        var ed_count = $("input[name='ed_count']").val();
        var re_day = $("input[name='re_day']").val();
        var count = $("input[name='text_count']").val();
        var day = (parseInt(count) / parseInt(ed_count));
        var int_day = parseInt(day);
        int_day = (int_day == day ? int_day : int_day + 1);
        re_day *= int_day;
        $("input[name='use_day']").val(re_day);
        $('#day_tip').html("共需连续" + re_day + "天完成");
    }

    $('#save').click(function(){
        $.post("<?php echo U('Home/MyClass/addHomeworkFunc');?>",{
            course_id:$('#bookList').val(),
            class_id:$("input[name='class_id']").val(),
            start:$("input[name='date']").val(),
            start_id:$('#start_book').val(),
            end_id:$('#end_book').val(),
            use_day:$("input[name='use_day']").val(),
            setup:$("input[name='ed_count']").val()

        },function(res){
            ajaxReturnMsg(res);
        });
    })
</script>
</html>