<?php
/**
 * 创建应用
 */
class AddAppsMod extends Model
{
	public function AddAppsMod()
	{
		$this->Model();
	}
	//组件实例
	public function getlivs($id)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'applivs WHERE id="'.$id.'"');
	}
	//表单属性
	public function formatr($appid)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'forms WHERE appid="'.$appid.'"');
	}
	//字段列表
	public function getfielddata($appid)
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'fields WHERE appid="'.$appid.'" ORDER BY sort ASC');
	}
}
?>