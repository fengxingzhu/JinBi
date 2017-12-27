<?php
/**
 * 公共处理
 */
class CommonAct extends Action
{
	//手动排序
	public function handsort()
	{
		//判断用户状态
		PlugsUserPassAct::islogin('../');
		$m = $this->M('Common');
		$m->handsort($_POST['ids'],$_POST['vals'],$_POST['dbname'],$_POST['sortfd']);
	}
	//批量删除
	public function moredelete()
	{
		//判断用户状态
		PlugsUserPassAct::islogin('../');
		$m = $this->M('Common');
		$m->moredelete($_POST['ids'],$_POST['dbname']);
	}
}
?>