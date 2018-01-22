<?php

namespace Home\Controller;

class AddressController extends Base
{
    public function index()
    {
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

        $parse_url = parse_url($referer, PHP_URL_PATH);
        if(strpos($parse_url, "shop/next") !== false)
        {
            $parse_url = trim($parse_url, C('TMPL_TEMPLATE_SUFFIX')) . "/address_id/";
            $this->assign('callback', $parse_url);
        }
        $this->assign('showData', D('UserAddress')->select());
        $this->display();
    }

    public function set()
    {
        $address_id = I('address_id', 0, 'intval');
        $addressInfo = $address_id ? D('UserAddress')->findFirst($address_id) : array();
        if( ! isset($addressInfo['user_id']) || $addressInfo['user_id'] != $this->user_id){
            $addressInfo = array('id'=> '', 'nickname'=> '','phone'=> '','city'=> '','address'=> '');
        }
        $this->assign($addressInfo);
        $this->display() ;
    }

    public function setAddress()
    {
        $address_id = I('post.address_id', 0, 'intval');
        $nickname = I('post.nickname', '', 'strval');
        if( ! $nickname ){
            ajaxReturn('收件人名称');
        }
        $phone = getPhone();
        $city = I('post.city', '', 'strval');
        if( ! $city ){
            ajaxReturn('请选择地区');
        }

        $address = I('post.address', '', 'strval');
        if( ! $address ){
            ajaxReturn('请填写收件人的详细地址');
        }
        if(D('UserAddress')->setAddress($address_id, $this->user_id, $nickname, $phone, $city, $address) === false)
        {
            ajaxReturn('操作失败');
        }
        ajaxReturn('操作成功', 0);
    }

    public function set_default()
    {
        $address_id = I('get.address_id', 0, 'intval');
        if( ! $address_id ){
            ajaxReturn('无效的参数');
        }
        $findFirst = D('UserAddress')->findFirst($address_id);
        if(!isset($findFirst['user_id']) ||  $findFirst['user_id'] != $this->user_id){
            ajaxReturn('收件地址不存在');
        }
        if(D('UserAddress')->setDefault($this->user_id, $address_id) === false){
            ajaxReturn('设置失败');
        }
        ajaxReturn('设置成功', 0);
    }


    public function remove()
    {
        $address_id = I('post.address_id', 0, 'intval');
        if( ! $address_id ){
            ajaxReturn('无效的参数');
        }
        $findFirst = D('UserAddress')->findFirst($address_id);
        if(!isset($findFirst['user_id']) ||  $findFirst['user_id'] != $this->user_id){
            ajaxReturn('收件地址不存在');
        }
        if( ! D('UserAddress')->where(array('id'=>$address_id))->delete()){
            ajaxReturn('删除失败');
        }
        ajaxReturn('删除成功', 0);
    }

}