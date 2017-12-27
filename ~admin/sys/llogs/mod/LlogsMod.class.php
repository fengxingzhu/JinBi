<?php
/**
 * 登录日志
 */
class LlogsMod extends Model
{
	public function LlogsMod()
	{
		$this->Model();
	}
	//获取日志
	public function getlist($s)
	{
		//搜索
		$dbname = DB_MX_PRE.'loginlogs';
		$searchsql = '';
		if(!empty($_POST['qtype'])){
			if($_POST['qtype']!='__allkeyword'){
				$searchsql = ' AND '.$_POST['qtype'].' LIKE "%'.$_POST['query'].'%"';
			}else{
				if(!empty($_POST['query'])){//查询全部字段
					$items = $this->get_fields($dbname,array('uid'));
					$seararr = array();
					for($i=0;$i<count($items);$i++) array_push($seararr,''.$items[$i].' LIKE "%'.$_POST['query'].'%"');
					$searchsql = ' AND ('.join(' OR ',$seararr).')';
				}
			}
		}
		//默认排序
		$sortkey = empty($_POST['sortname'])?'id':$_POST['sortname'];
		$sortval = empty($_POST['sortorder'])?'DESC':$_POST['sortorder'];
		$this->set_sql('SELECT * FROM '.$dbname.' WHERE 1'.$searchsql.' ORDER BY '.$sortkey.' '.$sortval);
		return $this->page_mod($s);
	}
	//删除
	public function del($ids)
	{
		$this->delete(DB_MX_PRE.'loginlogs','id IN('.$ids.')');
	}
}
?>