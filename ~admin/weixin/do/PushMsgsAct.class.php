<?php
/**
 * 消息推送
 */
class PushMsgsAct extends Action
{
	private $mod = '';
	public function PushMsgsAct()
	{
		$this->mod = $this->M('PushMsgs');
	}
	//读取列表
	public function getlist()
	{
		$_GET['page'] = $_POST['page'];
		$page = $this->mod->getlist($_POST['rp']);
		$data = $this->mod->get_all();
		$msgtype = array('text'=>'文本','image'=>'图片','voice'=>'语音');
		foreach($data as $k=>$v){
			$data[$k]['msgtype'] = $msgtype[$v['msgtype']];
		}
		echo json_encode(array('rows'=>$data,'page'=>$_GET['page'],'total'=>$page['total']));
	}
	/**
	 * 读取粉丝列表
	 */
	public function getfans()
	{
		return $this->mod->getfans();
	}
	//删除
	public function del()
	{
		$ids = empty($_GET['id'])?$_POST['ids']:$_GET['id'];
		$this->mod->del($ids);
	}
}
?>