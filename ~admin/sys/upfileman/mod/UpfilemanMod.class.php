<?php
/**
 * 系统用户管理
 */
class UpfilemanMod extends Model
{
	public function UpfilemanMod()
	{
		$this->Model();
	}
	//写入默认值
	public function readfilters()
	{
		$is = $this->get_num('SELECT id FROM '.DB_MX_PRE.'filters');
		if(empty($is)){
			import('Filters','.');
			$data = Filters::data();
			foreach ($data as $list){
				$_POST['ftype'] = $list['ftype'];
				$_POST['exts'] = $list['exts'];
				$_POST['sort'] = $list['sort'];
				$this->insert(DB_MX_PRE.'filters',array('ftype','exts','sort'));
			}
		}
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'filters ORDER BY sort ASC');
	}
	//得到分类信息
	public function getdata($id)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'filters WHERE id="'.$id.'"');
	}
	//新增信息
	public function add()
	{
		$items = $this->get_fields(DB_MX_PRE.'filters');
		$this->insert(DB_MX_PRE.'filters',$items);
	}
	//删除
	public function del($ids)
	{
		$this->delete(DB_MX_PRE.'filters','id IN('.$ids.')');
	}
	//修改信息
	public function edit($id)
	{
		$items = $this->get_fields(DB_MX_PRE.'filters');
		$this->update(DB_MX_PRE.'filters',$items,'id="'.$id.'"');
	}
}
?>