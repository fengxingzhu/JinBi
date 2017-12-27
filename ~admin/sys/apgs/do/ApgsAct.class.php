<?php
/**
 * 应用分组
 */
class ApgsAct extends Action
{
	private $mod = '';
	public function ApgsAct()
	{
		$this->mod = $this->M('Apgs');
	}
	//分组列表
	public function getgroups()
	{
		return $this->mod->getgroups();
	}
	//新增
	public function add()
	{
		//判断是否有重名
		$ap = dirname(dirname(dirname(dirname(__FILE__))));
		$curp = $ap.'/'.$_POST['gdir'];
		if(is_dir($curp)){
			echo json_encode(array('type'=>'msg','msg'=>'该分组标识已经存在,请更换!'));
			exit();
		}
		$user = Cache::session_get("MXUSER_INFO");
		$this->mod->add($user);
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/apgs/?app.html'));
	}
	//获得信息
	public function getinfo()
	{
		$d = $this->mod->getginfo($_GET['id']);
		$this->assign('info',$d);
		$this->assign('data',json_encode($d));
	}
	//修改分类
	public function edit()
	{
		$this->mod->edit($_GET['id']);
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/apgs/?app.html'));
	}
	//删除分类
	public function del()
	{
		$this->mod->del($_GET['id']);
	}
}
?>