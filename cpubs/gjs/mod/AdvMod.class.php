<?php
/**
 * 获取广告代码
 */
class AdvMod extends Model
{
	public function AdvMod()
	{
		$this->Model();
	}
	//获取单个广告位
	public function getinfo($id)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'mod_slots WHERE id="'.$id.'"');
	}
}
?>