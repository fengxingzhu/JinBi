<?php
/**
 * 风格管理
 */
class TStyleMod extends Model
{
	public function TStyleMod()
	{
		$this->Model();
	}
	//获取风格列表
	public function getlist()
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'mod_topicstyle');
	}
	//新增风格
	public function add()
	{
		$items = $this->get_fields(DB_MX_PRE.'mod_topicstyle');
		$this->insert(DB_MX_PRE.'mod_topicstyle',$items);
	}
	//修改风格
	public function edit($id)
	{
		$items = $this->get_fields(DB_MX_PRE.'mod_topicstyle');
		$this->update(DB_MX_PRE.'mod_topicstyle',$items,'id="'.$id.'"');
	}
	//删除风格
	public function del($id)
	{
		$this->delete(DB_MX_PRE.'mod_topicstyle','id="'.intval($id).'"');
	}
	//获取单条风格信息
	public function getinfo($id)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'mod_topicstyle WHERE id="'.$id.'"');
	}
}
?>