<?php
/**
 * 用户组
 */
class UgroupMod extends Model
{
	public function UgroupMod()
	{
		$this->Model();
	}
	//读取组
	public function getgroups($user)
	{
		$sql = $user['pwgrade']=='1'?
			'SELECT * FROM '.DB_MX_PRE.'mgroup ORDER BY id DESC':
			'SELECT * FROM '.DB_MX_PRE.'mgroup WHERE uid="'.$user['id'].'" ORDER BY id DESC';
		return $this->get_all($sql);
	}
	//添加组
	public function add($uid)
	{
		$_POST['uid'] = $uid;
		$this->insert(DB_MX_PRE.'mgroup',array('uid','title','powids','syninfo','optools'));
	}
	//删除组
	public function del($id)
	{
		$this->delete(DB_MX_PRE.'mgroup','id="'.$id.'"');
	}
	//获得组信息信息
	public function getinfo($id)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'mgroup WHERE id="'.$id.'"');
	}
	//修改组
	public function edit($id)
	{
		$this->update(DB_MX_PRE.'mgroup',array('title','powids','syninfo','optools'),'id="'.$id.'"');
	}
	//读取栏目
	public function getallcol($user)
	{
		if($user['pwgrade']==1){//超级管理员
			return $this->get_all('SELECT * FROM '.DB_MX_PRE.'menu WHERE langtp="'.$user['langtp'].'" AND id NOT IN(181,1) ORDER BY grade ASC,sort ASC');
		}else{
			$groups = $this->get_row('SELECT powids FROM '.DB_MX_PRE.'mgroup WHERE id="'.$user['gid'].'"');
			return empty($groups['powids'])?array():
				$this->get_all('SELECT * FROM '.DB_MX_PRE.'menu WHERE langtp="'.$user['langtp'].'" AND id IN('.$groups['powids'].') AND id NOT IN(181,1) ORDER BY sort ASC');
		}
	}
	//读取审核级别
	public function getsyngrade($livsid)
	{
		$d = $this->get_row('SELECT syngrade FROM '.DB_MX_PRE.'applivs WHERE id="'.$livsid.'"');
		return $d['syngrade'];
	}
	//判断发布类型
	public function getpubtypes($livsid)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'applivs WHERE id="'.$livsid.'"');
	}
}
?>