<?php
/**
 * 实例列表
 */
class LivsMod extends Model
{
	public function LivsMod()
	{
		$this->Model();
	}
	//创建实例
	public function getlivs($user)
	{
		return $this->get_all('SELECT c1.*,c2.gname,c2.gdir FROM '.DB_MX_PRE.'applivs AS c1 LEFT JOIN '.DB_MX_PRE.'appgroups AS c2 ON (c1.gid=c2.id) WHERE c1.langtp="'.$user['langtp'].'" ORDER BY c1.id DESC');
	}
	//获取单个实例
	public function getsimlives($id)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'applivs WHERE id="'.$id.'"');
	}
	//删除实例
	public function del($id)
	{
		$this->delete(DB_MX_PRE.'applivs','id="'.$id.'"');
		//删除对应的字段信息
		$this->delete(DB_MX_PRE.'fields','appid="'.$id.'"');
	}
	//批量删除实例
	public function dels($ids)
	{
		$this->delete(DB_MX_PRE.'applivs','id IN('.$ids.')');
		//删除对应的字段信息
		$this->delete(DB_MX_PRE.'fields','appid IN('.$ids.')');
	}
	//更改标识字段信息
	public function toggleinfo($v,$id)
	{
		$_POST['uaddedit'] = $v==1?0:1;
		$this->update(DB_MX_PRE.'applivs',array('uaddedit'),'id="'.$id.'"');
	}
	//读取分组分类信息
	public function getgroups($gid)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'appgroups WHERE id="'.$gid.'"');
	}
	//检查程序名是否存在
	public function isproname($n,$id='')
	{
		return $this->get_num('SELECT id FROM '.DB_MX_PRE.'applivs WHERE proname="'.$n.'" AND id!="'.$id.'"');
	}
	//创建实例
	public function add($user)
	{
		$_POST['uid'] = $user['id'];
		$_POST['name'] = $user['name'];
		$_POST['langtp'] = $user['langtp'];//多语言
		$_POST['cfg_add_key'] = 1;
		$_POST['cfg_edit_key'] = 1;
		$_POST['cfg_del_key'] = 1;
		$_POST['cfg_page_key'] = 1;
		$_POST['cfg_handsort_key'] = 1;
		$_POST['cfg_brower_key'] = 1; //预览
		$_POST['cfg_top_key'] = 1;
		$_POST['cfg_pub_key'] = 1;
		//数据库表名
		$_POST['dbtname'] = $_POST['gdir'].'_'.$_POST['proname'];
		$items = $this->get_fields(DB_MX_PRE.'applivs');
		$this->insert(DB_MX_PRE.'applivs',$items);
		//添加表单属性
		$_POST['appid'] = $this->get_insert_id();
		$_POST['colspan'] = 1;
		$_POST['width'] = 600;
		$this->insert(DB_MX_PRE.'forms',array('appid','colspan','width'));
	}
	//修改实例
	public function edit($id)
	{
		//数据库表名
		$_POST['dbtname'] = $_POST['gdir'].'_'.$_POST['proname'];
		$this->update(DB_MX_PRE.'applivs',array('dir','dbtname','appname','apiurl','gid','syngrade','livname','proname'),'id="'.$id.'"');
		//更新已经生成的菜单URL
		$mes = $this->get_all('SELECT * FROM '.DB_MX_PRE.'menu WHERE livsid="'.$id.'"');
		foreach($mes as $l){
			$tppos = strpos($l['admurl'], 'tp/');
			$tp = substr($l['admurl'],$tppos+3);
			$tp = str_replace('.html','', $tp);
			$_POST['admurl'] = str_replace('分类标识',$tp,$_POST['apiurl']);
			$this->update(DB_MX_PRE.'menu',array('admurl'),'id="'.$l['id'].'"');
		}
	}
}
?>