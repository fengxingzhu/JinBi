<?php
/**
 * 消息列表
 */
class MsgsMod extends Model
{
	public function MsgsMod()
	{
		$this->Model();
	}
	//获取列表
	public function getlist($s)
	{
		//默认排序
		$sortkey = empty($_POST['sortname'])?'id':$_POST['sortname'];
		$sortval = empty($_POST['sortorder'])?'DESC':$_POST['sortorder'];
		$this->set_sql('SELECT c1.*,c2.nickname FROM '.DB_MX_PRE.'wx_msgs AS c1 LEFT JOIN '.DB_MX_PRE.'wx_user AS c2 ON (c1.openid=c2.openid) ORDER BY '.$sortkey.' '.$sortval);
		return $this->page_mod($s);
	}
}
?>