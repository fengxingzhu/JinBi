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
	//读取该组件的所有分类
	public function getalltypesids($appid)
	{
		//读取所有属于该实例的一级分类
		$appdata = $this->get_all('SELECT path FROM '.DB_MX_PRE.'menu WHERE livsid="'.$appid.'" ORDER BY sort ASC');
		$firstids = array();
		foreach ($appdata as $list){
			$epath = explode(',', $list['path']);
			if($epath[1]>0 && !in_array($epath[1], $firstids)) $firstids[] = $epath[1];
		}
		return $firstids;
	}
	//读取所有栏目
	public function getallmenu()
	{
			return $this->get_all('SELECT * FROM '.DB_MX_PRE.'menu ORDER BY sort ASC');
	}
	//根据path读取菜单栏目
	public function getmenuname($path)
	{
		$npath = substr($path,3);
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
	//读取搜索字段信息
	public function getsearchfdlist($appid)
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'fields WHERE appid="'.$appid.'" AND issearch=1 ORDER BY sort ASC');
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
	//读取填写唯一值
	public function getonlyone($appid)
	{
		return $this->get_all('SELECT fieldlabel,name FROM '.DB_MX_PRE.'fields WHERE appid="'.$appid.'" AND onlyone=1 ORDER BY sort ASC');
	}
	//判读数据是否唯一
	public function isextisval($dbname,$n,$tp,$id='')
	{
		$sql = empty($id)?
			'SELECT * FROM '.$dbname.' WHERE __typeid="'.$tp.'" AND '.$n.'="'.$_POST[$n].'"':
			'SELECT * FROM '.$dbname.' WHERE __typeid="'.$tp.'" AND '.$n.'="'.$_POST[$n].'" AND id!="'.$id.'"';
		$num = $this->get_num($sql);
		return empty($num)?0:$num;
	}
	//读取数据
	public function getinfo($dbname,$id)
	{
		return $this->get_row('SELECT * FROM '.$dbname.' WHERE id="'.$id.'"');
	}
	//添加数据
	public function add($dbname,$tp,$n)
	{
		$res = array();
		if($tp == 'all'){
			$etp = explode(',',$_POST['__alltname_key']);
			$etplen = count($etp);
			$__allapp_ids = array();
			for($i=0;$i<$etplen;$i++){
				if(!empty($etp[$i])){
					$_tp = $etp[$i];
					$_tempid = $this->addone($dbname,$_tp,$n);
					$__allapp_ids[] = $_tempid;
					$res[] = array('tid'=>$_tp,'id'=>$_tempid);
				}
			}
			$_POST['__allapp_ids'] = join(',', $__allapp_ids); //相同数据
			//更新该组
			if(!empty($_POST['__allapp_ids'])) $this->update($dbname,array('__allapp_ids'),'id IN('.$_POST['__allapp_ids'].')');
		}else{
			$_tp = $tp;
			$_tempid = $this->addone($dbname,$_tp,$n);
			$_POST['__alltname_key'] = $_tp;
			$this->update($dbname,array('__alltname_key'),'id="'.$_tempid.'"');
			$res[] = array('tid'=>$_tp,'id'=>$_tempid);
		}
		return $res;
	}
	//添加单个分类
	private function addone($dbname,$tp,$n)
	{
		//查找最后一个排序数
		$maxsort = $this->get_row('SELECT __handsort FROM '.$dbname.' ORDER BY __handsort DESC');
		$_POST['__handsort'] = empty($maxsort)?'0':intval($maxsort['__handsort'])+5;
		//增加数据
		$_POST['__typeid'] = $tp;
		$items = $this->get_fields($dbname);
		$this->insert($dbname,$items);
		$insertid = $this->get_insert_id();
		if($_POST['__syninfo']>0){
			//写入审核信息
			$is = $this->get_row('SELECT * FROM '.DB_MX_PRE.'datasyndic WHERE tbname="'.$dbname.'" AND tbnid="'.$insertid.'"');
			if(empty($is)){
				$_POST['tbname'] = $dbname;
				$_POST['tbnid'] = $insertid;
				$_POST['syngd'] = $_POST['__syninfo'];
				$_POST['synuser'] = $n;
				$this->insert(DB_MX_PRE.'datasyndic',array('tbname','tbnid','syngd','synuser'));
			}
		}
		$this->editothermethod($dbname,$tp,$insertid,'add');
		return $insertid;
	}
	//更新连接地址
	public function upinfourl($dbname,$id,$aurl,$hurl)
	{
		$_POST['__aurl'] = $aurl;
		$_POST['__hurl'] = $hurl;
		$this->update($dbname,array('__aurl','__hurl'),'id="'.$id.'"');
	}
	//读取对应
	//修改数据
	public function edit($dbname,$id,$tp,$n)
	{
		$res = array();
		if($tp=='all'){//批量更新
			//批量
			$etp = explode(',',$_POST['__alltname_key']);
			$etplen = count($etp);
			$__allapp_ids = array();
			//当前编辑的信息
			$simples = $this->get_row('SELECT __typeid,__alltname_key,__allapp_ids FROM '.$dbname.' WHERE id="'.$id.'"');
			//查看该信息的所有信息ID
			$elotids = explode(',', $simples['__allapp_ids']);
			//修改信息id
			$editids = array();
			//新增的信息id
			$addids = array();
			//循环分类
			for($i=0;$i<$etplen;$i++){
				if(!empty($etp[$i])){
					$_tp = $etp[$i];
					$isexitapps = $this->get_row('SELECT id FROM '.$dbname.' WHERE __typeid="'.$_tp.'" AND __alltname_key="'.$simples['__alltname_key'].'" AND __allapp_ids="'.$simples['__allapp_ids'].'"');
					if(in_array($isexitapps['id'], $elotids) || $isexitapps['id']==$id){//修改信息
						$_tempid = $isexitapps['id'];
						$editids[] = $_tempid;
					}else{//需要新增的
						$_tempid = $this->addone($dbname,$_tp,$n);
						$addids[] = $_tempid;
					}
					$__allapp_ids[] = $_tempid;
					$res[] = array('tid'=>$_tp,'id'=>$_tempid);
				}
			}
			$_POST['__allapp_ids'] = join(',', $__allapp_ids); //相同数据
			if(!empty($addids)){//更新批量添加的标记
				foreach($addids as $av){
					$this->update($dbname,array('__alltname','__alltname_key','__allapp_ids','__aurl','__hurl'),'id="'.$av.'"');
				}
			}
			//批量原修改的信息 更新标记
			$items = $this->get_fields($dbname,array('__typeid','__syninfo','__handsort'));
			foreach($editids as $ev){
				$this->update($dbname,$items,'id="'.$ev.'"');
			}
			//补丁方法加载
			$this->editothermethod($dbname,$tp,$_POST['__allapp_ids'],'edit');
		}else{
			$items = $this->get_fields($dbname,array('__typeid','__aurl','__hurl','__alltname','__alltname_key','__allapp_ids','__syninfo','__handsort'));
			$this->update($dbname,$items,'id="'.$id.'"');
			$res[] = array('tid'=>$tp,'id'=>$id);
			//补丁方法加载
			$this->editothermethod($dbname,$tp,$id,'edit');
		}
		return $res;
	}
	/**
	 * 添加和修改时需要进行字段组合或者规则处理
	 * @param string $dbname 表名
	 * @param int $tp 分类ID
	 * @param string $ids 多个ID以,分隔
	 * @param string $etp 方法分类 add为添加 edit为修改
	 */
	public function editothermethod($dbname,$tp,$ids,$etp)
	{
		$dir = dirname(dirname(dirname(dirname(__FILE__))));
		$dir = str_replace('\\','/',$dir);
		$file = $dir.'/ugridplug/'.$dbname.'.class.php';
		if(file_exists($file)){
			require_once $file;
			$class = '__UGrid_'.$dbname;
			$obj = new $class();
			$obj->run($this,$dbname,$tp,$ids,$etp);
		}
	}
	//读取表单属性
	public function getformattr($appid)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'forms WHERE appid="'.$appid.'"');
	}
	//更改标识字段信息
	public function toggleinfo($n,$k,$v,$id)
	{
		$_POST[$k] = $v==0?'否':'是';
		$_POST[$k.'_key'] = $v;
		$this->update($n,array($k,$k.'_key'),'id="'.$id.'"');
	}
	//读取对实例的缓存列表
	public function getcalist($ag)
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'appcalist WHERE appid="'.$ag.'" ORDER BY id ASC');
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
	//读取栏目信息
	public function getmenuinfo($tid)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'menu WHERE id="'.$tid.'"');
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
}
?>