<?php
/**
 * 板块模型
 */
class BlocksMod extends Model
{
	public function BlocksMod()
	{
		$this->Model();
	}
	//读取风格信息
	public function getstsname($stid)
	{
		$d = $this->get_row('SELECT sname FROM '.DB_MX_PRE.'mod_topicstyle WHERE id="'.$stid.'"');
		return $d['sname'];
	}
	//获取板块模型列表
	public function getlist($stid)
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'mod_blocks WHERE stid="'.$stid.'" ORDER BY sort ASC');
	}
	//新增板块模型
	public function add()
	{
		$items = $this->get_fields(DB_MX_PRE.'mod_blocks',array('cdate'));
		$this->insert(DB_MX_PRE.'mod_blocks',$items);
	}
	//修改板块模型
	public function edit($id)
	{
		$items = $this->get_fields(DB_MX_PRE.'mod_blocks',array('stid','cdate'));
		$this->update(DB_MX_PRE.'mod_blocks',$items,'id="'.$id.'"');
	}
	//删除板块模型
	public function del($id)
	{
		$this->delete(DB_MX_PRE.'mod_blocks','id="'.intval($id).'"');
	}
	//获取单条板块模型信息
	public function getinfo($id)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'mod_blocks WHERE id="'.$id.'"');
	}
}
?>