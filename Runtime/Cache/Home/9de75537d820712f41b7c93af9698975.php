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
            <form action="<?php echo U('Home/CreateBook/createBook');?>" method="post" name="bookForm" enctype="multipart/form-data">
                <div class="class-name">
                    <label>课本名称</label>
                    <input type="text" placeholder="小学英语" name="bookName">
                </div>
                <div class="lesson-img-box">
                    <ul class="weui-uploader__files" id="uploaderFiles_book">

                        <li class="weui-uploader__file" style="background-image:url(/mobile/images/activity/activity_fengmian.png)">
                        </li>
                    </ul>
                    <div class="weui-uploader__input-box">
                        <input id="uploaderInput_book" class="weui-uploader__input" type="file" accept="image/*" multiple="" name="book_cover_img">
                    </div>
                </div>
                <div class="activity-setting">
                    <label>级别设置</label>

                    <div class="input-box">
                        <label>课文级别:</label>
                        <input type="text" placeholder="四年级">
                    </div>
                    <div class="input-box date-box">
                        <label>添加单元:</label>
                        <input type="text" class="weui-input" id="text_count">
                        <a href="#" class="add-unit" id="add_btn_book">
                            <i class="txh icon-jia"></i>添加单元
                        </a>
                    </div>
                    <p class="unit-aside">
                        课本内容由单元及旗下的课文组成
                    </p>
                </div>
                <div class="unit-table">
                    <table class="imagetable" id="unitTable">
                        
                    </table>

                </div>
                <input type="hidden" name="isPublish" id="isPublish" value="0">
            </form>
            <div class="unit-footer">
                <a id="saveBook" href="javascript:document.getElementById('isPublish').value = '0';document.bookForm.submit();">保存</a>
                <a id="publishBook" href="javascript:document.getElementById('isPublish').value = '1';document.bookForm.submit();">发布</a>
            </div>
        </div>

        <div  style="display: none" class="class-list-box body-box-common activity-list-book-all">
        </div>
        <div class=" body-box-common book-relavant" >
            <!--自制课文-->
            <form method="post" action="<?php echo U('Home/CreateBook/createBooktext');?>" name="textBookForm" enctype="multipart/form-data">
                <div class="class-name">
                    <label>课文名称</label>
                    <input type="text" placeholder="小学英语" name="bookName">
                </div>
                <div class="lesson-img-box">
                    <ul class="weui-uploader__files" id="uploaderFiles">

                        <li class="weui-uploader__file" style="background-image:url(/mobile/images/activity/activity_fengmian.png)">
                        </li>
                    </ul>
                    <div class="weui-uploader__input-box">
                        <input id="uploaderInput" class="weui-uploader__input" type="file" accept="image/*" multiple="" name="cover_img">
                    </div>




                 <!--   <img src="./images/activity/activity_fengmian.png" alt="">
                    <a href="#">修改课文封面</a>-->
                </div>
                <div class="activity-setting">
                    <label>级别设置</label>

                    <div class="input-box">
                        <label>课文级别:</label>
                        <input type="text" placeholder="四年级" name="bookClassify">
                    </div>
                    <div class="input-box date-box">
                        <label>课文页数:</label>
                        <input type="text" class="weui-input unitCount">
                        <a href="#" class="add-unit">
                            <i class="txh icon-jia"></i>添加页数
                        </a>
                    </div>
