<?php
/**
 * 系统用户管理
 */
class UserMod extends Model
{
	public function UserMod()
	{
		$this->Model();
	}
	//获取用户
	public function getlist($user)
	{
		$sql = $user['pwgrade']=='1'?'':' AND c1.puid="'.$user['id'].'"';
		return $this->get_all('SELECT c1.*,c2.title FROM '.DB_MX_PRE.'user AS c1 LEFT JOIN '.DB_MX_PRE.'mgroup AS c2 ON (c1.gid=c2.id) WHERE c1.pwgrade=0 AND c1.langtp="'.$user['langtp'].'"'.$sql.' ORDER BY c1.cdate DESC');
	}
	//查看用户是否已经存在
	public function useris($u,$id = '')
	{
		if(empty($id)){
			$d = $this->get_num('SELECT id FROM '.DB_MX_PRE.'user WHERE username="'.$u.'"');
			return empty($d)?0:$d;
		}else{
			$d = $this->get_num('SELECT id FROM '.DB_MX_PRE.'user WHERE username="'.$u.'" AND id!="'.$id.'"');
			return empty($d)?0:$d;
		}
	}
	//新增用户
	public function add($user)
	{
		$_POST['puid'] = $user['id'];
		$_POST['password'] = md5('mxpassword'); //默认密码
		$_POST['langtp'] = $user['langtp']; //多站点
		$_POST['pwgrade'] = 0; //后台会员级别
		$items = $this->get_fields(DB_MX_PRE.'user',array('cdate'));
		$this->insert(DB_MX_PRE.'user',$items);
	}
	//获得个人用户信息
	public function getuserinfo($id)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'user WHERE id="'.$id.'"');
	}
	//修改用户
	public function edit($id)
	{
		$items = $this->get_fields(DB_MX_PRE.'user',array('password','puid','langtp','pwgrade','cdate'));
		$this->update(DB_MX_PRE.'user',$items,'id="'.$id.'"');
	}
	//重置密码
	public function editpw($id)
	{
		$_POST['password'] = md5('123456');
		$this->update(DB_MX_PRE.'user',array('password'),'id="'.$id.'"');
	}
	//删除用户
	public function del($id)
	{
		$this->delete(DB_MX_PRE.'user','id IN('.$id.')');
	}
	//读取用户组
	public function getgroup($uid)
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'mgroup WHERE uid="'.$uid.'" ORDER BY id DESC');
	}
}
?>