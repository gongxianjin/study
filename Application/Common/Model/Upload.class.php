<?php

namespace Common\Model;

class Upload
{
    public function images($file, $file_size=5)
    {
        if( ! isset($file['error']) || $file['error'] != UPLOAD_ERR_OK){
            return array('message'=> '上传错误');
        }

        if($file['size'] > ($file_size * 1024 * 1024)){
            return array('message'=> '图片过大');
        }

        if( ! is_uploaded_file($file['tmp_name'])){
            return array('message'=> '没有上传的图片');
        }

        $filename = md5($file['tmp_name']) . '.' . end(explode('.', $file['name']));

        if( ! $this->upload($filename, $file['tmp_name']) ){
            return array('message'=> '上传失败');
        }
        return $filename;
    }

    public function upload($filename, $filePath)
    {
        try{
            $ossClient = new \Common\Model\OSS\OssClient(
                'LTAIbrt2caiumHlB',
                'VQebFcLeRb2jaI0jR7MHpoIr7LWDQr',
                'oss-cn-shanghai.aliyuncs.com'
            );
            $ossClient->uploadFile('ereshiyitian', $filename, $filePath);
        } catch(\Common\Model\OSS\Core\OssException $e) {
            return false;
        }
        return true;
    }
}