<?php
/**
 * 菜单管理
 */
class MenuAct extends Action
{
	private $mod = '';
	private $userinfo = '';
	public function MenuAct()
	{
		$this->mod = $this->M('Menu');
		$this->userinfo = Cache::session_get("MXUSER_INFO");
	}
	//读取菜单
	public function getlist()
	{
		$pid = empty($_GET['pid'])?0:$_GET['pid'];
		$data = $this->mod->getlist($pid,$this->userinfo);
		$this->assign('data',$data);
		$this->assign('SORTVAL',$data[count($data)-1]['sort']+1);
	}
	//读取上级目录
	public function readpmenu()
	{
		$title = $this->mod->getpmenu($_GET['pid']);
		$this->assign('TITLE_GUID',$title);
		$this->assign('PARENT_ID',empty($_GET['pid'])?0:$_GET['pid']);
	}
	//新增菜单
	public function add()
	{
		$this->mod->add($this->userinfo);
		$parent = $_POST['parent_id'];
		$parent = empty($parent)?0:$parent;
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/menu/?app/pid/'.$parent.'.html'));
	}
	//获取菜单
	public function getmenuinfo()
	{
		$data = $this->mod->getmenuinfo($_GET['id']);
		$this->assign('data',json_encode($data));
		$this->assign('info',$data);
	}
	//修改
	public function edit()
	{
		//修改
		$this->mod->edit($_GET['id']);
		$info = $this->mod->getmenuinfo($_GET['id']);
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/menu/?app/pid/'.$info['parent_id'].'.html'));
	}
	//删除
	public function del()
	{
		$info = $this->mod->getmenuinfo($_GET['id']);
		$this->mod->menudel($info['path'],$info['parent_id']);
	}
	//批量删除
	public function delmore()
	{
		$eids = explode(',',$_POST['ids']);
		for($i=0;$i<count($eids);$i++){
			if(!empty($eids[$i])){
				$info = $this->mod->getmenuinfo($eids[$i]);
				$this->mod->menudel($info['path'],$info['parent_id']);
			}
		}
	}
}
?>