<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php echo C('APP_NAME');?></title>
    <link rel="stylesheet" href="/asstes/layui/css/layui.css">
    <script src="/asstes/layui/layui.js"></script>
</head>
<style>
    ._preview_100_100{
        width: 100px; height: 100px;
    }
    ._preview_90_160{
        width: 90px; height: 160px;
    }
    ._preview{
        float: left; position: relative;
        margin: 15px 30px 5px 0;
    }
    ._preview ._preview_close{
        position: absolute;  display: inline-block;
        height: 20px; width: 20px; line-height: 20px;
        border-radius: 10px; background: red; color: #ffffff;
        text-align: center; top: -10px; right: -10px; cursor: pointer;
    }
    ._preview img, ._preview audio{
        width: 100%; height: 100%;
    }
    ._preview ._preview_audio{
        background-image: url("/mobile/images/music.jpg");
        background-size: 100% 100%;
        background-repeat:no-repeat;
        width: 100%; height: 100%;
        display: inline-block;
    }
</style>
<body>
<div style="padding: 5px;">
    <form class="layui-form"  action="">
        <input type="hidden" name="book_id" value="<?php echo isset($id)?$id:'';?>" >
        <div class="layui-form-item">
            <label class="layui-form-label">图书名称</label>
            <div class="layui-input-inline">
                <input type="text" name="book_name"  required  lay-verify="required"
                       placeholder="图书名称" value="<?php echo isset($name)?$name:'';?>" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">所属分类</label>
            <div class="layui-input-inline">
                <select name="classify_id"  lay-filter="province">
                    <?php echo W('Select/selectClassify', array(isset($classify_id)?$classify_id:0));?>
                </select>
            </div>
            <label class="layui-form-label">分类等级</label>
            <div class="layui-input-inline">
                <select name="level_id" id="level_select">
                    <?php echo W('Select/selectLevel', array(isset($classify_id)?$classify_id:0, isset($level_id)?$level_id:0));?>
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">图书封面</label>
            <div class="layui-input-block">
                <button type="button" class="layui-btn layui-btn-normal" id="cover_img">选择封面图片</button>
                <input type="hidden" value="<?php echo isset($cover_img)?$cover_img:'';?>" name="cover_img" />
            </div>
            <div class="layui-input-block" style="min-height: 100px;">
                <div  class="_preview _preview_100_100"  id="cover_img_src">
                    <?php if( isset($cover_img ) ): ?><img src="<?php echo C('aliyun.oss_host'); echo ($cover_img); ?>" /><?php endif; ?>
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">内容图片</label>
            <div class="layui-input-block">
                <button type="button" class="layui-btn layui-btn-normal" id="image">选择图片</button>
            </div>
            <div class="layui-input-block" id="_preview_images" style="min-height: 100px;">
                <?php if(isset($res)): if(is_array($res)): foreach($res as $key=>$item): if( $item['image'] ): ?><div class="_preview _preview_90_160">
                                <input type="hidden" name="res[image_<?php echo ($item["name"]); ?>]" value="<?php echo ($item["image"]); ?>" />
                                <a class="_preview_close"><i class="layui-icon">ဆ</i></a>
                                <img src="<?php echo C('aliyun.oss_host'); echo ($item["image"]); ?>" />
                            </div><?php endif; endforeach; endif; endif; ?>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label" style="min-height: 100px;">内容音频</label>
            <div class="layui-input-block">
                <button type="button" class="layui-btn layui-btn-normal" id="audio">选择音频</button>
            </div>
            <div class="layui-input-block" id="_preview_audio" style="min-height: 100px;">
                <?php if(isset($res)): if(is_array($res)): foreach($res as $key=>$item): if( $item['audio'] ): ?><div class="_preview _preview_100_100">
                                <input type="hidden" name="res[audio_<?php echo ($item["name"]); ?>]" value="<?php echo ($item["audio"]); ?>" />
                                <a class="_preview_close"><i class="layui-icon">ဆ</i></a>
                                <a class="_preview_audio"></a>
                            </div><?php endif; endforeach; endif; endif; ?>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label"></label>
            <div class="layui-input-block">
                <button type="button" class="layui-btn" id="upload">文件上传</button>

                <button type="button" class="layui-btn" lay-submit lay-filter="formSubmit">保存</button>
            </div>
        </div>
    </form>
