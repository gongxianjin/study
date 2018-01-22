<?php

namespace Home\Model;
use Think\Model;

class UserAddressModel extends Model
{

    public function setAddress($address_id, $user_id, $nickname, $phone, $city, $address)
    {
        $param['nickname'] = $nickname;
        $param['phone'] = $phone;
        $param['city'] = $city;
        $param['address'] = $address;
        if(  $address_id )
        {
            return $this->where(array(
                'id' =>  $address_id,
                'user_id' =>  $user_id,
            ))->save($param);
        }
        $param['user_id'] = $user_id;
        return $this->add($param);
    }

    public function findFirst($address_id)
    {
        return $this->where(array('id'=>$address_id))->find();
    }

    public function getDefault($user_id, $address_id)
    {
        $where['user_id'] = $user_id;
        if( $address_id ){
            $where['id'] = $address_id;
            $def = $this->where($where)->find();
        }
        if( !isset($def['def']) ){
            $def = $this->where(array('user_id'=>$user_id, 'def'=>1))->find();
        }
        if( !isset($def['def']) ){
            $def = $this->where(array('user_id'=>$user_id))->find();
        }
        return $def;
    }
    public function setDefault($user_id, $address_id)
    {
        $where['user_id'] = $user_id;
        $this->where($where)->save(array('def'=>0));

        $where['id'] = $address_id;
        if($this->where($where)->save(array('def'=>1)) === false){
            return false;
        }
        return true;
    }


}