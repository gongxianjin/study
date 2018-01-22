<?php

namespace Home\Widget;

class SelectWidget extends ListWidget
{
    public function bookList($book_id = 0)
    {
        return $this->options(parent::bookList(), $book_id);
    }

    public function course($course_id = 0)
    {
        return $this->options($this->courseList('name'), $course_id);
    }

    public function classify_level($_level_id = 0)
    {
        $strings = "";
        $classifyList = $this->getBookClassify();
        foreach($this->getClassifyLevel() as $classify_id => $levelList)
        {
            $strings .= "<optgroup label='{$classifyList[$classify_id]}'>";
            $strings .= $this->options($levelList, $_level_id);
            $strings .= "</optgroup>";
        }
        return $strings;
    }

    private function options($param, $o_val = 0)
    {
        $strings = '';
        foreach($param as $id => $name)
        {
            $selected = '';
            if($id == $o_val)
            {
                $selected = 'selected';
            }
            $strings .= "<option value='{$id}' {$selected}>{$name}</option>";
        }
        return $strings;
    }
}