<?php

namespace Home\Model;
use Think\Model;

class ClassTaskListModel extends Model
{
    public function setTask($grade_id, $user_id, $book_id, $start, $end, $day)
    {
        return $this->add(array(
            'grade_id' => $grade_id,
            'user_id' => $user_id,
            'book' => $book_id,
            'start' => $start,
            'end' => $end,
            'day' => $day,
            'time' => time(),
        ), array(), true);
    }

    public function classList($platform_id, $user_id = 0, $type=0)
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

    //获取该课文和语音
    public function findBooks( $task_id = 0)
    {
        $where = array();
        if( $task_id ){
            $where['class_task_list.id'] = $task_id;
        }
        return $this->where($where)
            ->join("LEFT JOIN `classhomework` ON `classhomework`.`id` = `class_task_list`.`course_id`")
            ->join("LEFT JOIN `book_res` ON `book_res`.`id` = `classhomework`.`start`")
            ->join("LEFT JOIN `booktext_res` ON `booktext_res`.`bookres_id` = `book_res`.`id`")
            ->field("`class_task_list`.`id` as `task_id`,`booktext_res`.`content_img` as `content_img`,`booktext_res`.`content_voice` as `content_voice`")
            ->find();
    }

}