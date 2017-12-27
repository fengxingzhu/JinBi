<?php
/**
 * 导出设置
 */
class OutputMod extends Model
{
	public function OutputMod()
	{
		$this->Model();
	}
	//读取导出列表
	public function getflist()
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'outputsets ORDER BY sort ASC');
	}
	//新增
	public function add()
	{
		$items = $this->get_fields(DB_MX_PRE.'outputsets');
		$this->insert(DB_MX_PRE.'outputsets',$items);
	}
	//获取信息
	public function getinfo($id)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'outputsets WHERE id="'.$id.'"');
	}
	//修改
	public function edit($id)
	{
		$items = $this->get_fields(DB_MX_PRE.'outputsets');
		$this->update(DB_MX_PRE.'outputsets',$items,'id="'.$id.'"');
	}
	//删除
	public function del($id)
	{
		$this->delete(DB_MX_PRE.'outputsets','id="'.$id.'"');
	}
	//获取实例名称
	public function getappname($id)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'applivs WHERE id="'.$id.'"');
	}
}
?>