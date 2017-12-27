<?php
/**
 * 登录日志
 */
class LlogsAct extends Action
{
	private $mod = '';
	public function LlogsAct()
	{
		$this->mod = $this->M('Llogs');
	}
	//读取日志
	public function glist()
	{
		$_GET['page'] = $_POST['page'];
		$page = $this->mod->getlist($_POST['rp']);
		$data = $this->mod->get_all();
		echo json_encode(array('rows'=>$data,'page'=>$_GET['page'],'total'=>$page['total']));
	}
	//删除
	public function del()
	{
		$this->mod->del($_POST['ids']);
	}
}
?>