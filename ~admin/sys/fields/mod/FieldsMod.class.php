<?php
/**
 * 表单管理
 */
class FieldsMod extends Model
{
	public function FieldsMod()
	{
		$this->Model();
	}
	//读取字段列表
	public function getfields($appid)
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'fields WHERE appid="'.$appid.'" ORDER BY sort ASC');
	}
	//读取实例信息
	public function getinsta($id)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'applivs WHERE id="'.$id.'"');
	}
	//读取实例列表,除自身外
	public function getotrlivs($id)
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'applivs WHERE id!="'.$id.'"');
	}
	//判读字段名是否存在
	public function isexits($appid,$n,$fid = '')
	{
		$sql = '';
		if(!empty($fid)) $sql .= ' AND id!="'.$fid.'"';
		$num = $this->get_num('SELECT id FROM '.DB_MX_PRE.'fields WHERE appid="'.$appid.'" AND name="'.$n.'"'.$sql.'');
		if(empty($num)){
			//系统预留字段
			$ylfields = array(
				/**
				 * mysql 预留关键字
				 */
				'add','all','alter','analyze','and','as','asc','asensitive',
				'before','between','bigint','binary','blob','both','by','call',
				'cascade','case','change','char','character','check','collate','column','condition','connection','constraint','continue','convert','create','cross','current_date','current_time','current_timestamp','current_user','cursor',
				'database','databases','day_hour','day_microsecond','day_minute','day_second','dec','decimal','declare','default','delayed','delete','desc','describe','deterministic','distinct','distinctrow','div','double','drop','dual',
				'each','else','elseif','enclosed','escaped','exists','exit','explain',
				'false','fetch','float','float4','float8','for','force','foreign','from','fulltext',
				'goto','grant','group',
				'having','high_priority','hour_microsecond','hour_minute','hour_second',
				'if','ignore','in','index','infile','inner','inout','insensitive','insert','int','int1','int2','int3','int4','int8','integer','interval','into','is','iterate',
				'join',
				'key','keys','kill',
				'label','leading','leave','left','like','limit','linear','lines','load','localtime','localtimestamp','lock','long','longblob','longtext','loop','low_priority',
				'match','mediumblob','mediumint','mediumtext','middleint','minute_microsecond','minute_second','mod','modifies',
				'natural','not','no_write_to_binlog','null','numeric',
				'on','optimize','option','optionally','or','order','out','outer','outfile',
				'precision','primary','procedure','purge',
				'raid0','range','read','reads','real','references','regexp','release','rename','repeat','replace','requires','restrict','return','revoke','right','rlike',
				'schema','schemas','second_microsecond','select','sensitive','separator','set','show','smallint','spatial','specific','sql','sqlexception','sqlstate','sqlwarning','sql_big_result','sql_calc_found_rows','sql_small_result','ssl','starting','straight_join',
				'table','terminated','then','tinyblob','tinyint','tinytext','to','trailing','trigger','true',
				'undo','union','unique','unlock','unsigned','update','usage','use','using','utc_date','utc_time','utc_timestamp',
				'values','varbinary','varchar','varcharacter','varying',
				'when','where','while','with','write',
				'x509','xor',
				'year_month',
				'zerofill',
				/**
				 * 系统 定义的关键字
				 */
				'id',
				'__typeid',
				'__aurl',
				'__hurl',
				'__alltname',
				'__alltname_key',
				'__allapp_ids',
				'__syninfo',
				'__handsort'
			);
			$nn = strtolower($n);
			if(in_array($nn,$ylfields)){
				return 1;
			}
		}else{
			return $num;
		}
	}
	//新增字段
	public function add()
	{
		$_POST['listsort'] = $_POST['sort'];
		$items = $this->get_fields(DB_MX_PRE.'fields');
		$this->insert(DB_MX_PRE.'fields',$items);
	}
	//读取字段信息
	public function getfield($id)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'fields WHERE id="'.$id.'"');
	}
	//修改字段
	public function edit($id)
	{
		$items = $this->get_fields(DB_MX_PRE.'fields');
		$this->update(DB_MX_PRE.'fields',$items,'id="'.$id.'"');
	}
	//删除字段
	public function del($id)
	{
		$this->delete(DB_MX_PRE.'fields','id="'.$id.'"');
	}
	//读取实例
	public function getlvinfo($id)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'applivs WHERE id="'.$id.'"');
	}
	//读取字段信息
	public function getfdlist($appid)
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'fields WHERE appid="'.$appid.'" ORDER BY sort ASC');
	}
	//读取表单属性
	public function getformatr($appid)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'forms WHERE appid="'.$appid.'"');
	}
	//修改表单属性
	public function editform($appid)
	{
		$is = $this->get_row('SELECT id FROM '.DB_MX_PRE.'forms WHERE appid="'.$appid.'"');
		if(empty($is)){
			$_POST['appid'] = $appid;
			$this->insert(DB_MX_PRE.'forms',array('appid','colspan','rownum','width'));
		}else{
			$this->update(DB_MX_PRE.'forms',array('colspan','rownum','width'),'appid="'.$appid.'"');
		}
	}
	//新增字段分类数据
	public function datadd($fieldid)
	{
		$_POST['fieldid'] = $fieldid;
		$this->insert(DB_MX_PRE.'fieldatas',array('fieldid','keyinfo','valinfo','livid'));
	}
	//得到字段信息
	public function getfdinfo($fieldid)
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'fieldatas WHERE fieldid="'.$fieldid.'" ORDER BY sort ASC');
	}
	//修改字段数据
	public function dataedit($id,$n,$v)
	{
		$_POST[$n] = $v;
		$this->update(DB_MX_PRE.'fieldatas',array($n),'id="'.$id.'"');
	}
	//更改默认排序
	public function updefsort($id)
	{
		$this->update(DB_MX_PRE.'fields',array('defsort'),'id="'.$id.'"');
	}
	//读取所有表
	public function gettables($id)
	{
		//读取对应的表名
		$livs = $this->get_row('SELECT dbtname FROM '.DB_MX_PRE.'applivs WHERE id="'.$id.'"');
		$d = $this->get_tables();
		$temp = array();
		for($i=0;$i<count($d);$i++){
			if($d[$i]!=$livs['dbtname']){
				array_push($temp,$d[$i]);
			}
		}
		return $temp;
	}
	//得到字段信息
	public function gettabfield($tn)
	{
		return $this->get_fields($tn);
	}
	//更新数据库被更新次数
	public function updatedbnum($id)
	{
		$this->update('UPDATE '.DB_MX_PRE.'applivs SET iscrtdb=iscrtdb+1 WHERE id="'.$id.'"');
	}
	//填写图片处理信息
	public function picedit($fieldid)
	{
		$is = $this->get_row('SELECT id FROM '.DB_MX_PRE.'fieldupload WHERE fieldid="'.$fieldid.'"');
		$_POST['fieldid'] = $fieldid;
		$items = $this->get_fields(DB_MX_PRE.'fieldupload');
		if(empty($is['id'])){
			$this->insert(DB_MX_PRE.'fieldupload',$items);
		}else{
			$this->update(DB_MX_PRE.'fieldupload',$items,'id="'.$is['id'].'"');
		}
	}
	//得到图片处理信息
	public function getpicinfo($fieldid)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'fieldupload WHERE fieldid="'.$fieldid.'"');
	}
	//删除图片
	public function picdel($fieldid)
	{
		$this->delete(DB_MX_PRE.'fieldupload','fieldid="'.$fieldid.'"');
	}
	//获取字段列表信息
	public function getfdlistinfo($ids)
	{
		if(empty($ids)){
			return '';
		}else{
			$d = $this->get_all('SELECT fieldlabel,name FROM '.DB_MX_PRE.'fields WHERE id IN('.$ids.') ORDER BY sort ASC');
			$res = array();
			foreach($d as $list){
				array_push($res,$list['fieldlabel'].'('.$list['name'].')');
			}
			return join(",",$res);
		}
	}
}
?>