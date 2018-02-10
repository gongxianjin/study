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
    
    <link rel="stylesheet" href="/mobile/style/teacher_createactivity.css">

    <title>新建活动</title>
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
    <span class="header-text">新建活动</span>
    <span class="header-btn" style="position: absolute; right: 20px;color: #3972a8;">
          
    </span>
</div>


    <style>.weui-input{text-align: right; padding-right: 5px;}</style>
    <div class="page">
        <form class="layui-form">
            <input type="hidden" name="activity_id" value="<?php echo ($id); ?>" />
            <div class="weui-cells basic-info">
                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label">活动主题</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="text"  maxlength="10"
                               name="activity_name" value="<?php echo ($name); ?>"  placeholder="活动主题">
                    </div>
                </div>

                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label">开始时间</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input search_input" type="text"
                               name="activity_start" value="<?php echo ($activity_start); ?>" readonly="readonly"  placeholder="活动开始时间">
                    </div>
                </div>

                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label">活动连续</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="number"
                               name="continuous" value="<?php echo ($continuous); ?>" pattern="[0-9]*"  placeholder="活动连续多少天">
                    </div>天
                </div>

                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label">每天开始时间</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input _search_time_start" readonly  type="text"
                               name="every_start" value="<?php echo ($start); ?>" placeholder="每天开始时间">
                    </div>
                </div>

                <div class="weui-cell">
                    <div class="weui-cell__hd"><label class="weui-label">每天结束时间</label></div>
                    <div class="weui-cell__bd">
                        <input class="weui-input _search_time_end" readonly type="text"
                               name="every_end" value="<?php echo ($end); ?>" placeholder="每天结束时间">
                    </div>
                </div>

                <div class="weui-cell weui-cell_switch">
                    <div class="weui-cell__bd">是否每月重复</div>
                    <div class="weui-cell__ft">
                        <?php if($is_repeat): ?><input class="weui-switch" name="repeat" checked type="checkbox">
                            <?php else: ?>
                            <input class="weui-switch" name="repeat" type="checkbox"><?php endif; ?>
                    </div>
                </div>

                <div class="placeholder"></div>
                <div class="lesson-img-box">
                    <input type="hidden" name="activity_img" value="<?php echo ($cover_img); ?>" />
                    <img id="cover_img" src="<?php echo imageDomain($cover_img, '/mobile/images/activity/activity_fengmian.png');?>" alt="">
                    <a href="javascript:;" id="search_cover">修改活动封面</a>
                </div>
                <div class="placeholder"></div>

                <div class="weui-cells__title">编辑活动内容</div>
                <div class="weui-cells weui-cells_form">
                    <div class="weui-cell">
                        <div class="weui-cell__bd">
                            <textarea class="weui-textarea" name="content"
                                      placeholder="请输入文本" rows="5"><?php echo ($content); ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="placeholder"></div>
                <div class="weui-cells__title">添加课程</div>
                <div class="add-lesson">
                    <div class="add-lesson-content">
                        <?php $gradeMap = W("List/courseList"); ?>
                        <ul id="course_list">
                            <?php if(is_array($courseMap)): $i = 0; $__LIST__ = $courseMap;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i; $param = implode('|', array_values($item)); ?>
                                <li class="lesson-list">
                                    <input type="hidden" name="course_map[]" value="<?php echo ($param); ?>" />
                                    <span class="list-one"><?php echo ($key+1); ?></span>
                                    <span class="list-two"><?php echo ($gradeMap[$item['grade_id']]['name']); ?></span>
                                    <span class="list-three">保证金:<?php echo ($gradeMap[$item['grade_id']]['price']); ?>元</span>
                                    <i class="list-four txh icon-shezhi"
                                       onclick="ck.setCourse('<?php echo ($param); ?>', <?php echo ($key); ?>);"></i>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </div>
                    <div class="add-lesson-footer">
                        <a href="javascript:;" onclick="ck.setCourse('', false);"><i class="txh icon-add"></i>添加课程</a>
                    </div>
                </div>

                <div class="footer-box">
                    <a href="#"  class="layui-btn" lay-submit lay-filter="create_activity">创建活动</a>
                </div>
            </div>
        </form>

    </div>

    <div style="display: none;" id="edit_course">
        <div class="layui-form" style="padding: 5px;">
            <div class="layui-form-item">
                <label class="layui-form-label">选择课程</label>
                <div class="layui-input-block">
                    <select name="grade_id"><?php echo W('Select/course');?></select>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">解锁等级</label>
                <div class="layui-input-block">
                    <select name="level" lay-verify="required">
                        <?php echo W('Select/classify_level');?>
                    </select>
                </div>
            </div>

            <div class="layui-form-item" pane="">
                <label class="layui-form-label">逐级解锁</label>
                <div class="layui-input-block">
                    <input type="checkbox" name="checked" lay-skin="switch" lay-text="开启|关闭">
                </div>
            </div>
            <button class="layui-btn" id="ckCourse"  style="width: 100%; margin-bottom: 10px;">确定</button>
        </div>
    </div>

    <script type="text/javascript">
        layui.use(['laydate', 'upload', 'form'], function(){
            layui.laydate.render({elem: '._search_time_start', type: 'time'});
            layui.laydate.render({elem: '._search_time_end', type: 'time'});
            layui.upload.render({
                elem: '#search_cover'
                ,url: '<?php echo U("upload/head_img");?>'
                ,field: 'head_img'
                ,before: function(obj){
                    obj.preview(function(index, file, result){
                        $("#cover_img").attr('src', result);
                        layer.load(2, {shade : 0.6});
                    });
                },done: function (ret){
                    layer.closeAll();
                    if((typeof ret.code) == undefined)
                    {
                        weui.alert('上传异常');
                        return;
                    }
                    if( ret.code )
                    {
                        weui.alert(ret.message);
                        return;
                    }
                    $('input[name="activity_img"]').val(ret.filename);
                    return true;
                }
            });

            $('.search_input').on('click', function () {
                var year = (new Date()).getFullYear();
                weui.datePicker({
                    start: year ,
                    end: year + 10,
                    defaultValue: [year, 1, 1],
                    onConfirm: function (result)
                    {
                        $('.search_input').val(result[0]+'-'+
                                (result[1] >= 10 ? result[1] : '0' + result[1])
                                +'-'+ (result[2] >= 10 ? result[2] : '0' + result[2]));
                    }});
            });

            layui.form.on('submit(create_activity)', function(data)
            {
                var field = data.field;
                if( ! field.activity_name ){
                    weui.alert('请填写活动名称');
                    return false;
                }
                if( ! field.activity_start ){
                    weui.alert('请选择活动的开始时间');
                    return false;
                }
                if( ! field.continuous ){
                    weui.alert('请填写活动的持续天数');
                    return false;
                }
                if( ! field.every_start ){
                    weui.alert('请选择活动每天的开始时间');
                    return false;
                }
                if( ! field.every_end ){
                    weui.alert('请选择活动每天的结束时间');
                    return false;
                }
                if( ! field.activity_img ){
                    weui.alert('请选择活动封面');
                    return false;
                }
                $.post("<?php echo U('activity/set');?>",
                        field, function(returnData){
                            ajaxReturnMsg(returnData);
                        });
                return false;
            });

            (function(_){
                _.setCourse = function(param, obj){
                    try {
                        param = param.split('|') || ['', 1, 0];
                    } catch(Ex){
                        param = ['', 1, 0];
                    }

                    layer.open({
                        type: 1,
                        title: '课程编辑',
                        content: $('#edit_course').html()
                    });

                    $('select[name="grade_id"]').eq(1).val(param[0]);
                    $('select[name="level"]').eq(1).val(param[1]);
                    $('button[id="ckCourse"]').eq(1).on('click', function(){
                        ck.course(obj);
                    });
                    $('input[name="checked"]').eq(1).prop("checked", parseInt(param[2]) ? true : false);
                    layui.form.render();
                };

                _.course = function(index)
                {
                    var grade_id = $('select[name="grade_id"]').eq(1).val();
                    if( ! grade_id )
                    {
                        return;
                    }
                    var gradeMap = $.parseJSON('<?php echo json_encode(W("List/courseList"));?>');
                    var level = $('select[name="level"]').eq(1).val();
                    var checked = $('input[name="checked"]').eq(1).is(":checked") ? 1 : 0;
                    var param = grade_id + '|' + level + '|' + checked;
                    var course_list = $('#course_list');
                    var _index = index;
                    if(index === false)
                    {
                        _index = course_list.find('li').length;
                    }
                    var input = $('<input type="hidden" name="course_map[]" value="'+param+'" />');
                    var one = $('<span class="list-one">'+ (_index + 1) +'</span>');
                    var two = $('<span class="list-two">'+ gradeMap[grade_id]['name'] +'</span>');
                    var three = $('<span class="list-three"> 保证金：'+ gradeMap[grade_id]['price'] +'元</span>');
                    var shezhi = $('<i class="list-four txh icon-shezhi"' +
                            ' onclick="ck.setCourse(\'' + param + '\', '+ _index +');"></i>');
                    if(index !== false)
                    {
                        course_list.find('li').eq(index).html(input).append(one,two,three,shezhi);
                    } else {
                        course_list.append($('<li class="lesson-list"></li>').append(input,one,two, three,shezhi));
                    }
                    layui.form.render();
                    layer.closeAll();
                };
            })(ck={});
        });
    </script>

</body>

</html>