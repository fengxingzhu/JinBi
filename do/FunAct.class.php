<?php
/**
 * 相关处理
 */
class FunAct extends Action
{
	private $mod = '';
	public function FunAct()
	{
		$this->mod = $this->M('Fun');
	}

	public function add()
	{
		$this->mod->addition();
		redirect($_POST['jumpurl'],2,'添加成功!');
	}
	public function app()
	{
		var_dump(123456);die;
	}
}
?>