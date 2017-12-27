<?php
/**
 * 用户信息
 */
class EditUserMod extends Model
{
	public function EditUserMod()
	{
		$this->Model();
	}
	//验证原密码是否正确
	public function ismypw($uid)
	{
		return $this->get_num('SELECT * FROM '.DB_MX_PRE.'user WHERE id="'.$uid.'" AND password="'.md5($_POST['oldpassword']).'"');
	}
	//修改密码
	public function editpw($uid)
	{
		$_POST['password'] = md5($_POST['password']);
		$this->update(DB_MX_PRE.'user',array('password'),'id="'.$uid.'"');
	}
}
?>