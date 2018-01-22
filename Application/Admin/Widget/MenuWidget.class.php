<?php

namespace Admin\Widget;

class MenuWidget
{
    private $menuList = array(

        'library' => array( 'name' => '图书管理', 'child' => array(
             'classify' => array('name'=> '分类列表', 'menu_id' => 1),
             'level' => array('name'=> '分级列表', 'menu_id' => 1),
//             'edit' => array('name'=> '图书分级', 'menu_id' => 1),
             'book_list' => array('name'=> '图书列表', 'menu_id' => 1),
        )),

        'classes' => array( 'name' => '班级管理', 'child' => array(
            'index' => array('name'=> '班级列表', 'menu_id' => 1),
//            'class_list' => array('name'=> '班级列表', 'menu_id' => 1),
        )),

        'weixin' => array( 'name' => '微信管理', 'child' => array(
            'index' => array('name'=> '微信列表', 'menu_id' => 1),
        )),

        'user' => array( 'name' => '用户管理', 'child' => array(
             'index' => array('name'=> '用户列表', 'menu_id' => 1),
             'exchange' => array('name'=> '兑换记录', 'menu_id' => 1),
        )),

        'score' => array( 'name' => '积分商城', 'child' => array(
            'index' => array('name'=> '物品列表', 'menu_id' => 1),
             'goods_type' => array('name'=> '物品类型', 'menu_id' => 1),
        )),
    );


    public function getMenuList()
    {
        $controller = lcfirst(CONTROLLER_NAME);
        $action = lcfirst(ACTION_NAME);
        if( isset($this->menuList[$controller]['child'][$action]) ){
            $this->menuList[$controller]['active'] = $action;
        }
        return $this->menuList;
    }


    public function getMenuName($prefix = "")
    {
        $controller = lcfirst(CONTROLLER_NAME);
        $action = lcfirst(ACTION_NAME);
        if( isset($this->menuList[$controller]['child'][$action]) ){
            return $prefix . $this->menuList[$controller]['child'][$action]['name'];
        }
        return $prefix . '首页';
    }

}