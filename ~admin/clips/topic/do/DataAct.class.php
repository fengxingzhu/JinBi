<?php
/**
 * 专题管理
 */
class DataAct extends Action
{
	//数据库对象
	private $mod = '';
	/**
	 * 构造函数
	 */
	public function DataAct()
	{
		$this->mod = $this->M('Data');
		$userinfo = Cache::session_get("MXUSER_INFO");
		$this->assign('PWGRADE',$userinfo['pwgrade']);
	}
	/**
	 * 获取专题列表
	 */
	public function getlist()
	{
		return $this->mod->getlist();
	}
	/**
	 * 新增专题
	 */
	public function add()
	{
		$this->mod->add();
		echo json_encode(array('type'=>'ajaxcontent','url'=>'clips/topic/?app.html'));
	}
	/**
	 * 通过ID获取专题信息
	 */
	public function getinfo()
	{
		$d = $this->mod->getinfo($_GET['id']);
		$this->assign('info',$d);
		$this->assign('data',json_encode($d));
	}
	/**
	 * 修改专题
	 */
	public function edit()
	{
		$this->mod->edit($_GET['id']);
		echo json_encode(array('type'=>'ajaxcontent','url'=>'clips/topic/?app.html'));
	}
	/**
	 * 删除专题
	 */
	public function del()
	{
		$this->mod->del($_GET['id']);
	}
}
?>