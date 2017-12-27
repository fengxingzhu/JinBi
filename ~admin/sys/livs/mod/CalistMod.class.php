<?php
/**
 * 文件缓存
 */
class CalistMod extends Model
{
	public function CalistMod()
	{
		$this->Model();
	}
	//读取文件缓存列表
	public function getflist($fid)
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'appcalist WHERE appid="'.$fid.'" ORDER BY id ASC');
	}
	//新增
	public function add()
	{
		$items = $this->get_fields(DB_MX_PRE.'appcalist');
		$this->insert(DB_MX_PRE.'appcalist',$items);
	}
	//获取信息
	public function getinfo($id)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'appcalist WHERE id="'.$id.'"');
	}
	//修改
	public function edit($id)
	{
		$items = $this->get_fields(DB_MX_PRE.'appcalist');
		$this->update(DB_MX_PRE.'appcalist',$items,'id="'.$id.'"');
	}
	//删除
	public function del($id)
	{
		$this->delete(DB_MX_PRE.'appcalist','id="'.$id.'"');
	}
	//获取实例名称
	public function getappname($id)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'applivs WHERE id="'.$id.'"');
	}
}
?>