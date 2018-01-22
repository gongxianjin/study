<?php

namespace Admin\Widget;
use Admin\Controller\Base;

class ListWidget extends Base
{
    private $where = array();
    public function _initialize()
    {
        parent::_initialize();
        if( $this->where ){
            $this->where['platform_id'] = $this->platform_id;
        }
    }

    public function GoodsType($goods_type_id=false)
    {
        static $typeList = array();
        if( ! $typeList ){
            $typeList = D('GoodsType')->where($this->where)->getField('id,name', true);
        }
        return $this->returnMsg($typeList, $goods_type_id);
    }

    public function classify($classify_id=false)
    {
        static $classifyList = array();
        if( ! $classifyList ){
            $classifyList = D('BookClassify')->where($this->where)->getField('id,name', true);
        }
        return $this->returnMsg($classifyList, $classify_id);
    }

    public function classify_level($classify_id, $level_id=false)
    {
        static $levelList = array();
        if( ! $levelList )
        {
            $where = $this->where;
            $where['classify_id'] = $classify_id;
            $levelList = D('ClassifyLevel')->where($where)->getField('id,name', true);
        }
        return $this->returnMsg($levelList, $level_id);
    }

    public function platform($platform_id=false)
    {
        static $platformList = array();
        if( ! $platformList ){
            $platformList = D('Platform')->where($this->where)->getField('id,platform_name', true);
        }
        return $this->returnMsg($platformList, $platform_id);
    }

    public function identity($identity_id = false)
    {
        $atr = array('用户', '教师', '管理员');
        return $this->returnMsg($atr, $identity_id);
    }

    public function sex($sex_id = false)
    {
        $atr = array('不详', '男', '女');
        return $this->returnMsg($atr, $sex_id);
    }

    private function returnMsg($list, $id=false)
    {
        if($id === false){
            return $list;
        }
        return isset($list[$id]) ? $list[$id] : '';
    }
}