</div>
<script>
    layui.use(['element', 'form', 'upload', 'layer'], function(){
        var form = layui.form, $ = layui.jquery, upload = layui.upload, layer = window.parent.layer || layui.layer;

        var cover = upload.render({
            elem: '#cover_img',
            url: '<?php echo U("upload/files");?>',
            field: 'files',
            auto: false,
            choose: function(obj)
            {
                obj.preview(function(index, file, result){
                    $('#cover_img_src').html($("<img src='"+result+"' data-index='"+index+"' />"));
                });
            },before: function(){
                if( $('input[data-index]').length ){
                    layer.msg('资源上传中...', {icon: 16, shade: 0.3});
                }
            }, done: function(res){
                $('input[name="cover_img"]').val(res.info);
                if( ! $('input[data-index]').length ) {
                    layer.alert('上传成功');
                }
            }
        });

        var uploadFile = upload.render({
            elem: '#image,#audio',
            url: '<?php echo U("upload/files");?>',
            auto: false,
            multiple: true,
            exts: 'mp3|jpg|jpeg|png|gif',
            field: 'files',
            bindAction: '#upload',
            choose: function(obj)
            {
                var files = obj.pushFile();
                var type = uploadFile.config.item[0]['id'];
                obj.preview(function(index, file, result)
                {
                    if(file.type.indexOf(type) == -1)
                    {
                        delete files[index];
                        return;
                    }
                    var filename = file.name.substring(0, file.name.lastIndexOf('.'));
                    var _preview = $('<div class="_preview '+
                            (type=='image' ? '_preview_90_160' : '_preview_100_100') + '"></div>');
                    _preview.html($('<input type="hidden" name="res[' + type + '_' +
                            filename + ']" value="" data-index="'+index+'" />'));
                    _preview.append($('<a class="_preview_close"><i class="layui-icon">ဆ</i></a>').click(function(){
                        delete files[index];
                        _preview.remove();
                    }));

                    if(type == 'image'){
                        _preview.append($('<img src="'+result+'" />'));
                        $('#_preview_images').append(_preview);
                    } else if(type == 'audio') {
//                    _preview.append($('<a class="_preview_audio"><audio src="'+result+'" ></audio></a>'));
                        _preview.append($('<a class="_preview_audio"></a>'));
                        $('#_preview_audio').append(_preview);
                    }
                });
            },before: function(){
                cover.upload();
                if($('input[data-index]').length){
                    layer.msg('资源上传中...', {icon: 16, shade: 0.3});
                }
            },done: function(res, index){
                $('input[data-index="'+index+'"]').val(res.info);
            },allDone: function(){
                if( ! $('input[data-index]').length ) {
                    layer.alert('上传成功');
                }
            }
        });

        $('._preview_close').click(function(){
            $(this).parent().remove();
        });

        form.on('select(province)', function(data)
        {
            var level_select = $('#level_select');
            level_select.html("<option>请选择...</option>");
            form.render('select');
            if( ! data.value )
            {
                return ;
            }
            $.getJSON("<?php echo U('library/getLevelList');?>?classify_id=" + data.value, function(rd)
            {
                if((typeof rd.info) == 'undefined')
                {
                    return;
                }
                for(var level_id in rd.info)
                {
                    level_select.append("<option value='"+level_id+"' >"+rd.info[level_id]+"</option>");
                    form.render('select');
                }
            });
        });
        form.on('submit(formSubmit)', function(data){
            if( ! parseInt(data.field['classify_id']) )
            {
                layer.msg('选择分类');
                return;
            }
            if( ! parseInt(data.field['level_id']) )
            {
                layer.msg('选择分类等级');
                return;
            }
            if( ! parseInt(data.field['cover_img']) )
            {
                layer.msg('请选择图书封面图片');
                return;
            }
            $.post("<?php echo U('library/setBooks');?>", data.field, function(returnData){
                if( typeof returnData.status == undefined){
                    layer.msg('操作失败');
                    return ;
                }
                layer.alert(returnData.info);
                if( returnData.status ){
                    setTimeout("window.parent.location.reload();", 1500);
                }
            });
            return false;
        });
    });
</script>
</body>
</html>