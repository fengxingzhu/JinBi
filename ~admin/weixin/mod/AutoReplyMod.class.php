<?php
/**
 * 自动回复管理
 */
class AutoReplyMod extends Model
{
	public function AutoReplyMod()
	{
		$this->Model();
	}
	//获取列表
	public function getlist($s)
	{
		//默认排序
		$sortkey = empty($_POST['sortname'])?'id':$_POST['sortname'];
		$sortval = empty($_POST['sortorder'])?'DESC':$_POST['sortorder'];
		$this->set_sql('SELECT * FROM '.DB_MX_PRE.'wx_autoreply ORDER BY '.$sortkey.' '.$sortval);
		return $this->page_mod($s);
	}
	//新增
	public function add()
	{
		$this->insert(DB_MX_PRE.'wx_autoreply',array('keyword','reply'));
	}
	//获取关键字信息
	public function getinfo($id)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'wx_autoreply WHERE id="'.$id.'"');
	}
	//修改关键字信息
	public function edit($id)
	{
		$this->update(DB_MX_PRE.'wx_autoreply',array('keyword','reply'),'id="'.$id.'"');
	}
	//删除
	public function del($ids)
	{
		$this->delete(DB_MX_PRE.'wx_autoreply','id IN('.$ids.')');
	}
}
?>