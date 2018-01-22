<?php

namespace Admin\Controller;

class ScoreController extends Base
{
    public function index()
    {
        $this->assign(D('ScoreShop')->scoreList(
            $this->platform_id,
            I('get.name', '', 'strval')
        ));
        $this->display();
    }
    public function goods_type()
    {
        $this->assign(D('GoodsType')->goodsTypeList(
            $this->platform_id,
            I('get.name', '', 'strval')
        ));
        $this->display();
    }

    public function edit()
    {
        layout(false);
        $this->assign(D('ScoreShop')->findFirst(
            $this->platform_id,
            I('get.goods_id', 0, 'intval')
        ));
        $this->display();
    }

    public function setGoods()
    {
        $goods_name = I('post.goods_name', '', 'strval');
        if( ! $goods_name ){
            $this->error('请填写商品名称');
        }

        $goods_type_id = I('post.goods_type_id', 0, 'intval');
        if( ! $goods_type_id){
            $this->error('请选择商品分类');
        }
        $typeInfo = D("GoodsType")->findFirst($this->platform_id, $goods_type_id);
        if( ! isset($typeInfo['whether']) ){
            $this->error('未创建该分类');
        }
        $goods_url = I('post.goods_url', '', 'strval');
        if(!$typeInfo['whether'] && ! $goods_url){
            $this->error('请填写商品兑换链接');
        }

        $goods_score = I('post.goods_score', 0, 'intval');
        if( ! $goods_score){
            $this->error('请填写商品兑换所需积分');
        }

        $goods_images = I('post.images', array());
        if( ! $goods_images || ! is_array($goods_images)){
            $this->error('请选择商品图片');
        }

        $goods_old_price = I('post.goods_old_price', 0.00, 'floatval');
        $goods_price = I('post.goods_price', 0.00, 'floatval');
        $goods_count = I('post.goods_count', 0, 'intval');
        $goods_sold = I('post.goods_sold', 0, 'intval');
        $goods_id = I('post.goods_id', 0, 'intval');
        $content = I('post.content', '', 'strval');

        $scoreModel = D('ScoreShop');
        if($goods_id && ! $scoreModel->findFirst($this->platform_id, $goods_id)  ){
            $this->error('不存在的商品');
        }

        if($scoreModel->setGoods($this->platform_id, $goods_id, $goods_name, $goods_type_id, $goods_old_price,
            $goods_price, $goods_score, $goods_count, $goods_sold, $goods_url, $goods_images, $content) === false){
            $this->error('操作失败');
        }
        $this->success('操作成功');
    }

    public function setGoodsType()
    {
        $type_name = I('post.type_name', '', '');
        if( ! $type_name ){
            $this->error('请填写分类名称');
        }
        $type = I('post.type', 0, 'intval') ? 1 : 0;
        $goods_type_id = I('post.type_id', 0, 'intval');
        $typeModel = D('GoodsType');
        $goodsTypeInfo = $typeModel->findByName($this->platform_id, $type_name);
        if((isset($goodsTypeInfo['id']) && $goodsTypeInfo['id'] != $goods_type_id) && $goodsTypeInfo['name'] == $type_name){
            $this->error('该分类名称已存在');
        }
        if( $typeModel->setGoodsType($this->platform_id, $goods_type_id, $type_name, $type) === false ){
            $this->error('操作失败');
        }
        $this->success('操作成功');
    }

}