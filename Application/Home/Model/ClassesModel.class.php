<?php

namespace Home\Model;
use Think\Model;

class ClassesModel extends Model
{
    public function classesList($platform_id, $user_id = 0, $type=0)
    {
        $where['type'] = $type;
        if( $platform_id ){
            $where['platform_id'] = $platform_id;
        }
        if( $user_id ){
            $where['user_id'] = $user_id;
        }
        return $this->where($where)->select();
    }

    public function setClasses($platform_id, $user_id, $class_name, $class_img,$class_describe, $class_id)
    {
        $param['name'] = $class_name;
        $param['img'] = $class_img;
        $param['describe'] = $class_describe;
        if( $class_id ){
            return $this->where(array('id'=>$class_id))->save($param);
        }
        $param['platform_id'] = $platform_id;
        $param['user_id'] = $user_id;
        $param['time'] = time();
        return $this->add($param);
    }

    public function findFirst($class_id)
    {
        return  $this->where(array('id' => $class_id))->find();
    }


    public function getclasses($type, $platform_id, $user_id= 0)
    {
        $where['type'] = $type;
        if( $platform_id ){
            $where['platform_id'] = $platform_id;
        }
        if( $user_id ){
            $where['user_id'] = $user_id;
        }
        return $this->where($where)->select();
    }



}