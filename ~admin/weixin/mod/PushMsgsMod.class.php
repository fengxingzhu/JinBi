<?php
/**
 * 消息推送
 */
class PushMsgsMod extends Model
{
	public function PushMsgsMod()
	{
		$this->Model();
	}
	//获取列表
	public function getlist($s)
	{
		//默认排序
		$sortkey = empty($_POST['sortname'])?'id':$_POST['sortname'];
		$sortval = empty($_POST['sortorder'])?'DESC':$_POST['sortorder'];
		$this->set_sql('SELECT c1.*,c2.nickname FROM '.DB_MX_PRE.'wx_pushmsgs AS c1 LEFT JOIN '.DB_MX_PRE.'wx_user AS c2 ON (c1.openid=c2.openid) ORDER BY '.$sortkey.' '.$sortval);
		return $this->page_mod($s);
	}
	/**
	 * 读取所有粉丝
	 */
	public function getfans()
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'wx_user ORDER BY createtime DESC');
	}
	//删除
	public function del($ids)
	{
		$this->delete(DB_MX_PRE.'wx_pushmsgs','id IN('.$ids.')');
	}
}
?>