<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <title>课本列表</title>
    <link rel="stylesheet" href="/mobile/css/weui.css">
    <link rel="stylesheet" href="/mobile/css/weui_reset.css">
    <link rel="stylesheet" href="/mobile/fonts/iconfont.css">
    <link rel="stylesheet" href="/mobile/style/homemade_book.css">


</head>
<body>
<div class="page">
    <div class="page-header-box">
        <div class="header-box-content">
            <div class="page-header-list">
                <div class="page-header-list-top top-list1">
                    <i class="txh icon-xiaobenkechengtongji"></i>
                </div>
                <div class="page-header-list-down">
                    <p>自制课本</p>
                </div>
            </div>
            <div class="page-header-list">
                <div class="page-header-list-top top-list2">
                    <i class="txh icon-book"></i>
                </div>
                <div class="page-header-list-down">
                    <p>课本列表</p>
                </div>
            </div>
            <div class="page-header-list">
                <div class="page-header-list-top top-list3">
                    <i class="txh icon-graphic-lesson"></i>
                </div>
                <div class="page-header-list-down">
                    <p>自制课文</p>
                </div>
            </div>
            <div class="page-header-list">
                <div class="page-header-list-top top-list4">
                    <i class="txh icon-iconliebiao"></i>
                </div>
                <div class="page-header-list-down">
                    <p>课文列表</p>
                </div>
            </div>
        </div>
      <div class="header-box-line">
          <img src="/mobile/images/library/line.png" alt="">
      </div>
    </div>
    <div class="page-body-box">
        <div style="display: none" class="body-box-common book-relavant">
            <!--自制课本-->
            <div class="class-name">
                <label>课文名称</label>
                <input type="text" placeholder="小学英语">
            </div>
            <div class="lesson-img-box">
                <img src="/mobile/images/activity/activity_fengmian.png" alt="">
                <a href="#">修改课文封面</a>
            </div>
            <div class="activity-setting">
                <label>级别设置</label>

                <div class="input-box">
                    <label>课文级别:</label>
                    <input type="text" placeholder="四年级">
                </div>
                <div class="input-box date-box">
                    <label>添加单元:</label>
                    <input type="text" class="weui-input">
                    <a href="#" class="add-unit">
                        <i class="txh icon-jia"></i>添加单元
                    </a>
                </div>
                <p class="unit-aside">
                    课本内容由单元及旗下的课文组成
                </p>
            </div>
            <div class="unit-table">
                <table class="imagetable">
                    <tr>
                        <th>名称</th>
                        <th>排序</th>
                        <th>操作</th>
                    </tr>
                    <tr>
                        <td>unit1</td>
                        <td>1</td>
                        <td>
                            <a href="#">删除</a>
                            <a href="#">修改</a>
                            <a href="#">制作新课文</a>
                            <a href="#">添加课文</a>
                        </td>
                    </tr>
                    <tr>
                        <td>unit1</td>
                        <td>1</td>
                        <td>
                            <a href="#">删除</a>
                            <a href="#">修改</a>
                            <a href="#">制作新课文</a>
                            <a href="#">添加课文</a>
                        </td>
                    </tr>
                    <tr>
                        <td>unit1</td>
                        <td>1</td>
                        <td>
                            <a href="#">删除</a>
                            <a href="#">修改</a>
                            <a href="#">制作新课文</a>
                            <a href="#">添加课文</a>
                        </td>
                    </tr>
                </table>

            </div>
            <div class="unit-footer">
                <a href="#">保存</a>
                <a href="#">发布</a>
            </div>
        </div>

        <div  style="display: none" class="class-list-box body-box-common activity-list-book-all">
        </div>
        <div class=" body-box-common book-relavant" >
            <!--自制课文-->
            <div class="class-name">
                <label>课文名称</label>
                <input type="text" placeholder="小学英语">
            </div>
            <div class="lesson-img-box">
                <img src="/mobile/images/activity/activity_fengmian.png" alt="">
                <a href="#">修改课文封面</a>
            </div>
            <div class="activity-setting">
                <label>级别设置</label>

                <div class="input-box">
                    <label>课文级别:</label>
                    <input type="text" placeholder="四年级">
                </div>
                <div class="input-box date-box">
                    <label>添加单元:</label>
                    <input type="text" class="weui-input">
                    <a href="#" class="add-unit">
                        <i class="txh icon-jia"></i>添加单元
                    </a>
                </div>
                <p class="unit-aside">
                    课本内容由单元及旗下的课文组成
                </p>
            </div>
            <div class="unit-table">
                <table class="imagetable">
                    <tr>
                        <th>名称</th>
                        <th>排序</th>
                        <th>操作</th>
                    </tr>
                    <tr>
                        <td>unit1</td>
                        <td>1</td>
                        <td>
                            <input placeholder="1-1.jpg" type="file"  name="file" style="background-color:#EEEDEF;color:#666666;width: 63px;padding-left: 0;border: none;">
                            <a href="#">删除</a>
                            <input placeholder="1-1.jpg" type="file"  name="file" style="background-color:#EEEDEF;color:#666666;width: 63px;padding-left: 0;border: none;">
                            <a href="#">添加课文</a>
                        </td>
                    </tr>
                    <tr>
                        <td>unit1</td>
                        <td>1</td>
                        <td>
                            <input placeholder="1-1.jpg" type="file"  name="file" style="background-color:#EEEDEF;color:#666666;width: 63px;padding-left: 0;border: none;">
                            <a href="#">删除</a>
                            <input placeholder="1-1.jpg" type="file"  name="file" style="background-color:#EEEDEF;color:#666666;width: 63px;padding-left: 0;border: none;">
                            <a href="#">添加课文</a>
                        </td>
                    </tr>
                    <tr>
                        <td>unit1</td>
                        <td>1</td>
                        <td>
                            <input placeholder="1-1.jpg" type="file"  name="file" style="background-color:#EEEDEF;color:#666666;width: 63px;padding-left: 0;border: none;">
                            <a href="#">删除</a>
                            <input placeholder="1-1.jpg" type="file"  name="file" style="background-color:#EEEDEF;color:#666666;width: 63px;padding-left: 0;border: none;">
                            <a href="#">添加课文</a>
                        </td>
                    </tr>
                </table>

            </div>
            <div class="unit-footer">
                <a href="<?php echo U('Home/CreateBook/previewBook');?>">合成预览</a>
                <a href="#">保存</a>
            </div>
        </div>
        <!-- 图书列表-->
        <div style="display: none" class="class-list-box body-box-common activity-list-all" >
            
        </div>
    </div>

