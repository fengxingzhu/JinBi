<?php
/**
 * 自动回复管理
 */
class AutoReplyAct extends Action
{
	private $mod = '';
	public function AutoReplyAct()
	{
		$this->mod = $this->M('AutoReply');
	}
	//读取列表
	public function getlist()
	{
		$_GET['page'] = $_POST['page'];
		$page = $this->mod->getlist($_POST['rp']);
		$data = $this->mod->get_all();
		foreach($data as $k=>$v){
			$data[$k]['__opt'] = '<a href="javascript:;" brurl="weixin/?autoreply_edit/id/'.$v['id'].'.html" class="mx-list-edit">修改</a>';
		}
		echo json_encode(array('rows'=>$data,'page'=>$_GET['page'],'total'=>$page['total']));
	}
	//新增
	public function add()
	{
		$this->mod->add();
		echo json_encode(array('type'=>'ajaxcontent','url'=>'weixin/?autoreply.html'));
	}
	//获取关键字信息
	public function getinfo()
	{
		$data = $this->mod->getinfo($_GET['id']);
		$this->assign('data',json_encode($data));
	}
	//修改
	public function edit()
	{
		$this->mod->edit($_GET['id']);
		echo json_encode(array('type'=>'ajaxcontent','url'=>'weixin/?autoreply.html'));
	}
	//删除
	public function del()
	{
		$ids = empty($_GET['id'])?$_POST['ids']:$_GET['id'];
		$this->mod->del($ids);
	}
}
?>