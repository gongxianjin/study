<?php

namespace Admin\Controller;

class UploadController extends Base
{
    public function files()
    {
        if( ! isset($_FILES['files']) ){
            $this->error('请选择你要上传的资源文件');
        }
        // 文件上传是否出错
        if($_FILES['files']['error'] != UPLOAD_ERR_OK){
            $this->error('资源文件上传出现错误');
        }
        if( ! is_uploaded_file($_FILES['files']['tmp_name']) ){
            $this->error('异常的上传方式');
        }
        // 文件上传大小 （ 5 MB ）
        if($_FILES['files']['size'] > (55*1024*1024)){
            $this->error('资源文件上传过大');
        }
        $filename = md5_file($_FILES['files']['tmp_name']) . "." . end(explode(".", $_FILES['files']['name']));

        $upload = new \Common\Model\Upload();
        if( ! $upload->upload($filename, $_FILES['files']['tmp_name']) ){
            $this->error('资源文件上传失败');
        }
        $this->success($filename);
    }

    public function audio()
    {
        if( ! isset($_FILES['audio']) ){
            $this->error('请选择你要上传的语音');
        }
        // 文件上传是否出错
        if($_FILES['audio']['error'] != UPLOAD_ERR_OK){
            $this->error('语音上传出现错误');
        }
        $tmp_name = $_FILES['audio']['tmp_name'];
        if( ! is_uploaded_file($tmp_name) ){
            $this->error('异常的上传方式');
        }
        // 文件上传大小 （ 5 MB ）
        if($_FILES['audio']['size'] > (5*1024*1024)){
            $this->error('语音上传过大');
        }
        $filename = md5_file($tmp_name) . "." . end(explode(".", $_FILES['audio']['name']));

        $upload = new \Common\Model\Upload();
        if( ! $upload->upload($filename, $_FILES['files']['tmp_name']) ){
            $this->error('资源文件上传失败');
        }
        $this->success($filename);
    }
}