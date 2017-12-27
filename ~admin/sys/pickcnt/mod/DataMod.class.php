<?php
/**
 * 采集内容管理
 */
class DataMod extends Model
{
	public function DataMod()
	{
		$this->Model();
	}
	public function getconlist($rp,$d)
	{
		$sql = '';
		if(!empty($d['keyword'])){//关键词
			$ekeyword = explode(' ',$d['keyword']);
			$ekeylen = count($ekeyword);
			$ekeyarr = array();
			for($i=0;$i<$ekeylen;$i++){
				if(!empty($ekeyword[$i])) $ekeyarr[] = 'title LIKE "%'.$ekeyword[$i].'%" ';
			}
			if(!empty($ekeyarr)) $sql .= ' AND ('.join(' OR ',$ekeyarr).')';
		}
		if(!empty($d['nodeid'])){//结点
			$sql .= ' AND nodeid="'.$d['nodeid'].'"';
		}
		$this->set_sql('SELECT c1.*,c2.name FROM '.DB_MX_PRE.'picktemps AS c1 LEFT JOIN '.DB_MX_PRE.'picknode AS c2 ON (c1.nodeid=c2.id) WHERE c1.isdel=0'.$sql.' ORDER BY c1.cdate DESC');
		return $this->page_mod($rp);
	}
	//读取结点
	public function getnodelist()
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'picknode ORDER BY id DESC');
	}
	//读取分类标识
	public function getypeinfo($nodeid)
	{
		$d = $this->get_row('SELECT start_tag FROM '.DB_MX_PRE.'pickimport WHERE fieldname="__typeid" AND nodeid="'.$nodeid.'"');
		return $d['start_tag'];
	}
	//读取结点名称
	public function gettagname($id)
	{
		$d = $this->get_row('SELECT title FROM '.DB_MX_PRE.'menu WHERE id="'.$id.'"');
		return $d['title'];
	}
	//读取结点信息
	public function nodesummary($id)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'picknode WHERE id="'.$id.'"');
	}
	//读取结点导入设置信息
	public function getsetinfo($id)
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'pickimport WHERE nodeid="'.$id.'"');
	}
	//读取所有选中信息
	public function tempinfo($ids,$d = '')
	{
		$sql = '';
		if(!empty($d['keyword'])){//关键词
			$ekeyword = explode(' ',$d['keyword']);
			$ekeylen = count($ekeyword);
			$ekeyarr = array();
			for($i=0;$i<$ekeylen;$i++){
				if(!empty($ekeyword[$i])) $ekeyarr[] = 'title LIKE "%'.$ekeyword[$i].'%" ';
			}
			if(!empty($ekeyarr)) $sql .= ' AND ('.join(' OR ',$ekeyarr).')';
		}
		if(!empty($d['nodeid'])){//结点
			$sql .= ' AND nodeid="'.$d['nodeid'].'"';
		}
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'picktemps WHERE id in('.$ids.') AND isdel=0'.$sql);
	}
	//将信息导入到数据库
	public function dbimports($dn,$item,$id,$sitefds)
	{
		$_POST['__aurl'] = '';
		$_POST['__hurl'] = '';
		// 显示 __syspub 默认 1  ----冯 15-02-15 
	  $_POST['__syspub']=1;
	  array_push($item,"__syspub");
	  
		$this->insert($dn,$item);
		if($_POST['__typeid']!=''){
			//写入静态化规则
			$irid = $this->get_insert_id();
			$d = $this->createhtml($_POST['__typeid'],$irid);
			$this->update('UPDATE '.$dn.' SET __aurl="'.$d['aurl'].'",__hurl="'.$d['hurl'].'" WHERE id="'.$irid.'"');
			//全站搜索
			$this->esitedata($dn,$sitefds,$_POST['__typeid'],$irid,$d['aurl'],$d['hurl']);
		}
		//更新原内容状态
		$this->update('UPDATE '.DB_MX_PRE.'picktemps SET pstatus=1 WHERE id="'.$id.'"');
	}
	//写入全站搜索字段中
	public function esitedata($dbname,$sitefds,$tid,$id,$aurl,$hurl)
	{
		if(empty($sitefds)) return false;
		//读取全站字段数据
		$td = $this->get_row('SELECT CONCAT_WS(",",'.$sitefds.') AS data FROM '.$dbname.' WHERE id="'.$id.'"');
		$_POST['data'] = $td['data'];
		$_POST['tbname'] = $dbname;
		$_POST['typeid'] = $tid;
		$_POST['detailid'] = $id;
		$_POST['__aurl'] = $aurl;
		$_POST['__hurl'] = $hurl;
		//判断全站字段是否存在,如果存在则修新
		$is = $this->get_row('SELECT id FROM '.DB_MX_PRE.'sitesearch WHERE tbname="'.$dbname.'" AND typeid="'.$tid.'" AND detailid="'.$id.'"');
		if(empty($is['id'])){//添加
			$this->insert(DB_MX_PRE.'sitesearch',array('tbname','typeid','detailid','data','__aurl','__hurl'));
		}else{//修改
			$this->update(DB_MX_PRE.'sitesearch',array('tbname','typeid','detailid','data','__aurl','__hurl'),'id="'.$is['id'].'"');
		}
	}
	//读取全站搜索
	public function getsitesearchfields($appid)
	{
		$d = $this->get_all('SELECT name FROM '.DB_MX_PRE.'fields WHERE appid="'.$appid.'" AND sitesearch=1 ORDER BY sort ASC');
		$array = array();
		foreach($d as $lt) $array[] = $lt['name'];
		return join(',',$array);
	}
	//读取字段对应的中文名称
	public function getfieldnames($appid)
	{
		$d = $this->get_all('SELECT name,fieldlabel FROM '.DB_MX_PRE.'fields WHERE appid="'.$appid.'" ORDER BY sort ASC');
		$array = array();
		foreach($d as $lt) $array[$lt['name']] = $lt['fieldlabel'];
		return $array;
	}
	//读取栏目信息列表
	public function getmenulistinfo($mspid)
	{
		$emsp = explode('|',$mspid);
		$emlen = count($emsp);
		$col = array();
		for($i=0;$i<$emlen;$i++){
			$tt = $this->get_row('SELECT title FROM '.DB_MX_PRE.'menu WHERE id="'.$emsp[$i].'"');
			$col[] = $tt['title'];
		}
		return join(',',$col);
	}
	//更新生成的HTML
	public function createhtml($tp,$id)
	{
		//生成相应的静态页面
		$menus = $this->get_row('SELECT * FROM '.DB_MX_PRE.'menu WHERE id="'.$tp.'"');
		if($menus['frturl']!='' && $menus['crturl']!=''){
			//目标动态页面
			$acturl = $menus['frturl'];
			$acturl = str_replace(array('(tid)','(id)'),array($tp,$id), $acturl);
			//生成静态页面
			$htmlurl = $menus['crturl'];
			$htmlurl = str_replace(array('(tid)','(id)','(Y)','(M)','(D)'),array($tp,$id,date('Y'),date('m'),date('d')), $htmlurl);
			mk_dir(dirname(WEB_ROOT.$htmlurl)); //写入目录
			$data = file_get_contents('http://'.LOCAL_IP.WEB_APP.$acturl);
			file_put_contents(WEB_ROOT.$htmlurl, $data);
		}
		return array('aurl'=>$acturl,'hurl'=>$htmlurl);
	}
	//删除信息
	public function delcons($ids)
	{
		$this->update('UPDATE '.DB_MX_PRE.'picktemps SET isdel=1 WHERE id IN('.$ids.')');
	}
	/**
	 * 读取缓存页信息
	 * @param int $id 缓存picktemps的ID
	 */
	public function readtempinfo($id)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'picktemps WHERE id="'.$id.'"');
	}
	//删除导入的文件
	public function delimported()
	{
		$this->update('UPDATE '.DB_MX_PRE.'picktemps SET isdel=1 WHERE pstatus=1');
	}
	//清空缓存
	public function clearemptys()
	{
		$this->update('UPDATE '.DB_MX_PRE.'picktemps SET isdel=1');
	}
	//读取ID大于的最近10个
	public function getlastids($lastid)
	{
		$temps = $this->get_all('SELECT id FROM '.DB_MX_PRE.'picktemps WHERE id>'.$lastid.' AND isdel=0 ORDER BY id ASC LIMIT 0,10');
		$temids =array();
		$idstemp = array();
		foreach($temps as $k=>$list){
			array_push($idstemp,$list['id']);
		}
		if(empty($idstemp)){
			$temids['finsh'] = 1; //完成
		}else{
			$temids['finsh'] = 0; //未完成
			$temids['ids'] = join(',',$idstemp);
			$temids['lastid'] = $temps[$k]['id']; //最后一个id
		}
		return $temids;
	}
	//读取结点数据库的表名
	public function get_talname($livid)
	{
		$d = $this->get_row('SELECT dbtname FROM '.DB_MX_PRE.'applivs WHERE id="'.$livid.'"');
		return $d['dbtname'];
	}
}
?>