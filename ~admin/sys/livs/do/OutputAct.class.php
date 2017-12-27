<?php
/**
 * 导出设置
 */
class OutputAct extends Action
{
	private $mod = '';
	public function OutputAct()
	{
		$this->mod = $this->M('Output');
	}
	//获取列表
	public function getlist()
	{
		$data = $this->mod->getflist();
		$this->assign('data',$data);
	}
	//新增缓存列表
	public function add()
	{
		if($_POST['url']!='' && !isedwtpl($_POST['url'])){
			echo json_encode(array('type'=>'msg','msg'=>'前台连接填写错误,请检查!'));
			exit();
		}
		$this->mod->add();
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/livs/?outputlist/fid/'.$_POST['appid'].'.html'));
	}
	//获取信息
	public function getinfo()
	{
		$info = $this->mod->getinfo($_GET['id']);
		$this->assign('info',$info);
		$this->assign('data',json_encode($info));
	}
	//修改
	public function edit()
	{
		if($_POST['url']!='' && !isedwtpl($_POST['url'])){
			echo json_encode(array('type'=>'msg','msg'=>'前台连接填写错误,请检查!'));
			exit();
		}
		$this->mod->edit($_GET['id']);
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/livs/?outputlist/fid/'.$_POST['appid'].'.html'));
	}
	//删除
	public function del()
	{
		$this->mod->del($_GET['id']);
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/livs/?outputlist/fid/'.$_GET['fid'].'.html'));
	}
	//获取实例名称
	public function getapplivs()
	{
		$info = $this->mod->getappname($_GET['fid']);
		$this->assign('applivs',$info);
	}
}
?>