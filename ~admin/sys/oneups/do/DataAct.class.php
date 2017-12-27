<?php
/**
 * 一键更新
 */
class DataAct extends Action
{
	private $mod = '';
	public function DataAct()
	{
		$this->mod = $this->M('Data');
	}
	/**
	 * 获取所有有缓存的栏目
	 */
	public function getups()
	{
		$d = $this->mod->getmenus();
		$this->assign('IDdata',json_encode($d));
	}
	/**
	 * 更新操作
	 */
	public function doup()
	{
		$typeid = $_GET['id'];
		$livsid = $this->mod->getlivsid($typeid);
		$dbtname = $this->mod->getdbtdata($livsid);
		$data = $this->mod->getdatas($dbtname,$typeid);
		foreach($data as $v){
			$htmlurl = $v['__hurl'];
			$acturl = $v['__aurl'];
			if($v['__aurl']!='' && $v['__hurl']!=''){
				mk_dir(dirname(WEB_ROOT.$htmlurl)); //写入目录
				$data = file_get_contents('http://'.LOCAL_IP.WEB_APP.$acturl);
				file_put_contents(WEB_ROOT.$htmlurl, $data);
			}
		}
	}
	/**
	 * 一键更新站点
	 */
	public function upsites()
	{
		$this->mod->upsites();
	}
}
?>