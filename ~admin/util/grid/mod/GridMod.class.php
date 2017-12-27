<?php
/**
 * 表格处理
 */
class GridMod extends Model
{
	public function GridMod()
	{
		$this->Model();
	}
	//读取实例
	public function getlivs($ag)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'applivs WHERE proname="'.$ag.'"');
	}
	//读取关联实例信息
	public function get_rexlivfdname($livid,$rexlivid,$rexpid)
	{
		$rexliv = $this->get_row('SELECT dbtname FROM '.DB_MX_PRE.'applivs WHERE id="'.$rexlivid.'"');
		$liv = $this->get_row('SELECT name,relationfield FROM '.DB_MX_PRE.'fields WHERE relationtable="'.$rexliv['dbtname'].'" AND appid="'.$livid.'"');
		$d = $this->get_row('SELECT '.$liv['relationfield'].' FROM '.$rexliv['dbtname'].' WHERE id="'.$rexpid.'"');
		return array('name'=>$liv['name'],'rexname'=>$d[$liv['relationfield']]);
	}
	//根据path读取菜单栏目
	public function getmenuname($id)
	{
		$d = $this->get_row('SELECT * FROM '.DB_MX_PRE.'menu WHERE id="'.$id.'"');
		$npath = substr($d['path'],3);
		$dd = $this->get_all('SELECT * FROM '.DB_MX_PRE.'menu WHERE id IN('.$npath.') ORDER BY grade ASC,sort ASC');
		$d = array();
		foreach ($dd as $v){
			array_push($d, $v['title']);
		}
		return join('=>',$d);
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
	//读取栏目信息
	public function getmenuinfo($tid)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'menu WHERE id="'.$tid.'"');
	}
	//读取对应的操作权限
	public function getoptpower($gid)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'mgroup WHERE id="'.$gid.'"');
	}
	//下拉字段
	public function getdownrexfd($appid)
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'fields WHERE appid="'.$appid.'" AND (xtype="combo" OR xtype="radiogroup")');
	}
	//单字段关联
	public function getrexfields($appid)
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'fields WHERE appid="'.$appid.'" AND rexlivid>0');
	}
	//下拉字段关联数据
	public function getfieldowndata($fieldid)
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'fieldatas WHERE fieldid="'.$fieldid.'" ORDER BY sort ASC');
	}
	//读取实例API
	public function getlivapi($livid)
	{
		$d = $this->get_row('SELECT apiurl FROM '.DB_MX_PRE.'applivs WHERE id="'.$livid.'"');
		return $d['apiurl'];
	}
	//读取默认排序字段
	public function getdefsort($appid)
	{
		return $this->get_row('SELECT name,defsort FROM '.DB_MX_PRE.'fields WHERE appid="'.$appid.'" AND defsort>0');
	}
	//获取标识字段
	public function getmarklist($appid)
	{
		$d = $this->get_all('SELECT name FROM '.DB_MX_PRE.'fields WHERE appid="'.$appid.'" AND listwidth>0 AND xtype="markfield" ORDER BY sort ASC');
		$arr = array();
		foreach($d as $list) array_push($arr,$list['name']);
		return $arr;
	}
	//读取搜索字段信息
	public function getsearchfdlist($appid)
	{
		$n = $this->get_num('SELECT id FROM '.DB_MX_PRE.'fields WHERE appid="'.$appid.'" AND issearch=1 ORDER BY sort ASC');
		return empty($n)?0:$n;
	}
	//获得上传多文件字段
	public function getpuloadlist($appid)
	{
		$d = $this->get_all('SELECT name FROM '.DB_MX_PRE.'fields WHERE appid="'.$appid.'" AND listwidth>0 AND xtype="fileupload" ORDER BY sort ASC');
		$arr = array();
		foreach($d as $list) array_push($arr,$list['name']);
		return $arr;
	}
	//获得上传单文件字段
	public function getsimuplist($appid)
	{
		$d = $this->get_all('SELECT id,name FROM '.DB_MX_PRE.'fields WHERE appid="'.$appid.'" AND listwidth>0 AND xtype="simpleupload" ORDER BY sort ASC');
		$arr = array();
		foreach($d as $list){
			//查找文件列表显示大小
			$size = $this->get_row('SELECT gdwidth,gdheight FROM '.DB_MX_PRE.'fieldupload WHERE fieldid="'.$list['id'].'"');
			$arr[] = array(
				'name'	=>	$list['name'],
				'width'	=>	$size['gdwidth']>0?$size['gdwidth']:36,
				'height'=>	$size['gdheight']>0?$size['gdheight']:36
			);
		}
		return $arr;
	}
	//读取字段信息
	public function getfdlist($appid)
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'fields WHERE appid="'.$appid.'" ORDER BY listsort ASC');
	}
	//导出excel时的字段信息
	public function excfields($appid)
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'fields WHERE appid="'.$appid.'" ORDER BY sort ASC');
	}
	//得到菜单名称
	public function get_menutitles()
	{
		$d = $this->get_all('SELECT id,title FROM '.DB_MX_PRE.'menu ORDER BY id ASC');
		$_d = array();
		foreach($d as $v) $_d[$v['id']] = $v['title'];
		return $_d;
	}
	//读取数据
	public function getstore($n,$s,$tp,$rexfield,$rexpid,$pgy)
	{
		//搜索
		$searchsql = '';
		if($tp=='all'){//所有该组分类
			$searchsql .= '1';
		}else{
			$searchsql .= '__typeid="'.$tp.'"';
		}
		if(!empty($rexfield) && !empty($rexpid)){
			$searchsql .= ' AND '.$rexfield.'_key="'.$rexpid.'"';
		}
		if($tp['syngrade']>0){
			$searchsql .= ' AND __syninfo>="'.($pgy[$_GET['__mid']]-1).'"';
		}
		if(!empty($_POST['qtype'])){
			if($_POST['qtype']!='__allkeyword'){
				$searchsql .= ' AND '.$_POST['qtype'].' LIKE "%'.$_POST['query'].'%"';
			}else{
				if(!empty($_POST['query'])){//查询全部字段
					$items = $this->get_fields($n,array('__typeid'));
					$seararr = array();
					for($i=0;$i<count($items);$i++) array_push($seararr,''.$items[$i].' LIKE "%'.$_POST['query'].'%"');
					$searchsql .= ' AND ('.join(' OR ',$seararr).')';
				}
			}
		}
		//多条件搜索
		$srdata = Cache::session_get('SEARCH_'.$_GET['ag'].'_'.$tp);
		if(!empty($srdata)){
			foreach($srdata as $v){
				if($v['xtype']=='datefield'){
					if(!empty($v['value']['start'])){//开始时间
						$searchsql .= ' AND '.$v['name'].'>="'.$v['value']['start'].'"';
					}
					if(!empty($v['value']['end'])){//结束时间
						$searchsql .= ' AND '.$v['name'].'>="'.$v['value']['end'].'"';
					}
				}else{//其他模糊查询
					$searchsql .= ' AND '.$v['name'].' LIKE "%'.$v['value'].'%"';
				}
			}
		}
		//默认排序
		$sortkey = empty($_POST['sortname'])?'id':$_POST['sortname'];
		$sortval = empty($_POST['sortorder'])?'DESC':$_POST['sortorder'];
		$this->set_sql('SELECT * FROM '.$n.' WHERE '.$searchsql.' ORDER BY '.$sortkey.' '.$sortval);
		return $this->page_mod($s);
	}
	//删除数据
	public function del($dbname,$ids)
	{
		//删除前先删除生成的静态页面
		$data = $this->get_all('SELECT id,__typeid,__hurl FROM '.$dbname.' WHERE id IN('.$ids.')');
		foreach($data as $d){
			//删除全站搜索
			$this->delete(DB_MX_PRE.'sitesearch','tbname="'.$dbname.'" AND typeid="'.$d['__typeid'].'" AND detailid="'.$d['id'].'"');
			//删除文件
			if($d['__hurl']!=''){
				$delfile = WEB_ROOT.$d['__hurl'];
				if(file_exists($delfile))
					unlink($delfile);
			}
		}
		$this->delete($dbname,'id IN('.$ids.')');
	}
	//清空单文件字段信息
	public function delsimplefile($dbname,$tp,$id,$fn)
	{
		$_POST[$fn] = '';
		$_POST[$fn.'_path'] = '';
		if(!empty($id)) $this->update($dbname,array($fn,$fn.'_path'),'__typeid="'.$tp.'" AND id="'.$id.'"');
	}
	//保存字段的宽度
	public function savewdfd($appid)
	{
		if($_POST['vl']>0 && $_POST['fd']!="")
			$this->update('UPDATE '.DB_MX_PRE.'fields SET listwidth="'.$_POST['vl'].'" WHERE name="'.$_POST['fd'].'" AND appid="'.$appid.'"');
	}
	//保存列表排序
	public function headersort($appid)
	{
		$esort = explode(',',$_POST['headsort']);
		for($i=0;$i<count($esort);$i++){
			$this->update('UPDATE '.DB_MX_PRE.'fields SET listsort="'.$i.'" WHERE name="'.$esort[$i].'" AND appid="'.$appid.'"');
		}
	}
	//得到文件列表
	public function getfiles($ids)
	{
		return empty($ids)?array():$this->get_all('SELECT * FROM '.DB_MX_PRE.'uploads WHERE id IN('.$ids.') ORDER BY sort ASC');
	}
	//删除文件
	public function delappends($ids)
	{
		$this->delete(DB_MX_PRE.'uploads','id IN('.$ids.')');
	}
	//更改列表信息
	public function uplistappend($oldids,$dbn,$fn,$fd)
	{
		$data = $this->getfiles($oldids);
		$arr1 = array(); $arr2 = array();
		foreach ($data as $list){
			array_push($arr1,$list['id']);
			array_push($arr2,$list['oldname']);
		}
		$_POST[$fn] = join(',',$arr2);
		$_POST[$fn.'_ids'] = join(',',$arr1);
		$this->update($dbn,array($fn,$fn.'_ids'),'id="'.$fd.'"');
		if($_GET['isformeditflag']==1){
			return '{names:"'.$_POST[$fn].'",ids:"'.$_POST[$fn.'_ids'].'"}';
		}else{
			return $_POST[$fn];
		}
	}
	//修改信息
	public function sortappends($ids,$oldnames,$sorts,$lid,$lnd,$dbn)
	{
		$eids = explode(',',$ids);
		$eoldnames = explode('||',$oldnames);
		$esorts = explode(',',$sorts);
		for($i=0;$i<count($eids);$i++){
			$_POST['oldname'] = $eoldnames[$i];
			$_POST['sort'] = $esorts[$i];
			$this->update(DB_MX_PRE.'uploads',array('oldname','sort'),'id="'.$eids[$i].'"');
		}
		if(!empty($lid) && !empty($lnd) && !empty($dbn)){
			$_POST[$lnd] = str_replace('||',',',$oldnames);
			$this->update($dbn,array($lnd),'id="'.$lid.'"');
		}
	}
	//导入测试数据
	public function importdatatest($livs,$datapath,$tp)
	{
		//读取需要填测试数据字段信息
		$impordata = $this->get_all('SELECT * FROM '.DB_MX_PRE.'fields WHERE appid="'.$livs['id'].'" AND datafilltype!="" ORDER BY sort ASC');
		$fieldarr = array();
		$fditem = array('__typeid');
		$fdtempdata = array();
		$frtlen = 0;
		foreach ($impordata as $k=>$list){
			$d = $this->gettestdata($datapath.'/'.$list['datafilltype']);
			if($k==0) $frtlen = count($d);
			$fdtempdata[$list['name']] = $this->gettestdata($datapath.'/'.$list['datafilltype']);
			array_push($fieldarr,$list['name']);
			array_push($fditem,$list['name']);
		}
		$_POST['__typeid'] = $tp;
		for($i=0;$i<$frtlen;$i++){
			for($f=0;$f<count($fieldarr);$f++){
				$_POST[$fieldarr[$f]] = $fdtempdata[$fieldarr[$f]][$i];
			}
			$this->insert($livs['dbtname'],$fditem);
		}
	}
	//读取测试数据
	private function gettestdata($path)
	{
		$data = array();
		$dh=opendir($path);
		$str = array();
		while (false !== $file = readdir($dh))
		{
			if($file!="." && $file!=".." && $file!="config.php")
			{
				$d = file_get_contents($path.'/'.$file);
				array_push($data,$d);
			}
		}
		closedir($dh);
		return $data;
	}
	//读取导出列表
	public function getoutputs($appid)
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'outputsets WHERE appid="'.$appid.'" ORDER BY sort ASC');
	}
	//读出导出信息
	public function getsimpleout($id)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'outputsets WHERE id="'.$id.'"');
	}
	//审核通过
	public function syngrade($mid,$n,$dbn,$ids)
	{
		$this->update('UPDATE '.$dbn.' SET __syninfo="'.$mid.'" WHERE id IN('.$ids.')');
		$eids = explode(',',$ids);
		$eidslen = count($eids);
		for($i=0;$i<$eidslen;$i++){
			//写入审核信息
			$is = $this->get_row('SELECT * FROM '.DB_MX_PRE.'datasyndic WHERE tbname="'.$dbn.'" AND tbnid="'.$eids[$i].'"');
			if(empty($is)){
				$_POST['tbname'] = $dbn;
				$_POST['tbnid'] = $eids[$i];
				$_POST['syngd'] = $mid;
				$_POST['synuser'] = $n;
				$this->insert(DB_MX_PRE.'datasyndic',array('tbname','tbnid','syngd','synuser'));
			}
		}
	}
	//读取审核信息
	public function getsyninfolist($dbn,$id)
	{
		$data = $this->get_all('SELECT * FROM '.DB_MX_PRE.'datasyndic  WHERE tbname="'.$dbn.'" AND tbnid="'.$id.'" ORDER BY syngd ASC');
		$temp = array();
		foreach ($data as $list){
			array_push($temp,'<span>['.$list['syngd'].']'.$list['synuser'].' '.$list['syndate'].'</span>');
		}
		return join('<br>',$temp);
	}
	//更新排序
	public function uphandsort($tn,$id,$v)
	{
		$this->update('UPDATE '.$tn.' SET __handsort="'.$v.'" WHERE id="'.$id.'"');
	}
	//步长10的排序
	public function upstepsort($dbname,$typeid)
	{
		$data = $this->get_all('SELECT id,__handsort FROM '.$dbname.' WHERE __typeid="'.$typeid.'" ORDER BY __handsort ASC');
		foreach ($data as $k=>$v){
			$this->update('UPDATE '.$dbname.' SET __handsort="'.($k*5).'" WHERE id="'.$v['id'].'"');
		}
	}
	//读取数据
	public function getinfo($dbname,$id)
	{
		return $this->get_row('SELECT * FROM '.$dbname.' WHERE id="'.$id.'"');
	}
	//导出excel数据
	public function getexclastdata($dbname,$typeid,$outids)
	{
		$ssql = $typeid=='all'?'1':'__typeid="'.$typeid.'"';
		if(empty($outids)){//无选择导出时，导出全部
			return $this->get_all('SELECT * FROM '.$dbname.' WHERE '.$ssql.' ORDER BY id DESC');
		}else{//有选择，只导出选择部分
			return $this->get_all('SELECT * FROM '.$dbname.' WHERE '.$ssql.' AND id IN('.$outids.') ORDER BY id DESC');
		}
	}
	//导入excel数据
	public function inexceldata($dbname)
	{
		$items = $this->get_fields($dbname);
		$this->insert($dbname,$items);
	}
}
?>