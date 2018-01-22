<?php

namespace Home\Model;
use Think\Model;

class CurriculumModel extends Model
{

    public function setAdd($platform_id, $user_id, $grade_id)
    {
        return $this->add(array(
            'platform_id' => $platform_id,
            'user_id' => $user_id,
            'grade_id' => $grade_id,
        ));
    }



}