<?php
/**
 * 一键更新
 */
class DataMod extends Model
{
	public function DataMod()
	{
		$this->Model();
	}
	//读取所有需要更新栏目菜单
	public function getmenus()
	{
		return $this->get_all('SELECT id,title FROM '.DB_MX_PRE.'menu WHERE frturl!="" AND crturl!="" ORDER BY id DESC');
	}
	//读取对应的菜单信息
	public function getlivsid($id)
	{
		$d = $this->get_row('SELECT livsid FROM '.DB_MX_PRE.'menu WHERE id="'.$id.'"');
		return $d['livsid'];
	}
	/**
	 * 获取对应的实例的表名
	 * @param int $livsid
	 */
	public function getdbtdata($livsid)
	{
		$d = $this->get_row('SELECT dbtname FROM '.DB_MX_PRE.'applivs WHERE id="'.$livsid.'"');
		return $d['dbtname'];
	}
	/**
	 * 获取栏目ID
	 * @param string $dbname 表名
	 * @param int $typeid 分类ID
	 */
	public function getdatas($dbname,$typeid)
	{
		return $this->get_all('SELECT * FROM '.$dbname.' WHERE __typeid="'.$typeid.'" ORDER BY id DESC');
	}
	/**
	 * 一键更新站点
	 */
	public function upsites()
	{
		//查找所有实例
		$livs = $this->get_all('SELECT * FROM '.DB_MX_PRE.'applivs');
		//清空所有全站搜索信息
		$this->query('TRUNCATE TABLE '.DB_MX_PRE.'sitesearch');
		foreach($livs as $lv){
			//读取实例对应的全站搜索字段
			$sitefds = $this->get_all('SELECT name FROM '.DB_MX_PRE.'fields WHERE appid="'.$lv['id'].'" AND sitesearch=1 ORDER BY sort ASC');
			$fdlist = array();
			foreach($sitefds as $kv){
				$fdlist[] = $kv['name'];
			}
			//存在全站搜索
			if(!empty($fdlist)){
				$fdvals = join(',',$fdlist);
				$data = $this->get_all('SELECT id,__typeid,__aurl,__hurl,CONCAT_WS(",",'.$fdvals.') AS data FROM '.$lv['dbtname'].' ORDER BY id ASC');
				if(!empty($data)){//写入到全站搜索中
					foreach($data as $dv){
						$_POST['tbname'] = $lv['dbtname'];
						$_POST['typeid'] = $dv['__typeid'];
						$_POST['detailid'] = $dv['id'];
						$_POST['data'] = $dv['data'];
						$_POST['__aurl'] = $dv['__aurl'];
						$_POST['__hurl'] = $dv['__hurl'];
						$this->insert(DB_MX_PRE.'sitesearch',array('tbname','typeid','detailid','data','__aurl','__hurl'));
					}
				}
			}
		}
	}
}
?>