<!--                     <p class="unit-aside">
                        课本内容由单元及旗下的课文组成
                    </p>
 -->                </div>
                <div class="unit-table">
                    <table class="imagetable unit-tb">
                        <!--课文列表-->
                        

                    </table>
                    <input type="hidden" value="<?php echo ($book_id); ?>" name="book_id">
                </div>
                <div class="unit-footer">
                    <a href="<?php echo U('Home/CreateBook/previewBook');?>">合成预览</a>
                    <a href="javascript:document.textBookForm.submit();">保存</a>
                </div>
            </form>
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
            if(col == 1 || col == 3){
                $.ajax({
                    url:url,
                    success:function(data){
                        console.log(data);
                        var res = "";
                        var index = 0;
                        $.each(data,function(no,items){
                            if (index % 2 == 0) {
                                res += '<div class="activity-list">';
                            };
                            switch(col){
                                case 1: 
                                    var html = '<div class="activity-list-' + (index % 2 == 0 ? "left" : "right") + ' activity-list-common"><div class="img-box"><img src="' + items.cover_img + '" alt=""><p>' + (items.name) + '<span class="' + items.s_html + '">[' + items.status + ']</span></p></div><div class="function-list"><div class="list-box"><div class="fuction">修改</div><div class="fuction del_btn" data="' + items.id+ '">删除</div></div></div></div>';
                                    break;
                                case 3:
                                    var html = '<div class="activity-list-' + (index % 2 == 0 ? "left" : "right") + ' activity-list-common"><div class="img-box"><img src="' + items.image + '" alt=""><p>' + (items.book_name).substr(0,5) +'<span style="font-weight: 200;margin-left:5px ">' + (items.name).substr(0,5) + '</span></p></div><div class="function-list"><div class="list-box"><div class="fuction">修改</div><div class="fuction">删除</div></div></div></div>';
                                    break;
                            }
                            res += html;
                            if (index % 2 != 0) {
                                res += "</div>";
                            };
                            index++;
                        });
                        // console.log(res);
                        $(divs[col]).html(res);
                    }
                });
            }

            $($(".body-box-common")[$(this).index()]).css("display","block").siblings().css("display","none");

        })

        //生成课本页数
        $('.add-unit').click(function(){
            //添加单元
            var count = $('.unitCount').val();
            var html = "";
            html += "<tr><th>排序</th><th>图片</th><th>音频</th></tr>";
            for(var i = 1;i <= count;i++){
                html += '<tr><td>' + i + '</td><td><input placeholder="1-1.jpg" type="file" name="file1-' + i + '" style="background-color:#EEEDEF;color:#666666;width: 63px;padding-left: 0;border: none;"><a href="#">删除</a></td><td><input placeholder="1-1.jpg" type="file" name="file2-' + i + '" style="background-color:#EEEDEF;color:#666666;width: 63px;padding-left: 0;border: none;"><a href="#">删除</a></td></tr>';
            }
            html += '<input type="hidden" name="unitCount" value="' + count +'">';
            $('.unit-tb').html(html);
        });


        //生成课文数
        $('#add_btn_book').click(function(){
            //添加单元
            var count = $('#text_count').val();
            var html = "";
            html += "<tr><th>名称</th><th>排序</th><th>操作</th></tr>";
            for(var i = 1;i <= count;i++){
                html += '<tr><td>unit' + i + '</td><td>' + i + '</td><td><a href="#">删除</a><a href="#">修改</a><a href="#">制作新课文</a><a href="#">添加课文</a></td><tr>';
            }
            html += '<input type="hidden" name="textCount" value="' + count +'">';
            $('#unitTable').html(html);
        });

        //替换课文
        var tmpl = '<li class="weui-uploader__file" style="background-image:url(#url#)"></li>',
            $uploaderInput = $("#uploaderInput"),
            $uploaderFiles = $("#uploaderFiles")
        ;

        $uploaderInput.on("change", function(e){
            var src, url = window.URL || window.webkitURL || window.mozURL, files = e.target.files;
            for (var i = 0, len = files.length; i < len; ++i) {
                var file = files[i];

                if (url) {
                    src = url.createObjectURL(file);
                } else {
                    src = e.target.result;
                }
                $("#uploaderFiles").html("");
                /*$uploaderFiles.append($(tmpl.replace('#url#', src)));*/
                $uploaderFiles.append($(tmpl.replace('#url#', src)));
            }
        });

        //替换课本
        var tmpl = '<li class="weui-uploader__file" style="background-image:url(#url#)"></li>',
            $uploaderInput2 = $("#uploaderInput_book"),
            $uploaderFiles2 = $("#uploaderFiles_book")
        ;

        $uploaderInput2.on("change", function(e){
            var src, url = window.URL || window.webkitURL || window.mozURL, files = e.target.files;
            for (var i = 0, len = files.length; i < len; ++i) {
                var file = files[i];

                if (url) {
                    src = url.createObjectURL(file);
                } else {
                    src = e.target.result;
                }
                $("#uploaderFiles_book").html("");
                /*$uploaderFiles.append($(tmpl.replace('#url#', src)));*/
                $uploaderFiles2.append($(tmpl.replace('#url#', src)));
            }
        });


        //删除课本

        $(".activity-list-book-all").on("click",".del_btn",function(){
            var id = $(this).attr('data');
            $.ajax({
                type: 'POST',
                url: "<?php echo U('Home/CreateBook/deleteBook');?>",
                data: {'book_id':id},
                success:function(){
                    console.log("删除成功");
                }
            });
        });

    });
</script>

</html>