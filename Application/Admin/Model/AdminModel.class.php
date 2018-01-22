<?php

namespace Admin\Model;
use Think\Model;

class AdminModel extends Model
{
    public function addAdmin($account, $password, $nickname, $group_id = 0, $status = 0)
    {
        return $this->add(array(
            'account' => $account,
            'password' => $this->password($password),
            'nickname' => $nickname,
            'group_id' => $group_id,
            'time' => time(),
            'status' => $status,
        ));
    }

    public function findFirst($account, $password)
    {
        return $this->where(array('account'=>$account, 'password'=>$this->password($password)))->find();
    }

    private function password($password)
    {
        return md5("I*DGFDNfo;*ASDF".$password."VBDFBbW5ge4ay");
    }
}