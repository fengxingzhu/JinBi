<?php
/**
 * 专题管理
 */
class DataMod extends Model
{
	public function DataMod()
	{
		$this->Model();
	}
	//获取专题列表
	public function getlist()
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'mod_topic ORDER BY sort ASC');
	}
	//新增专题
	public function add()
	{
		$items = $this->get_fields(DB_MX_PRE.'mod_topic',array('cdate'));
		$this->insert(DB_MX_PRE.'mod_topic',$items);
	}
	//修改专题
	public function edit($id)
	{
		$items = $this->get_fields(DB_MX_PRE.'mod_topic',array('data','cdate'));
		$this->update(DB_MX_PRE.'mod_topic',$items,'id="'.$id.'"');
	}
	//删除专题
	public function del($id)
	{
		$this->delete(DB_MX_PRE.'mod_topic','id="'.intval($id).'"');
	}
	//获取单条专题信息
	public function getinfo($id)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'mod_topic WHERE id="'.$id.'"');
	}
}
?>