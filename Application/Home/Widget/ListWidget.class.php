<?php

namespace Home\Widget;

class ListWidget
{
    protected $user_id = 0;
    protected $platform_id = 0;

    public function __construct()
    {
        $userInfo = \Home\Model\Login::getLoginInfo();
        if (!isset($userInfo['phone'])) {
            if (IS_AJAX) {
                ajaxReturn("登陆", 0, array('redirect_url' => U('login/index')));
            }
            header("Location: " . U('login/index'));
            exit;
        }
        $this->user_id = $userInfo['id'];
        $this->platform_id = $userInfo['platform_id'] ? $userInfo['platform_id'] : 1;
    }


    public function bookList()
    {
        static $bookList = array();
        if( ! $bookList ){
            $bookList = D('Book')->where(array(
                'platform_id' => $this->platform_id
            ))->getField('id,name', true);
        }
        return $bookList;
    }

    public function getBookClassify()
    {
        static $classifyList = array();
        if( ! $classifyList ){
            $classifyList = D('BookClassify')->where(array(
                'platform_id' => $this->platform_id
            ))->getField('id,name', true);
        }
        return $classifyList;
    }

    public function courseList($field = '')
    {
        static $gradeList = array();
        if( ! $gradeList ){
            $gradeList = D('Grade')->where(array(
                'type'=>1,
                'user_id'=>$this->user_id
            ))->getField('id,name,price', true);
        }
        foreach($gradeList as $k => $item)
        {
            if( isset($item[$field]) )
            {
                $gradeList[$k] = $item[$field];
            }
        }
        return $gradeList;
    }

    public function getCourseList($activity_id = 0)
    {
        $where['`grade`.`type`'] = 1;
        $where['`grade`.`user_id`'] = $this->user_id;
        if($activity_id)
        {
            $where['`activity`.`id`'] = $activity_id;
        }
        return D('ActivityCourse')->where($where)
            ->join("LEFT JOIN `activity` ON `activity`.`id`=`activity_course`.`activity_id` ")
            ->join("LEFT JOIN `grade` ON `activity_course`.`grade_id`=`grade`.`id`")
            ->getField('`grade`.`id`,`grade`.`name`,`grade`.`price`', true);
    }

    public function getClassifyLevel($classify_id=0)
    {
        static $classifyLevelList = array();
        if( ! $classifyLevelList )
        {
            $classifyLevelList = D('ClassifyLevel')->where(array(
                'platform_id' => $this->platform_id
            ))->getField('id,classify_id,name', true);
        }
        $classifyLevelMap = array();
        foreach($classifyLevelList as $level_id => $item)
        {
            $classifyLevelMap[ $item['classify_id'] ][$level_id] = $item['name'];
        }
        if( isset($classifyLevelMap[$classify_id]) )
        {
            return $classifyLevelMap[$classify_id];
        }
        return $classifyLevelMap;
    }
}