<?php
/**
 * 操作日志
 */
class DataMod extends Model
{
	public function DataMod()
	{
		$this->Model();
	}
	//获取日志
	public function getlist($s)
	{
		//搜索
		$searchsql = '';
		if(!empty($_POST['qtype'])){
			if($_POST['qtype']!='__allkeyword'){
				$searchsql .= ' AND '.$_POST['qtype'].' LIKE "%'.$_POST['query'].'%"';
			}else{
				if(!empty($_POST['query'])){//查询全部字段
					$items = array('name','mname','data');
					$seararr = array();
					for($i=0;$i<count($items);$i++) array_push($seararr,''.$items[$i].' LIKE "%'.$_POST['query'].'%"');
					$searchsql .= ' AND ('.join(' OR ',$seararr).')';
				}
			}
		}
		$tables = $this->get_tables();
		$tblen = count($tables);
		$sql = array();
		for($i=0;$i<$tblen;$i++){
			$st = strpos($tables[$i],DB_MX_PRE.'optlog_');
			if($st===0){
				$sql[] = 'SELECT * FROM '.$tables[$i];
			}
		}
		//默认排序
		$sortkey = empty($_POST['sortname'])?'id':$_POST['sortname'];
		$sortval = empty($_POST['sortorder'])?'DESC':$_POST['sortorder'];
		$this->set_sql(join(' UNION ',$sql).' WHERE 1'.$searchsql.' ORDER BY '.$sortkey.' '.$sortval);
		return $this->page_mod($s);
	}
	//获取单条日志
	public function getsim($id,$date)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'optlog_'.$date.' WHERE id="'.$id.'"');
	}
}
?>