<?php

namespace Home\Controller;

class GradeController extends Base
{
    public function index()
    {
        $this->assign('showData', D('Grade')->gradeList(
            $this->platform_id,
            $this->user_id,
            (I('type', 0, 'intval') ? 1 : 0)
        ));
        $this->display();
    }

    // 创建班级
    public function createClass()
    {
        $class_name = I('post.class_name', '', 'strval');
        if( ! $class_name ){
            ajaxReturn('请填写班级名称');
        }
        $class_img = I('post.class_img', '', 'strval');
        if( ! $class_img ){
            ajaxReturn('请选择班级封面');
        }
        $type =  (I('post.type', 0, 'strval') ? 1 : 0);
        $class_price =  I('post.class_price', '', 'strval');
        $class_describe =  I('post.class_describe', '', 'strval');
        if(D('Grade')->setGrade($this->platform_id, $this->user_id,
            $class_price, $class_describe, $class_name, $class_img, 0, $type) === false){
            ajaxReturn('操作失败');
        }
        ajaxReturn('操作成功', 0);
    }

    public function homework()
    {
        // homework
        $this->display();
    }

    public function add_student(){
        $this->display();
    }

}