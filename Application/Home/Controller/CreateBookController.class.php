<?php
namespace Home\Controller;
/*
* 晨曦
* 教师端 - 创建作业
*/
class CreateBookController extends Base{

	public function index(){
		$this->assign('book_id',0);
		$this->display();
	}

	//获取课文列表
	public function getTextBooks(){
		if ($this->user_type == 1) {
			//教师
			$teacher_id = $this->user_id;
			$res = D('BookRes')->getTextBooks($teacher_id);
			// echo json_encode($res);
			$this->ajaxReturn($res);

		}else{
			$this->error("权限不足");
		}

	}

	//获取课本列表
	public function getBooks(){
		if ($this->user_type == 1) {
			//教师
			$teacher_id = $this->user_id;
			$res = D('Book')->getBooks($teacher_id);
			// echo json_encode($res);
			$this->ajaxReturn($res);
		}else{
			$this->error("权限不足");
		}
	}

	//合成预览
	public function previewBook(){
		echo "合成预览";
	}

	//获取单个课本信息
	public function getBook(){
		if ($this->user_type == 1) {
			//教师
			$teacher_id = $this->user_id;
			$id = I('post.id');
			$res = M('Book')->where('id = ' . $id)->find();
			// echo json_encode($res);
			$this->ajaxReturn($res);
		}else{
			$this->error("权限不足");
		}
	}

	//保存课本
	public function saveBook(){
		//发布还是保存
		
		$post = I('post.');
		$status = $post['isPublish'];
		//上传图片
		//封面图片处理
		$upload = new \Common\Model\Upload();
		$file = $_FILES['book_cover_img'];
		$cover_img = md5($file['tmp_name']) . '.' . end(explode('.', $file['name']));
		$upRes = $upload->upload($cover_img,$file['tmp_name']);

		if (!$upRes) {
			ajaxReturn("图片上传失败");
		}

		$book = array(
				'user_id' => $this->user_id,
				'platform_id' => $this->platform_id,
				//临时修改
				'classify_id' => 0,
				'level_id' => 0,
				'type' => 1,
				'name' => $post['bookName'],
				'author' => M('User')->where('id = ' . $this->user_id)->getField('nickname'),
				'press' => "",
				'cover_img' => $cover_img,
				'describe' => "",
				'time' =>time(),
				'status' => $status
			);
		$query = M('Book')->where('id = ' . $post['id'])->save($book);
		if ($query) {
			//上传成功
			ajaxReturn("课本编辑成功");
		}else{
			//失败
			ajaxReturn("课本编辑失败,请联系管理员");
		}
	}

	public function createBook(){
		//发布还是保存
		
		$post = I('post.');
		$status = $post['isPublish'];
		//上传图片
		//封面图片处理
		$upload = new \Common\Model\Upload();
		$file = $_FILES['book_cover_img'];
		$cover_img = md5($file['tmp_name']) . '.' . end(explode('.', $file['name']));
		$upRes = $upload->upload($cover_img,$file['tmp_name']);

		if (!$upRes) {
			ajaxReturn("图片上传失败");
		}

		$book = array(
				'user_id' => $this->user_id,
				'platform_id' => $this->platform_id,
				//临时修改
				'classify_id' => 0,
				'level_id' => 0,
				'type' => 1,
				'name' => $post['bookName'],
				'author' => M('User')->where('id = ' . $this->user_id)->getField('nickname'),
				'press' => "",
				'cover_img' => $cover_img,
				'describe' => "",
				'time' =>time(),
				'status' => $status
			);
		$query = M('Book')->add($book);
		if ($query) {
			//上传成功
			$textCount = $post['textCount'];
			$book_id = M('Book')->where($book)->getField('id');
			for($i = 1;$i <= $textCount;$i++){
				$textBook = array(
						'book_id' => $book_id,
						'name' => "unit" . $i,
						'image' => $cover_img,
						'audio' => '',
						'vide' => '',
						'desc' => ''

					);
				$query = M('BookRes')->add($textBook);
				if (!$query) {
					//上传文章失败
					ajaxReturn("课本创建失败,请联系管理员");
				}
			}
			ajaxReturn("课本创建成功");
		}else{
			//失败
			ajaxReturn("课本创建失败,请联系管理员");
		}
	}




	//自制课文
	public function createBooktext(){
		// $post = I('post.');
		// $file = $_FILES['file1'];
		// $upload = new \Common\Model\Upload();
		// $filename = md5($file['tmp_name']) . '.' . end(explode('.', $file['name']));
		// echo $filename;
		// $upRes = $upload->upload($filename,$file['tmp_name']);
		// echo "result" . $upRes;

		$post = I('post.');

		$upload = new \Common\Model\Upload();

		//封面图片处理
		$file = $_FILES['cover_img'];
		$cover_img = md5($file['tmp_name']) . '.' . end(explode('.', $file['name']));
		$upRes = $upload->upload($cover_img,$file['tmp_name']);

		if (!$upload) {
			ajaxReturn("部分文件上传失败,请联系管理员");
		}else{
			//创建课本
			$booktext = array(
						
						'book_id' => $post['book_id'],
						'name' => $post['bookName'],
						'image' => $cover_img,
					);
			$BookTextModel = M("BookRes");
			$query = $BookTextModel->add($booktext);
			if($query){
				//课文保存成功
				$booktext_id = M('BookRes')->where($booktext)->getField('id');
				$pageModel = M('BooktextRes');
				$page = $post['unitCount'];
				for($i = 1;$i <= $page;$i++){
					//上传图片
					$imgName = "file1-" . $i;
					$file = $_FILES[$imgName];
					$imgPath = md5($file['tmp_name']) . '.' . end(explode('.', $file['name']));
					$upRes = $upload->upload($imgPath,$file['tmp_name']);
					//上传音频
					$mp3Name = "file2-" . $i;
					$file = $_FILES[$mp3Name];
					$mp3Path = md5($file['tmp_name']) . '.' . end(explode('.', $file['name']));
					$upRes = $upload->upload($mp3Path,$file['tmp_name']);	

					//封装信息
					$bookPage = array(
							'booktext_id' => $booktext_id,
							'content_img' => $imgPath,
							'content_voice' => $mp3Path,
							'time' => time()
						);
					$query = $pageModel->add($bookPage);
					if (!$query) {
						ajaxReturn("课本页面添加失败");
					}
				}

				ajaxReturn("课文保存成功");

			}else{
				//课文创建失败
				ajaxReturn("课文创建失败,请联系管理员");
			}

		}
	}


	// 删除课本
	public function deleteBook(){
		$id = I('post.book_id');
		if (!isset($id)) {
			ajaxReturn("非法操作");
		}

		$query = M('Book')->where('id = ' . $id)->delete();
		if ($query) {
			ajaxReturn("删除成功");
		}else{
			ajaxReturn("删除失败");
		}
	}

	//删除课文
	public function deleteTextBook(){
		$id = I('post.text_id');
		if (!isset($id)) {
			ajaxReturn("非法操作");
		}

		$query = M('BookRes')->where('id = ' . $id)->delete();
		if ($query) {
			ajaxReturn("删除成功");
		}else{
			ajaxReturn("删除失败");
		}
	}

}

?>