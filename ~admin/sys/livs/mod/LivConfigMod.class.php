<?php
/**
 * 实例配置
 */
class LivConfigMod extends Model
{
	public function LivConfigMod()
	{
		$this->Model();
	}
	//获取实例
	public function getlivs($id)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'applivs WHERE id="'.$id.'"');
	}
	//保存配置
	public function saveconf($id)
	{
		$this->update(DB_MX_PRE.'applivs',array('cfg_add_key','cfg_edit_key','cfg_del_key','cfg_page_key','cfg_handsort_key','cfg_brower_key','cfg_top_key','cfg_pub_key','cfg_excelin_key','cfg_excelout_key'),'id="'.$id.'"');
	}
}
?>