<?php
/**
 * 粉丝
 */
class FansMod extends Model
{
	public function FansMod()
	{
		$this->Model();
	}
	//获取列表
	public function getlist($s)
	{
		//默认排序
		$sortkey = empty($_POST['sortname'])?'id':$_POST['sortname'];
		$sortval = empty($_POST['sortorder'])?'DESC':$_POST['sortorder'];
		$this->set_sql('SELECT * FROM '.DB_MX_PRE.'wx_user ORDER BY '.$sortkey.' '.$sortval);
		return $this->page_mod($s);
	}
}
?>