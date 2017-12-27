<?php
/**
 * 广告模型
 */
class AdvmodAct extends Action
{
	//数据库句柄
	private $mod = '';
	/**
	 * 构造函数
	 */
	public function AdvmodAct()
	{
		$this->mod = $this->M('Advmod');
	}
	/**
	 * 获取模型列表
	 */
	public function getlist()
	{
		return $this->mod->getlist();
	}
	/**
	 * 新增模型
	 */
	public function add()
	{
		$this->mod->add();
		$this->createpubres();
		echo json_encode(array('type'=>'ajaxcontent','url'=>'clips/adv/?advs.html'));
	}
	/**
	 * 通过ID获取模型信息
	 */
	public function getinfo()
	{
		$d = $this->mod->getinfo($_GET['id']);
		$this->assign('info',$d);
		$this->assign('data',json_encode($d));
	}
	/**
	 * 修改模型
	 */
	public function edit()
	{
		$this->mod->edit($_GET['id']);
		$this->createpubres();
		echo json_encode(array('type'=>'ajaxcontent','url'=>'clips/adv/?advs.html'));
	}
	/**
	 * 删除模型
	 */
	public function del()
	{
		$this->mod->del($_GET['id']);
		$this->createpubres();
	}
	/**
	 * 生成公共应用的JS和CSS
	 */
	private function createpubres()
	{
		$cdir = WEB_ROOT.'cpubs';
		$cssdir = $cdir.'/css/';
		$jsdir = $cdir.'/js/';
		mk_dir($cssdir);
		$data = $this->mod->getlist();
		$arrjs = array();
		$arrcss = array();
		foreach($data as $list){
			$arrjs[] = $list['pubjs'];
			$arrcss[] = $list['pubcss'];
		}
		$basejs = file_get_contents($jsdir.'base.js');
		file_put_contents($cssdir.'commons.css',join('', $arrcss));
		file_put_contents($jsdir.'commons.js',join('', $arrjs).$basejs);
	}
}
?>