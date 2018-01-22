<?php

namespace Home\Model;
use Think\Model;

class GradeModel extends Model
{
    public function gradeList($platform_id, $user_id = 0, $type=0)
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

    public function setGrade($platform_id, $user_id, $class_price,
                             $class_describe, $class_name, $class_img, $class_id, $type=0)
    {
        $param['price'] = $class_price;
        $param['describe'] = $class_describe;
        $param['name'] = $class_name;
        $param['type'] = $type;
        $param['img'] = $class_img;
        if( $class_id ){
            return $this->where(array('id'=>$class_id))->save($param);
        }
        $param['platform_id'] = $platform_id;
        $param['user_id'] = $user_id;
        $param['time'] = time();
        return $this->add($param);
    }

    public function findFirst($grade_id)
    {
        return  $this->where(array('id' => $grade_id))->find();
    }


    public function getGrade($type, $platform_id, $user_id= 0)
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