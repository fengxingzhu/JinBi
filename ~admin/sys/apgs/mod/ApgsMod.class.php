<?php
/**
 * 应用分组
 */
class ApgsMod extends Model
{
	public function ApgsMod()
	{
		$this->Model();
	}
	//分组列表
	public function getgroups()
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'appgroups ORDER BY gdir ASC');
	}
	//新增分组
	public function add($user)
	{
		$_POST['uid'] = $user['id'];
		$_POST['name'] = $user['name'];
		$items = $this->get_fields(DB_MX_PRE.'appgroups');
		$this->insert(DB_MX_PRE.'appgroups',$items);
	}
	//修改分组信息
	public function edit($id)
	{
		$items = $this->get_fields(DB_MX_PRE.'appgroups',array('uid','name','gdir','typeid'));
		$this->update(DB_MX_PRE.'appgroups',$items,'id="'.$id.'"');
	}
	//删除分组
	public function del($id)
	{
		$this->delete(DB_MX_PRE.'appgroups','id="'.$id.'"');
	}
	//分组信息
	public function getginfo($id)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'appgroups WHERE id="'.$id.'"');
	}
}
?>