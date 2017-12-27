<?php
/**
 * 实例列表
 */
class LivsAct extends Action
{
	private $mod = '';
	private $userinfo = '';
	public function LivsAct()
	{
		$this->mod = $this->M('Livs');
		$this->userinfo = Cache::session_get("MXUSER_INFO");
	}
	//得到实例列表
	public function getlivs()
	{
		return $this->mod->getlivs($this->userinfo);
	}
	//获取单实例
	public function getsimlives()
	{
		$d = $this->mod->getsimlives($_GET['id']);
		$d['selcompt'] = $d['dir'];
		$this->assign('data',json_encode($d));
		$this->assign('info',$d);
	}
	//读取组件
	public function getcompents()
	{
		$path = dirname(dirname(dirname(dirname(__FILE__))));
		$path = str_replace('\\','/',$path);
		$path = $path.'/util';
		$dh=opendir($path);
		$d = array();
		while (false !== $file = readdir($dh))
		{
			if($file!="." && $file!="..")
			{
				$sondir = $path.'/'.$file;
				$config = include($sondir.'/config.php');
				array_push($d, array(
					'name'	=>	$config['name'],
					'tpinfo'	=>	$file,
					'dir'		=>	$file,
					'apiurl'	=>	$config['apiurl']
				));
			}
		}
		$this->assign('cmptdata',$d);
		closedir($dh);
	}
	//添加实例
	public function add()
	{
		$groups = $this->mod->getgroups($_POST['gid']);
		$n = $this->mod->isproname($_POST['proname']);
		if($n>0){
			echo json_encode(array('type'=>'msg','msg'=>'该实例程序名已经存在,请更换!'));
			die();
		}
		$user = Cache::session_get("MXUSER_INFO");
		$_POST['gdir'] = $groups['gdir'];
		$_POST['apiurl'] = str_replace('{AG}',$_POST['proname'],$_POST['apiurl']);
		$this->mod->add($user);
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/livs/?app.html'));
	}
	//修改实例
	public function edit()
	{
		$groups = $this->mod->getgroups($_POST['gid']);
		$n = $this->mod->isproname($_POST['proname'],$_GET['id']);
		if($n>0){
			echo json_encode(array('type'=>'msg','msg'=>'该实例程序名已经存在,请更换!'));
			die();
		}
		$_POST['gdir'] = $groups['gdir'];
		$_POST['apiurl'] = str_replace('{AG}',$_POST['proname'],$_POST['apiurl']);
		$startpos = strpos($_POST['apiurl'], 'ag/');
		$subtt = substr($_POST['apiurl'],$startpos+2);
		$esubtt = explode('/tp/',$subtt);
		$_POST['apiurl'] = str_replace($esubtt[0].'/','/'.$_POST['proname'].'/',$_POST['apiurl']);
		$this->mod->edit($_GET['id']);
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/livs/?app.html'));
	}
	//删除实例
	public function del()
	{
		$this->mod->del($_GET['id']);
	}
	//批量删除
	public function dels()
	{
		$this->mod->dels($_POST['ids']);
	}
	//更栏目管理状态
	public function toggleinfo()
	{
		$this->mod->toggleinfo($_POST['v'],$_GET['id']);
	}
}
?>