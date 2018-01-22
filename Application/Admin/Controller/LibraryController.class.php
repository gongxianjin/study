<?php

namespace Admin\Controller;


class LibraryController extends Base
{
    public function classify()
    {
        $this->assign(D('BookClassify')->getClassifyList($this->platform_id, I('name', '')));
        $this->display();
    }

    public function level()
    {
        $this->assign(D('ClassifyLevel')->getLevelList(
            $this->platform_id,
            I('name', ''),
            I('classify_id', 0, 'intval')
        ));
        $this->display();
    }

    public function book_list()
    {
        $this->assign(D('Book')->getBookList(
            $this->platform_id,
            I('name', '')
        ));
        $this->display();
    }
/*====================================================================================================================*/
    public function getLevelList()
    {
        $where['classify_id'] = I('classify_id', 0, 'intval');
        if( $this->platform_id ){
            $where['platform_id'] = $this->platform_id;
        }
        $this->success(D('ClassifyLevel')->where($where)->getField('id,name'));
    }
/*====================================================================================================================*/

    public function setClassify()
    {
        $classify = I('post.classify', '', '');
        if( ! $classify ){
            $this->error('请填写分类名称');
        }
        $classify_img = I('post.classify_img', '', '');
        if( ! $classify_img ){
            $this->error('请上传分类图标');
        }
        $classify_id = I('post.classify_id', 0, 'intval');
        $bookClassify = D('BookClassify');
        if( ! $classify_id && $bookClassify->checkClassifyName($classify)) {
            $this->error('该分类已添加');
        }
        if( $bookClassify->setClassify($this->platform_id,
                $classify_id, $classify, $classify_img) === false )
        {
            $this->error('操作失败');
        }
        $this->success('操作成功');
    }

    public function setLevel()
    {
        $level_name = I('post.level_name', '', '');
        if( ! $level_name ){
            $this->error('请填写分类名称');
        }
        $classify_id = I('post.classify_id', 0, 'intval');
        if( ! $classify_id ){
            $this->error('请选择分类');
        }
        $level_id = I('post.level_id', 0, 'intval');
        $levelModel = D('ClassifyLevel');
        $levelInfo =  $level_id ? $levelModel->findFirst($level_id) : array();
        if(isset($levelInfo['id']) && $levelInfo['classify_id'] == $classify_id && $levelInfo['name'] == $level_name){
            $this->error('该等级已在分类下添加');
        }
        if( $levelModel->setLevel($this->platform_id, $level_id, $classify_id, $level_name) === false ){
            $this->error('操作失败');
        }
        $this->success('操作成功');
    }

    public function setBooks()
    {
        $book_name = I('book_name', '', 'strval');
        if( ! $book_name ){
            $this->error('请填写图书名称');
        }
        $cover_img = I('cover_img', '', 'strval');
        if( ! $cover_img ){
            $this->error('请选择图书封面');
        }
        $classify_id = I('classify_id', 0, 'intval');
        if( ! $cover_img ){
            $this->error('请选择图书所属的分类');
        }
        $level_id = I('level_id', 0, 'intval');
        if( ! $cover_img ){
            $this->error('请选择图书所属的分级');
        }
        $book_id = I('book_id', 0, 'intval');

        $bookModel = D('Book');
        if(!$book_id && $bookModel->checkBookName($this->platform_id, $classify_id, $level_id,
                $this->admin_id, $book_name)
        ){
            $this->error('该图书已添加');
        }

        $book_id = $bookModel->setBook($this->platform_id, $book_id, $book_name,
            $cover_img, $classify_id, $level_id, $this->admin_id);
        if( ! $book_id ){
            $this->error('操作失败');
        }

        $res = array();
        $temp = array('book_id'=>$book_id,'name'=>'','image'=>'','audio'=>'','video'=>'','desc'=>'');
        foreach(I('res', array()) as $fileInfo => $re)
        {
            list($type, $filename) = explode('_', $fileInfo, 2);
            if( ! isset($temp[$type]))
            {
                continue;
            }
            $res[$filename] = $temp;
            $res[$filename]['name'] = $filename;
            $res[$filename][$type] = $re;
        }

        $bookResModel = D('BookRes');
        $bookResModel->resDelete($book_id);
        if( $res )
        {
            ksort($res);
            $bookResModel->addRes(array_values($res));
        }
        $this->success('操作成功');
    }

    public function edit()
    {
        layout(false);
        $book_id = I('book_id', 0, 'intval');
        $bookFindFirst = $book_id ? D('Book')->findFirst($this->platform_id, $book_id) : false;
        if( $bookFindFirst )
        {
            $this->assign($bookFindFirst);
            $this->assign('res', D('BookRes')->getResList($book_id));
        }
        $this->display();
    }
}