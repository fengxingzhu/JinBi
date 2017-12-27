<?php
/**
 * 广告管理
 */
class DataAct extends Action
{
	//数据库句柄
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
	 * 获取模型列表
	 */
	public function getlist()
	{
		return $this->mod->getlist();
	}
	/**
	 * 新增模型
	 */
	public function add()
	{
		$this->mod->add();
		echo json_encode(array('type'=>'ajaxcontent','url'=>'clips/adv/?app.html'));
	}
	/**
	 * 通过ID获取模型信息
	 */
	public function getinfo()
	{
		$d = $this->mod->getinfo($_GET['id']);
		$this->assign('info',$d);
		$this->assign('data',json_encode($d));
	}
	/**
	 * 修改模型
	 */
	public function edit()
	{
		$this->mod->edit($_GET['id']);
		echo json_encode(array('type'=>'ajaxcontent','url'=>'clips/adv/?app.html'));
	}
	/**
	 * 删除模型
	 */
	public function del()
	{
		$this->mod->del($_GET['id']);
	}
	/**
	 * 编辑广告
	 */
	public function advdata()
	{
		$this->mod->advdata($_GET['id']);
		echo json_encode(array('type'=>'ajaxcontent','url'=>'clips/adv/?app.html'));
	}
	/**
	 * 预览广告信息
	 */
	public function gettview()
	{
		$d = $this->mod->gettview($_GET['id']);
		$this->assign('info',$d);
	}
}
?>