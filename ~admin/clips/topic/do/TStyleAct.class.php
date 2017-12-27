<?php
/**
 * 风格管理
 */
class TStyleAct extends Action
{
	//数据库对象
	private $mod = '';
	/**
	 * 构造函数
	 */
	public function TStyleAct()
	{
		$this->mod = $this->M('TStyle');
	}
	/**
	 * 获取风格列表
	 */
	public function getlist()
	{
		return $this->mod->getlist();
	}
	/**
	 * 新增风格
	 */
	public function add()
	{
		$this->mod->add();
		echo json_encode(array('type'=>'ajaxcontent','url'=>'clips/topic/?stindex.html'));
	}
	/**
	 * 通过ID获取风格信息
	 */
	public function getinfo()
	{
		$d = $this->mod->getinfo($_GET['id']);
		$this->assign('info',$d);
		$this->assign('data',json_encode($d));
	}
	/**
	 * 修改风格
	 */
	public function edit()
	{
		$this->mod->edit($_GET['id']);
		echo json_encode(array('type'=>'ajaxcontent','url'=>'clips/topic/?stindex.html'));
	}
	/**
	 * 删除风格
	 */
	public function del()
	{
		$this->mod->del($_GET['id']);
	}
}
?>