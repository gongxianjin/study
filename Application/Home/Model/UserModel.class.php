<?php

namespace Home\Model;
use Think\Model;

class UserModel extends Model
{
    public function addUser($phone, $password, $open_id, $platform_id=1)
    {
        return $this->add(array(
            'phone' => $phone,
            'platform_id' => $platform_id,
            'open_id' => $open_id,
            'password' => $this->password($password),
            'time' => time(),
        ));
    }
    public function setPersonal($user_id, $nickname, $head_img, $sex, $birthday, $city)
    {
        return $this->where(array('id'=>$user_id))->save(array(
            'nickname' => $nickname,
            'head_img' => $head_img,
            'sex' => $sex,
            'birthday' => $birthday,
            'city' => $city,
        ));
    }
    public function updatePassword($phone, $password)
    {
        return $this->where(array('phone' => $phone))->save(array('password' => $this->password($password)));
    }
    public function findPhone($phone)
    {
        return $this->where(array('phone' => $phone))->find();
    }
    public function findOpenid($open_id)
    {
        return $this->where(array('open_id' => $open_id))->find();
    }
    public function findFirst($user_id)
    {
        return $this->where(array('id' => $user_id))->find();
    }
    public function password($password)
    {
        return md5("LKDSf8hKLFHb{$password}*KDFD*HB#kFL*#W");
    }

    public function getList($type,$platform_id = 1){
        $query = $this->where("platform_id = {$platform_id} and type = {$type}")->select();
        foreach($query as &$one){
            $one['score'] = M('UserFunds')->where("user_id = {$one['id']}")->getField('score');
        }

        return $query;
    }
}