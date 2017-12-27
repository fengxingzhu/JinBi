<?php
/**
 * 表单处理
 */
class FormMod extends Model
{
	public function FormMod()
	{
		$this->Model();
	}
	//读取实例
	public function getlivs($ag)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'applivs WHERE proname="'.$ag.'"');
	}
	//读取字段信息
	public function getfdlist($appid,$dt = 1)
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'fields WHERE appid="'.$appid.'" AND displaytag='.$dt.' ORDER BY sort ASC');
	}
	//获取fieldplusjs
	public function fieldplusjs($appid)
	{
		return $this->get_all('SELECT fdplusfn FROM '.DB_MX_PRE.'fields WHERE appid="'.$appid.'" AND fdplusfn!="" ORDER BY sort ASC');
	}
	//读取ckeditor
	public function getckeditorfield($appid)
	{
		return $this->get_all('SELECT name FROM '.DB_MX_PRE.'fields WHERE appid="'.$appid.'" AND xtype="ckeditor"');
	}
	//读取数据
	public function getinfo($dbname,$tp)
	{
		return $this->get_row('SELECT * FROM '.$dbname.' WHERE __typeid="'.$tp.'"');
	}
	//修改数据
	public function edit($dbname,$tp)
	{
		$_POST['__typeid'] = $tp;
		$is = $this->get_num('SELECT * FROM '.$dbname.' WHERE __typeid="'.$tp.'"');
		$items = $this->get_fields($dbname);
		if($is>0){//修改
			$this->update($dbname,$items,'__typeid="'.$tp.'"');
		}else{//新增
			$this->insert($dbname,$items);
		}
	}
	//读取栏目信息
	public function getmenuinfo($tid)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'menu WHERE id="'.$tid.'"');
	}
	//根据path读取所有菜单栏目
	public function getmenuallname($path)
	{
		$dd = $this->get_all('SELECT * FROM '.DB_MX_PRE.'menu WHERE id IN('.$path.') ORDER BY grade ASC,sort ASC');
		$d = array();
		foreach ($dd as $v){
			array_push($d, $v['title']);
		}
		return join('=>',$d);
	}
	//读取表单属性
	public function getformattr($appid)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'forms WHERE appid="'.$appid.'"');
	}
	//读取关联实例字段
	public function getrexlivfds($field,$rexlivid)
	{
		if(empty($field['relationtable'])){
			return false;
		}else{
			$liv = $this->get_row('SELECT dbtname FROM '.DB_MX_PRE.'applivs WHERE id="'.$rexlivid.'"');
			return $liv['dbtname']==$field['relationtable']?true:false;
		}
	}
	//读取该关联字段的关联信息
	public function getrexdata($field,$rexpid)
	{
		$d = $this->get_row('SELECT '.$field['relationfield'].' FROM '.$field['relationtable'].' WHERE id="'.$rexpid.'"');
		return $d[$field['relationfield']];
	}
	//读取关联实例信息
	public function get_rexlivfdname($livid,$rexlivid,$rexpid)
	{
		$rexliv = $this->get_row('SELECT dbtname FROM '.DB_MX_PRE.'applivs WHERE id="'.$rexlivid.'"');
		$liv = $this->get_row('SELECT relationfield FROM '.DB_MX_PRE.'fields WHERE relationtable="'.$rexliv['dbtname'].'" AND appid="'.$livid.'"');
		$d = $this->get_row('SELECT '.$liv['relationfield'].' FROM '.$rexliv['dbtname'].' WHERE id="'.$rexpid.'"');
		return $d[$liv['relationfield']];
	}
	//更新连接地址
	public function upinfourl($dbname,$tid,$aurl,$hurl)
	{
		$_POST['__aurl'] = $aurl;
		$_POST['__hurl'] = $hurl;
		$this->update($dbname,array('__aurl','__hurl'),'__typeid="'.$tid.'"');
	}
	//读取全站字段
	public function getsitesearchfields($appid)
	{
		$d = $this->get_all('SELECT name FROM '.DB_MX_PRE.'fields WHERE appid="'.$appid.'" AND sitesearch=1 ORDER BY sort ASC');
		$array = array();
		foreach($d as $lt) $array[] = $lt['name'];
		return join(',',$array);
	}
	//写入全站搜索字段中
	public function esitedata($dbname,$sitefds,$tid,$aurl,$hurl)
	{
		if(empty($sitefds)) return false;
		//读取全站字段数据
		$td = $this->get_row('SELECT CONCAT_WS(",",'.$sitefds.') AS data FROM '.$dbname.' WHERE __typeid="'.$tid.'"');
		$_POST['data'] = $td['data'];
		$_POST['tbname'] = $dbname;
		$_POST['typeid'] = $tid;
		$_POST['__aurl'] = $aurl;
		$_POST['__hurl'] = $hurl;
		//判断全站字段是否存在,如果存在则修新
		$is = $this->get_row('SELECT id FROM '.DB_MX_PRE.'sitesearch WHERE tbname="'.$dbname.'" AND typeid="'.$tid.'"');
		if(empty($is['id'])){//添加
			$this->insert(DB_MX_PRE.'sitesearch',array('tbname','typeid','detailid','data','__aurl','__hurl'));
		}else{//修改
			$this->update(DB_MX_PRE.'sitesearch',array('tbname','typeid','detailid','data','__aurl','__hurl'),'id="'.$is['id'].'"');
		}
	}
	//读取对实例的缓存列表
	public function getcalist($ag)
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'appcalist WHERE appid="'.$ag.'" ORDER BY id ASC');
	}
}
?>