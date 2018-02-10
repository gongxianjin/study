<?php
    include "TopSdk.php";
    date_default_timezone_set('Asia/Shanghai'); 

    $c = new TopClient;
    $c->appkey = '24745826';
    $c->secretKey = '06cdfb17614f77810b62c3359a7b7c8a';
    // $req = new TradeVoucherUploadRequest;
    // $req->setFileName("example");
    // $req->setFileData("@/Users/xt/Downloads/1.jpg");
    // $req->setSellerNick("奥利奥官方旗舰店");
    // $req->setBuyerNick("101NufynDYcbjf2cFQDd62j8M/mjtyz6RoxQ2OL1c0e/Bc=");
    // var_dump($c->execute($req));

    //    $req2 = new TradeVoucherUploadRequest;
    //    $req2->setFileName("example");
    //
    //    $myPic = array(
    //            'type' => 'application/octet-stream',
    //            'content' => file_get_contents('/Users/xt/Downloads/1.jpg')
    //            );
    //    $req2->setFileData($myPic);
    //    $req2->setSellerNick("奥利奥官方旗舰店");
    //    $req2->setBuyerNick("101NufynDYcbjf2cFQDd62j8M/mjtyz6RoxQ2OL1c0e/Bc=");
    //    var_dump($c->execute($req2));

    $req = new AlibabaAliqinFcSmsNumSendRequest;
    $req ->setExtend( "" );
    $req ->setSmsType( "normal" );
    $req ->setSmsFreeSignName( "童学惠" );
    $req ->setSmsParam( "{code:'123456',name:'123456'}" );
    $req ->setRecNum( "18628246831" );
    $req ->setSmsTemplateCode( "SMS_118790077" );
    $resp = $c ->execute( $req );

?>