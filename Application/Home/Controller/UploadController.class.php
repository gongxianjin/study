<?php

namespace Home\Controller;

class UploadController extends Base
{
    public function head_img()
    {
        header('Content-Type: application/json; charset=utf-8');
        $returnMsg = array('code'=> 1, 'message'=>'failure', 'filename'=> '');
        if( ! isset($_FILES['head_img']) )
        {
            $returnMsg['message'] = '没有上传的图片';
            exit(json_encode($returnMsg));
        }

        $upload = new \Common\Model\Upload();
        $filename = $upload->images($_FILES['head_img'], 3);
        if( is_array($filename) )
        {
            $returnMsg['message'] = $filename['message'];
            exit(json_encode($returnMsg));
        }

        $returnMsg = array('code'=> 0, 'message'=>'success', 'filename'=> $filename);
        exit(json_encode($returnMsg));
    }
}