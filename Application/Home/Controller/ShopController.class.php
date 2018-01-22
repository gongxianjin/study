<?php

namespace Home\Controller;

class ShopController extends Base
{
    public function index()
    {
        $goods_type_id = I('get.goods_type_id', 0, 'intval');
        $goodsTypeList = D('GoodsType')->where(array('platform_id'=>$this->platform_id))->getField('id,name,whether');
        $goodsTypeList = $goodsTypeList ? $goodsTypeList : array();
        array_unshift($goodsTypeList, array('id'=> 0, 'name'=> '全部'));
        if( ! isset($goodsTypeList[$goods_type_id]) ){
            $goodsTypeList[$goods_type_id]['current'] = 'current';
        }
        $this->assign('goodsTypeList', $goodsTypeList);
        $this->assign('showData', D('ScoreShop')->scoreShopList($this->platform_id, $goods_type_id));
        $this->display();
    }

    public function detail()
    {
        $goods_id = I('get.goods_id', 0, 'intval');
        if( ! $goods_id )
        {
            $this->redirect("shop/index");
            exit;
        }
        $goodsInfo = D('ScoreShop')->where(array('id'=>$goods_id))->find();
        if(!isset($goodsInfo['platform_id']) || $goodsInfo['platform_id'] != $this->platform_id)
        {
            $this->redirect("shop/index");
            exit;
        }
        $this->assign($goodsInfo);
        $this->display();
    }

    public function next()
    {
        $address_id = I('address_id', 0, 'intval');
        $getDefault = D('UserAddress')->getDefault($this->user_id, $address_id);
        if( isset($getDefault['id']) )
        {
            $getDefault['address_id'] = $getDefault['id'];
            unset($getDefault['id']);
        }
        $this->assign($getDefault);
        $this->detail();
    }
}