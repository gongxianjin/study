<?php

namespace Admin\Widget;

class SelectWidget
{
    public function selectClassify($_classify_id = 0)
    {
        return $this->options(W('List/classify'), $_classify_id);
    }

    public function selectGoodsType($goods_type_id = 0)
    {
        return $this->options(W('List/GoodsType'), $goods_type_id);
    }
    public function selectLevel($classify_id, $_level_id = 0)
    {
        return $this->options(W('List/classify_level', array($classify_id)), $_level_id);
    }

    public function platform($value=0)
    {
        return $this->options(W('List/platform'), $value);
    }

    private function options($select, $_value)
    {
        $strings = "<option value='0'>请选择...</option>";
        foreach($select as $value => $name)
        {
            $selected = '';
            if($value == $_value){
                $selected = "selected";
            }
            $strings .= "<option value='{$value}' {$selected} >{$name}</option>";
        }
        return $strings;
    }
}