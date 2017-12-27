<?php
/**
 * 广告管理
 */
class DataMod extends Model
{
	public function DataMod()
	{
		$this->Model();
	}
	//获取广告列表
	public function getlist()
	{
		return $this->get_all('SELECT c1.*,c2.atitle FROM '.DB_MX_PRE.'mod_slots AS c1 LEFT JOIN '.DB_MX_PRE.'mod_advs AS c2 ON (c1.advmid=c2.id) ORDER BY id ASC');
	}
	//新增广告位
	public function add()
	{
		$items = $this->get_fields(DB_MX_PRE.'mod_slots');
		$this->insert(DB_MX_PRE.'mod_slots',$items);
	}
	//修改广告位
	public function edit($id)
	{
		$items = $this->get_fields(DB_MX_PRE.'mod_slots',array('datajson','dofun'));
		$this->update(DB_MX_PRE.'mod_slots',$items,'id="'.$id.'"');
	}
	//获取单个广告位
	public function getinfo($id)
	{
		return $this->get_row('SELECT * FROM '.DB_MX_PRE.'mod_slots WHERE id="'.$id.'"');
	}
	//删除广告位
	public function del($id)
	{
		$this->delete(DB_MX_PRE.'mod_slots','id="'.$id.'"');
	}
	//编辑广告
	public function advdata($id)
	{
		$d = $this->getinfo($id);
		$d['datajson'] = $_POST['datajson'];
		$md = $this->get_row('SELECT dofun FROM '.DB_MX_PRE.'mod_advs WHERE id="'.$d['advmid'].'"');
		$items = $this->get_fields(DB_MX_PRE.'mod_slots');
		$itemlen = count($items);
		$dofun = $md['dofun'];
		$dofun = str_replace('{id}', $d['id'],$dofun);
		for($i=0;$i<$itemlen;$i++)
			$dofun = str_replace('{'.$items[$i].'}', $d[$items[$i]],$dofun);
		$_POST['dofun'] = $dofun;
		$this->update(DB_MX_PRE.'mod_slots',array('datajson','dofun'),'id="'.$id.'"');
	}
	//获取预览信息
	public function gettview($id)
	{
		return $this->get_row('SELECT c1.*,c2.pubjs,c2.pubcss FROM '.DB_MX_PRE.'mod_slots AS c1 LEFT JOIN '.DB_MX_PRE.'mod_advs AS c2 ON (c1.advmid=c2.id) WHERE c1.id="'.$id.'"');
	}
}
?>