</div>
</body>
<script src="/mobile/js/zepto.min.js"></script>
<script src="/mobile/js/weui.min.js"></script>
<script src="/mobile/js/jweui.min.js"></script>
<script src="/mobile/js/jquery.min.js"></script>
<script>
    $(function(){
        $(".header-box-content").on("click",".page-header-list",function () {
            var col = $(this).index();
            //待使用组
            var urls = new Array("","getBooks","","getTextBooks");
            //待使用div组
            var divs = new Array("",".activity-list-book-all","",".activity-list-all");
            var url = "<?php echo U('Home/CreateBook/" + urls[col] + "');?>";
            console.log(url);
            $.ajax({
                url:url,
                success:function(data){
                    var res = "";
                    var index = 0;
                    $.each(data,function(no,items){
                        if (index % 2 == 0) {
                            res += '<div class="activity-list">';
                        };
                        switch(col){
                            case 1: 
                                var html = '<div class="activity-list-' + (index % 2 == 0 ? "left" : "right") + ' activity-list-common"><div class="img-box"><img src="/mobile/images/activity/activity1.png" alt=""><p>' + (items.name).substr(0,5) + '<span class="' + items.s_html + '">[' + items.status + ']</span></p></div><div class="function-list"><div class="list-box"><div class="fuction">修改</div><div class="fuction">删除</div></div></div></div>';
                                break;
                            case 3:
                                var html = '<div class="activity-list-' + (index % 2 == 0 ? "left" : "right") + ' activity-list-common"><div class="img-box"><img src="/mobile/images/activity/activity1.png" alt=""><p>' + (items.book_name).substr(0,5) +'<span style="font-weight: 200;margin-left:5px ">' + (items.name).substr(0,5) + '</span></p></div><div class="function-list"><div class="list-box"><div class="fuction">修改</div><div class="fuction">删除</div></div></div></div>';
                                break;
                        }
                        res += html;
                        if (index % 2 != 0) {
                            res += "</div>";
                        };
                        index++;
                    });
                    console.log(res);
                    $(divs[col]).html(res);
                }
            });
            $($(".body-box-common")[$(this).index()]).css("display","block").siblings().css("display","none");

        })
    })
</script>
</html>