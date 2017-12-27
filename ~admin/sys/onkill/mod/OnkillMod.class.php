<?php
/**
 * 在线杀毒
 */
class OnkillMod extends Model
{
	public function OnkillMod()
	{
		$this->Model();
	}
	//获取日志
	public function getlist($s)
	{
		//搜索
		$dbname = DB_MX_PRE.'killpoison';
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
	//保存信息
	public function savescans($user,$filename,$filetotal)
	{
		$_POST['uid'] = $user['id'];
		$_POST['name'] = $user['name'];
		$_POST['filepath'] = $filename;
		$_POST['totalline'] = $filetotal;
		$items = $this->get_fields(DB_MX_PRE.'killpoison',array('optdate'));
		$this->insert(DB_MX_PRE.'killpoison',$items);
		return $this->get_insert_id();
	}
	//更新完成文件数
	public function upkilldot($curline,$insertid)
	{
		$this->update('UPDATE '.DB_MX_PRE.'killpoison SET scanline="'.$curline.'" WHERE id="'.$insertid.'"');
	}
	//保存结果
	public function savekillres($msg,$insertid)
	{
		$this->update('UPDATE '.DB_MX_PRE.'killpoison SET scanres="'.$msg.'" WHERE id="'.$insertid.'"');
	}
	//删除
	public function del($ids)
	{
		$this->delete(DB_MX_PRE.'killpoison','id IN('.$ids.')');
	}
}
?>