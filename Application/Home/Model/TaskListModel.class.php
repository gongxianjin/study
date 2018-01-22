<?php

namespace Home\Model;
use Think\Model;

class TaskListModel extends Model
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
}