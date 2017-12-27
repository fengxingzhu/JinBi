<?php
/**
 * 实例配置
 */
class LivConfigAct extends Action
{
	private $mod = '';
	public function LivConfigAct()
	{
		$this->mod = $this->M('LivConfig');
	}
	//获取实例
	public function getlivs()
	{
		$d = $this->mod->getlivs($_GET['id']);
		$this->assign('info',$d);
	}
	//保存配置
	public function save()
	{
		$this->mod->saveconf($_GET['id']);
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/livs/?app.html'));
	}
}
?>