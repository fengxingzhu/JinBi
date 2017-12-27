<?php
/**
 * 广告模型
 */
class AdvmodMod extends Model
{
	public function AdvmodMod()
	{
		$this->Model();
	}
	//获取模型列表
	public function getlist()
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'mod_advs ORDER BY sort ASC');
	}
	//新增广告模型
	public function add()
	{
		$items = $this->get_fields(DB_MX_PRE.'mod_advs');
		$this->insert(DB_MX_PRE.'mod_advs',$items);
	}
	//修改广告模型
	public function edit($id)
	{
		$items = $this->get_fields(DB_MX_PRE.'mod_advs',array('cdate'));
		$this->update(DB_MX_PRE.'mod_advs',$items,'id="'.$id.'"');
	}
	//获取单个广告模型
	public function getinfo($id)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'mod_advs WHERE id="'.$id.'"');
	}
	//删除模型
	public function del($id)
	{
		$this->delete(DB_MX_PRE.'mod_advs','id="'.$id.'"');
	}
}
?>