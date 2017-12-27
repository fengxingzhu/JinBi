<?php
/**
 * 公共应用
 */
class EPubMod extends Model
{
	public function EPubMod()
	{
		$this->Model();
	}
	//读取一级分类
	public function getabs($user)
	{
		if($user['pwgrade']==1){//超级管理员
			return $this->get_all('SELECT * FROM '.DB_MX_PRE.'menu WHERE grade=1 AND langtp="'.$user['langtp'].'" ORDER BY typeid ASC,sort ASC');
		}else{
			$groups = $this->get_row('SELECT powids FROM '.DB_MX_PRE.'mgroup WHERE id="'.$user['gid'].'"');
			return empty($groups['powids'])?array():
				$this->get_all('SELECT * FROM '.DB_MX_PRE.'menu WHERE grade=1 AND langtp="'.$user['langtp'].'" AND id IN('.$groups['powids'].') ORDER BY typeid ASC,sort ASC');
		}
	}
	//读取频道名称
	public function getabsname($id)
	{
		$d = $this->get_row('SELECT title FROM '.DB_MX_PRE.'menu WHERE id="'.$id.'"');
		return $d['title'];
	}
	//读取所有栏目
	public function getallmenu($user)
	{
		if($user['pwgrade']==1){//超级管理员
			return $this->get_all('SELECT * FROM '.DB_MX_PRE.'menu WHERE langtp="'.$user['langtp'].'" ORDER BY sort ASC');
		}else{
			$groups = $this->get_row('SELECT powids FROM '.DB_MX_PRE.'mgroup WHERE id="'.$user['gid'].'"');
			return empty($groups['powids'])?array():
				$this->get_all('SELECT * FROM '.DB_MX_PRE.'menu WHERE id IN('.$groups['powids'].') AND langtp="'.$user['langtp'].'" ORDER BY sort ASC');
		}
	}
	//读取登录日志
	public function logsdata($uid)
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'loginlogs WHERE uid="'.$uid.'" ORDER BY id DESC LIMIT 0,15');
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
	//查看Mysql版本
	public function getmysqlversion()
	{
		return mysql_get_server_info();
	}
}
?>