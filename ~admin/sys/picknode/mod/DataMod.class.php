<?php
/**
 * 结点设置
 */
class DataMod extends Model
{
	public function DataMod()
	{
		$this->Model();
	}
	//读取结点列表
	public function getnodelist()
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'picknode ORDER BY cdate DESC');
	}
	//添加结点
	public function nodeadd()
	{
		$items = $this->get_fields(DB_MX_PRE.'picknode',array('cdate'));
		$this->insert(DB_MX_PRE.'picknode',$items);
	}
	//修改结点
	public function nodeedit($id)
	{
		$items = $this->get_fields(DB_MX_PRE.'picknode',array('cdate'));
		$this->update(DB_MX_PRE.'picknode',$items,'id="'.$id.'"');
	}
	//删除结点
	public function nodedel($id)
	{
		$this->delete(DB_MX_PRE.'picknode','id IN('.$id.')');
	}
	//读取结点信息
	public function nodesummary($id)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'picknode WHERE id="'.$id.'"');
	}
	//写入缓存
	public function nodecache($id,$arr)
	{
		//查看是否已经存在,如果存在则不写入
		$is = $this->get_num('SELECT * FROM '.DB_MX_PRE.'picktemps WHERE links="'.$arr['links'].'"');
		if($is<1){//如果不存在则写入
			$_POST['nodeid'] = $id;
			$_POST['title'] = $arr['title'];
			//"" 号中写的绝对路径  --冯 15-02-15
			$webinfo=$this->nodesummary($id);
			$_POST['links'] = $webinfo['weblinks'].$arr['links'];
			$this->insert(DB_MX_PRE.'picktemps',array('nodeid','title','links'));
		}
	}
	//读取组件实例
	public function getcomplivs()
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'applivs ORDER BY id DESC');
	}
	//读取字段配置信息
	public function getfields($appid)
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'fields WHERE appid="'.$appid.'" ORDER BY sort ASC');
	}
	/**
	 * 获取设置字段信息
	 * @param int $nodeid 结点ID
	 * @param string $fieldname 字段名
	 */
	public function getfdpicks($nodeid,$fieldname)
	{
		$d = $this->get_row('SELECT fdpickype FROM '.DB_MX_PRE.'pickimport WHERE nodeid="'.$nodeid.'" AND fieldname="'.$fieldname.'"');
		return $d['fdpickype'];
	}
	//保存设置信息
	public function savesetinfo($nodeid,$field)
	{
		$is = $this->get_row('SELECT * FROM '.DB_MX_PRE.'pickimport WHERE nodeid="'.$nodeid.'" AND fieldname="'.$field.'"');
		if(empty($is)){//如果不存在
			$_POST['nodeid'] = $_GET['nodeid'];
			$_POST['fieldname'] = $_GET['fieldname'];
			$items = $this->get_fields(DB_MX_PRE.'pickimport');
			$this->insert(DB_MX_PRE.'pickimport',$items);
		}else{
			$items = $this->get_fields(DB_MX_PRE.'pickimport',array('nodeid','fieldname'));
			$this->update(DB_MX_PRE.'pickimport',$items,'id="'.$is['id'].'"');
		}
	}
	//读取对应的分类标识
	public function getlivtypes($nodeid)
	{
		$nodeinfo = $this->get_row('SELECT livid FROM '.DB_MX_PRE.'picknode WHERE id="'.$nodeid.'"');
		$menus = $this->get_all('SELECT * FROM '.DB_MX_PRE.'menu WHERE livsid="'.$nodeinfo['livid'].'" ORDER BY grade ASC,sort ASC');
		//计算分类标识
		$resarr = array();
		foreach($menus as $v){
			$link = str_replace('.html', '', $v['admurl']);
			$elink = explode('/',$link);
			$typeid = $elink[count($elink)-1];
			if($typeid!='all')
				$resarr[] = array('name'=>$v['title'],'typeid'=>$typeid);
		}
		return $resarr;
	}
	//删除保存设置
	public function delsetinfo($nodeid,$field)
	{
		$this->delete(DB_MX_PRE.'pickimport','nodeid="'.$nodeid.'" AND fieldname="'.$field.'"');
	}
	//读取设置信息
	public function getoutdata($nodeid)
	{
		return $this->get_all('SELECT * FROM '.DB_MX_PRE.'pickimport WHERE nodeid="'.$nodeid.'"');
	}
}
?>