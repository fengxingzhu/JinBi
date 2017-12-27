<?php
/**
 * 会员列表
 */
class DataAct extends Action
{
	private $mod = '';
	public function DataAct()
	{
		$this->mod = $this->M('Data');
	}
	//读取列表
	public function getlist()
	{
		$_GET['page'] = $_POST['page'];
		$page = $this->mod->getlist($_POST['rp']);
		$data = $this->mod->get_all();
		foreach($data as $k=>$v){
			$data[$k]['passed'] = $v['passed']==1?'通过':'未通过';
			$data[$k]['__opt'] = '
			<a href="javascript:;" brurl="vip/user/?edit/id/'.$v['id'].'.html" class="mx-list-edit">修改</a>
			<a href="javascript:;" class="mx-list-remove" delid="'.$v['id'].'" delname="用户名为'.$v['username'].'信息" delurl="vip/user/do/?Data-del" backurl="vip/user/?app.html">删除</a>
			';
		}
		echo json_encode(array('rows'=>$data,'page'=>$_GET['page'],'total'=>$page['total']));
	}
	//新增
	public function add()
	{
		if($this->mod->isuseronlyone($_POST['username'])){
			$this->mod->add();
			echo json_encode(array('type'=>'ajaxcontent','url'=>'vip/user/?app.html'));
		}else{
			echo json_encode(array('type'=>'msg','msg'=>'用户名已经存在,请更换!'));
		}
	}
	//获取会员信息
	public function getinfo()
	{
		$data = $this->mod->getinfo($_GET['id']);
		$this->assign('data',json_encode($data));
	}
	//修改
	public function edit()
	{
		if($this->mod->isuseronlyone($_POST['username'],$_GET['id'])){
			$this->mod->edit($_GET['id']);
			echo json_encode(array('type'=>'ajaxcontent','url'=>'vip/user/?app.html'));
		}else{
			echo json_encode(array('type'=>'msg','msg'=>'用户名已经存在,请更换!'));
		}
	}
	//删除
	public function del()
	{
		$ids = empty($_GET['id'])?$_POST['ids']:$_GET['id'];
		$this->mod->del($ids);
	}
}
?>