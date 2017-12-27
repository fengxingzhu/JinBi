<?php
/**
 * 修改用户信息
 */
class EditUserAct extends Action
{
	private $userinfo = '';
	public function EditUserAct()
	{
		$this->userinfo = Cache::session_get("MXUSER_INFO");
	}
	//修改密码
	public function edpwinfo()
	{
		if($_POST['oldpassword']==""){
			die("请填写原密码");
		}
		if($_POST['password']==""){
			die("请填写新密码");
		}
		if($_POST['password']!=$_POST['repassword']){
			die("两次输入的密码不一致!");
		}
		$m = $this->M('EditUser');
		$is = $m->ismypw($this->userinfo['id']);
		if(empty($is)){
			die("原密码输入错误!");
		}
		$m->editpw($this->userinfo['id']);
		echo "1";
	}
}
?>