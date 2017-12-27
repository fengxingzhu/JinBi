<?php
/**
 * 获取广告代码
 */
class AdvAct extends Action
{
	//数据库句柄
	private $mod = '';
	public function AdvAct()
	{
		$this->mod = $this->M('Adv');
	}
	/**
	 * 通过ID获取模型信息
	 */
	public function getcode()
	{
		$d = $this->mod->getinfo($_GET['id']);
		echo $d['dofun'];
	}
}
?>