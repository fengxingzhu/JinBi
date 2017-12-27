<?php
/**
 * 会员列表
 */
class DataMod extends Model
{
	public function DataMod()
	{
		$this->Model();
	}
	//获取会员列表
	public function getlist($s)
	{
		//默认排序
		$sortkey = empty($_POST['sortname'])?'id':$_POST['sortname'];
		$sortval = empty($_POST['sortorder'])?'DESC':$_POST['sortorder'];
		$this->set_sql('SELECT * FROM '.DB_MX_PRE.'vip_user WHERE 1 ORDER BY '.$sortkey.' '.$sortval);
		return $this->page_mod($s);
	}
	//新增会员
	public function add()
	{
		$_POST['password'] = md5('123456');
		$_POST['passed'] = 1;
		$this->insert(DB_MX_PRE.'vip_user',array('username','password','niname','email','phone','passed'));
	}
	//判断用户名是否唯一
	public function isuseronlyone($u,$id='')
	{
		$ext = empty($id)?'':' AND id!="'.$id.'"';
		$is = $this->get_row('SELECT id FROM '.DB_MX_PRE.'vip_user WHERE username="'.$u.'"'.$ext);
		return empty($is['id'])?true:false;
	}
	//获取会员信息
	public function getinfo($id)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'vip_user WHERE id="'.$id.'"');
	}
	//修改会员
	public function edit($id)
	{
		$this->update(DB_MX_PRE.'vip_user',array('username','niname','email','phone'),'id="'.$id.'"');
	}
	//删除会员
	public function del($ids)
	{
		$this->delete(DB_MX_PRE.'vip_user','id IN('.$ids.')');
	}
}
?>