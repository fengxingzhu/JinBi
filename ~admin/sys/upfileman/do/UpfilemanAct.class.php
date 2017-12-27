<?php
/**
 * 文件上传管理
 */
class UpfilemanAct extends Action
{
	public function UpfilemanAct()
	{
		
	}
	//读取可上传文件后缀
	public function getlist()
	{
		$m = $this->M('Upfileman');
		$data = $m->readfilters();
		$this->assign('filterslist',$data);
	}
	//得到分类信息
	public function getdata()
	{
		$m = $this->M('Upfileman');
		$info = $m->getdata($_GET['id']);
		$this->assign('info',$info);
		$this->assign('data',json_encode($info));
	}
	//新增
	public function add()
	{
		$m = $this->M('Upfileman');
		$m->add();
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/upfileman/?app.html'));
	}
	//修改信息
	public function edit()
	{
		$m = $this->M('Upfileman');
		$m->edit($_GET['id']);
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/upfileman/?app.html'));
	}
	//删除
	public function del()
	{
		$m = $this->M('Upfileman');
		$ids = !empty($_GET['id'])?$_GET['id']:$_POST['ids'];
		$m->del($ids);
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/upfileman/?app.html'));
	}
	//最大文件大小
	public function upfilemax()
	{
		$data = read_cache_data('mx-filesizemax');
		if(empty($data)){
			$data['size'] = UPLOAD_MAXSIZE;
		}
		$this->assign('maxsizeinfo',intval($data['size']));
	}
	//修改最大能上传的文件大小
	public function editmaxsize()
	{
		$intval = intval($_POST['size']);
		if($intval<1){
			echo "文件大小 大于0";
		}else{
			write_cache_data(array('size'=>$intval),'mx-filesizemax');
		}
	}
}
?>