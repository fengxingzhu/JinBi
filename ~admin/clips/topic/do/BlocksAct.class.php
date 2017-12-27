<?php
/**
 * 板块模型
 */
class BlocksAct extends Action
{
	//数据库对象
	private $mod = '';
	//风格ID
	private $stid = '';
	/**
	 * 构造函数
	 */
	public function BlocksAct()
	{
		$this->mod = $this->M('Blocks');
		$this->stid = intval($_GET['stid']);
		$this->assign('STID',$this->stid);
		$stname = $this->mod->getstsname($this->stid);
		$this->assign('STNAME',$stname);
	}
	/**
	 * 获取板块模型列表
	 */
	public function getlist()
	{
		return $this->mod->getlist($this->stid);
	}
	/**
	 * 生成对应的模板
	 */
	private function uptemplte()
	{
		$data = $this->getlist();
		$ot = new Template();
		$tplarr = array();
		foreach($data as $v){
			$tpl = $v['viewcode'];
			$tpl = str_replace('from="data"','from="data_'.$v['id'].'"',$tpl);
			$tplarr[] = $tpl;
		}
		//读取母板
		$mdir = WEB_ROOT.'topic/tpls/';
		$mt = file_get_contents($mdir.'app.html');
		$data = str_replace('{topicblocks}', join('',$tplarr), $mt);
		file_put_contents($mdir.'st_'.$this->stid.'.html',$data);
	}
	/**
	 * 新增板块模型
	 */
	public function add()
	{
		$this->mod->add();
		$this->uptemplte();
		echo json_encode(array('type'=>'ajaxcontent','url'=>'clips/topic/?block/stid/'.$this->stid.'.html'));
	}
	/**
	 * 通过ID获取板块模型信息
	 */
	public function getinfo()
	{
		$d = $this->mod->getinfo($_GET['id']);
		$this->assign('info',$d);
		$this->assign('data',json_encode($d));
	}
	/**
	 * 修改板块模型
	 */
	public function edit()
	{
		$this->mod->edit($_GET['id']);
		$this->uptemplte();
		echo json_encode(array('type'=>'ajaxcontent','url'=>'clips/topic/?block/stid/'.$this->stid.'.html'));
	}
	/**
	 * 删除板块模型
	 */
	public function del()
	{
		$this->mod->del($_GET['id']);
		$this->uptemplte();
	}
}
?>