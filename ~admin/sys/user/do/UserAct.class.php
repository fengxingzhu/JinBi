<?php
/**
 * 系统用户管理
 */
class UserAct extends Action
{
	private $mod = '';
	private $UID = '';
	private $userinfo = '';
	public function UserAct()
	{
		$this->UID = Cache::session_get("IMUSER_UID");
		$this->userinfo = Cache::session_get("MXUSER_INFO");
		$this->mod = $this->M('User');
	}
	//读取用户
	public function getlist()
	{
		$data = $this->mod->getlist($this->userinfo);
		$this->assign('data',$data);
	}
	//获得个人用户信息
	public function getuserinfo()
	{
		$d = $this->mod->getuserinfo($_GET['id']);
		$this->assign('data',json_encode($d));
		$this->assign('info',$d);
	}
	//新增用户
	public function add()
	{
		$n = $this->mod->useris($_POST['username']);
		if($n>0){
			echo json_encode(array('type'=>'msg','msg'=>'该用户名已经存在,请更换!'));
			exit();
		}
		$this->mod->add($this->userinfo);
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/user/?app.html'));
	}
	//修改用户
	public function edit()
	{
		$n = $this->mod->useris($_POST['username'],$_GET['id']);
		if($n>0){
			echo json_encode(array('type'=>'msg','msg'=>'该用户名已经存在,请更换!'));
			exit();
		}
		$this->mod->edit($_GET['id']);
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/user/?app.html'));
	}
	//重置密码
	public function editpw()
	{
		$this->mod->editpw($_GET['id']);
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/user/?app.html'));
	}
	//删除用户
	public function del()
	{
		$ids = !empty($_GET['id'])?$_GET['id']:$_POST['ids'];
		$this->mod->del($ids);
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/user/?app.html'));
	}
	//读取用户组
	public function getgroups()
	{
		return $this->mod->getgroup($this->UID);
	}
}
?>