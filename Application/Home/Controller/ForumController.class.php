<?php

namespace Home\Controller;

class ForumController extends Base
{
    public function bbs_list()
    {
        $forumModel = new \Home\Model\ForumModel();
        $list = $forumModel->bbsList();
        foreach($list as $k => $item)
        {
            $list[$k]['head_img'] = imageDomain($item['head_img']);
            $list[$k]['time'] = date('Y-m-d H:i:s', $item['time']);
        }
        ajaxReturn('success', 0, array('content'=>$list));
        ajaxReturn('success', 0, array());
    }

    public function release()
    {
        $content = I('post.content', '', 'strval');
        if( ! $content ){
            ajaxReturn('缺少参数');
        }
        $images = I('post.images', array());
        $forumModel = new \Home\Model\ForumModel();
        if( ! $forumModel->addForum($this->platform_id, $this->user_id, $content, is_array($images)?$images:array())){
            ajaxReturn('发布失败');
        }
        ajaxReturn('发布成功', 0);
    }
}