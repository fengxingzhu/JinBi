<?php
/**
 * 消息列表
 */
class MsgsAct extends Action
{
	private $mod = '';
	public function MsgsAct()
	{
		$this->mod = $this->M('Msgs');
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
			$data[$k]['picurl'] = empty($v['picurl'])?'':'<img src="'.$v['picurl'].'" width="60" height="60" border="0" />';//图片地址
			$data[$k]['createtime'] = date('Y-m-d H:i:s',$v['createtime']);
		}
		echo json_encode(array('rows'=>$data,'page'=>$_GET['page'],'total'=>$page['total']));
	}
}
?>