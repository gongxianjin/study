<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <link rel="stylesheet" href="/mobile/css/weui.css">
    <link rel="stylesheet" href="/mobile/css/weui_reset.css">
    <link rel="stylesheet" href="/mobile/fonts/iconfont.css">
    <link rel="stylesheet" href="/mobile/style/today_work.css">
    <title>今日作业预览</title>
</head>
<body>
<div class="header">
    <div class="header-top">
        <!--左侧图标-->
        <span class="header-back" onclick="window.history.go(-1)">
            <i class="txh icon-xiangzuo"></i>
        </span>
        <!--中间文字-->
        <span class="header-text">今日作业预览</span>
        <!--右侧按钮-->
         <span class="header-btn">
                <a href="#"><i class="txh icon-share"></i></a>
        </span>
    </div>
    <div class="header-down">
        <div class="lesson-tab">
            <div class="lesson-title">
                <div class="lesson-item">
                    <p>一</p>
                    <span>4</span>
                    <input type="hidden" value="">
                </div>
                <div class="lesson-item">
                    <p>二</p>
                    <span>5</span>
                    <input type="hidden" value="">
                </div>
                <div class="lesson-item">
                    <p>三</p>
                    <span>6</span>
                    <input type="hidden" value="">
                </div>
                <div class="lesson-item">
                    <p>四</p>
                    <span>7</span>
                    <input type="hidden" value="">
                </div>
                <div class="lesson-item">
                    <p>五</p>
                    <span>8</span>
                    <input type="hidden" value="">
                </div>
                <div class="lesson-item">
                    <p>六</p>
                    <span>9</span>
                    <input type="hidden" value="">
                </div>
                <div class="lesson-item">
                    <p>日</p>
                    <span>10</span>
                    <input type="hidden" value="">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page">
    <div class="pass-content">
        <div class="content-tab-box">
            <table class="imagetable">
                <tbody id="t_b">
                <tr class="th_bg">
                    <th>排名</th>
                    <th>用户</th>
                    <th>学员</th>
                    <th>完成度</th>
                    <th>详情</th>
                </tr>

                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$one): $mod = ($i % 2 );++$i;?><tr>
                        <td>
                            <?php if($i < 4): ?><img src="/mobile/images/integral/left<?php echo ($i); ?>.png" alt="">
                            <?php else: ?>
                                <?php echo ($i); endif; ?>
                        </td>
                        <td>
                            <img src="<?php echo imageDomain($one['head_img']);?>" alt="">
                        </td>
                        <td><?php echo ($one['user_name']); ?></td>
                        <?php if($one['status'] == 1): ?><td>已完成</td>
                        <?php else: ?>
                            <td class="no_complete">未完成</td><?php endif; ?>
                        <td>
                            <a href="<?php echo U('workDetail',array('id' => $one['id'],'tast_id' => $one['homework_id']));?>">查看</a>
                        </td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                </tbody>
            </table>
            <input type="hidden" value="<?php echo ($class_id); ?>" id="name">
        </div>
    </div>
</div>
</body>
<script src="/mobile/js/zepto.min.js"></script>
<script src="/mobile/js/weui.min.js"></script>
<script src="/mobile/js/jweui.min.js"></script>
<script>
    $(function(){
        $(".lesson-title").on("click",".lesson-item",function(){
            if(!$(this).hasClass("lesson-item-active")){
                $(this).addClass("lesson-item-active").siblings().removeClass("lesson-item-active");
                // $($(".pass-content")[$(this).index()]).css("display","block").siblings().css("display","none");
                $('#t_b').html();
                var html = '<tr class="th_bg"><th>排名</th><th>用户</th><th>学员</th><th>完成度</th><th>详情</th></tr>';
                $.post("<?php echo U('MyClass/todayWork');?>",{time:$(this).find("input[type='hidden']").val(),class_id:$('#name').val()},function(result){
                    result = JSON.parse(result);
                    console.log(result);
                    $.each(result,function(index,item){
                        html += '<tr><td>' + (index < 3 ? '<img src="/mobile/images/integral/left' + (index + 1) + '.png" alt="">' : (index + 1)) + '</td><td><img src="<?php echo imageDomain('/');?>' + item.head_img + '" alt=""></td><td>' + item.user_name + '</td>' + (item.status == 0 ? '<td class="no_complete">未完成</td>' : '<td>已完成</td>') +'<td><a href="<?php echo U('workDetail');?>?id=' + item.id + '&task_id=' + item.homework_id + '">查看</a></td></tr>';
                    });
                    $('#t_b').html(html);
                });

                $(".lesson-title").css("display","flex")
            }
        })
    })

    //日期获取
    function showWeekFirstDay()     
    {     
        var Nowdate=new Date();     
        var WeekFirstDay=new Date(Nowdate-(Nowdate.getDay()-1)*86400000);     
        M=Number(WeekFirstDay.getMonth())+1    
        var res = new Array(WeekFirstDay,WeekFirstDay.getDate());
        // return WeekFirstDay.getYear()+"-"+M+"-"+WeekFirstDay.getDate();
        return res;     
    }

    $(function(){
        var date = showWeekFirstDay();
        var Nowdate=new Date().getDate(); 
        var gap = Nowdate - date[1];
        var list = $('.lesson-title').find('.lesson-item');
        for(var i = 0;i < list.length;i++){
            if (gap == i) 
            {
                list.eq(i).addClass("lesson-item-active");
            };
            list.eq(i).children('span').html(date[1] + i);
            var str = String(date[0]);
            str = str.replace(/-/g,"/");
            var date2 = new Date(str); 
            var humanDate = new Date(Date.UTC(date2.getFullYear(),date2.getMonth(),date2.getDate(),date2.getHours(),date2.getMinutes(), date2.getSeconds())); 
            list.eq(i).children('input[type="hidden"]').val(humanDate.getTime()/1000 - 8*60*60 + i * 24 * 3600);
        }
    })

</script>
</html>