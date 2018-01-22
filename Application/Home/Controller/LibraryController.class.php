<?php

namespace Home\Controller;

class LibraryController extends Base
{
    public function index()
    {
        $classify_id = I('get.classify_id', 1, 'intval');
        $this->assign('levelList', D('ClassifyLevel')->levelList($classify_id, $this->platform_id));
        $this->display();
    }

    public function book_list()
    {
        $this->assign('bookList', D('Book')->bookList($this->platform_id, I('level_id', 0, 'intval')));
        $this->display();
    }

    public function book()
    {
        $book_id = I('get.book_id', 0, 'intval');
        $this->assign('bookInfo', D('Book')->findFirst($book_id));
        $this->display();
    }

    public function bookRes()
    {
        ajaxReturn('success', 0, D('BookRes')->where(array(
            'book_id' => I('get.book_id', 0, 'intval')
        ))->getField('id,name', true));
    }

    public function setTask()
    {
        $grade_id = I('post.grade_id', 0, 'intval');
        if( ! $grade_id ){
            ajaxReturn('缺少参数');
        }
        $book_id = I('post.book_id', 0, 'intval');
        if( ! $book_id ){
            ajaxReturn('请选择课本');
        }
        $start_book  = I('post.start_book', 0, 'intval');
        if( ! $start_book ){
            ajaxReturn('请选择开始阅读课文');
        }
        $end_book = I('post.end_book', 0, 'intval');
        if( ! $end_book ){
            ajaxReturn('请选择结束阅读课文');
        }
        $count = I('post.count', 0, 'intval');
        if( ! $count ){
            ajaxReturn('请输入每天阅读课数');
        }
        $day = I('post.day', 0, 'intval');
        if( ! $day ){
            ajaxReturn('请输入需要天数');
        }
        if(D('TaskList')->setTask($grade_id, $book_id, $start_book, $end_book, $count, $day) === false){
            ajaxReturn('操作失败');
        }
        ajaxReturn('操作成功', 0);
    }

    // 添加学员

    // 学员列表
    public function studentList()
    {
        $grade_id = I('post.grade_id', 0, 'intval');
        if( ! $grade_id ){
            ajaxReturn('缺少参数');
        }
        $book_id = I('post.book_id', 0, 'intval');
        if( ! $book_id ){
            ajaxReturn('请选择课本');
        }
        $start_book  = I('post.start_book', 0, 'intval');
        if( ! $start_book ){
            ajaxReturn('请选择开始阅读课文');
        }
        $end_book = I('post.end_book', 0, 'intval');
        if( ! $end_book ){
            ajaxReturn('请选择结束阅读课文');
        }
        $count = I('post.count', 0, 'intval');
        if( ! $count ){
            ajaxReturn('请输入每天阅读课数');
        }
        $day = I('post.day', 0, 'intval');
        if( ! $day ){
            ajaxReturn('请输入需要天数');
        }
        if(D('TaskList')->setTask($grade_id, $book_id, $start_book, $end_book, $count, $day) === false){
            ajaxReturn('操作失败');
        }
        ajaxReturn('操作成功', 0);
    }


}