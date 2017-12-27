<?php
/**
 * 粉丝列表
 */
class FansAct extends Action
{
	private $mod = '';
	public function FansAct()
	{
		$this->mod = $this->M('Fans');
	}
	//读取列表
	public function getlist()
	{
		$_GET['page'] = $_POST['page'];
		$page = $this->mod->getlist($_POST['rp']);
		$data = $this->mod->get_all();
		$sex = array('未知','男','女');
		foreach($data as $k=>$v){
			$data[$k]['sex'] = $sex[$v['sex']];
			$data[$k]['headimgurl'] = '<img src="'.$v['headimgurl'].'" width="60" height="60" border="0" />';
		}
		echo json_encode(array('rows'=>$data,'page'=>$_GET['page'],'total'=>$page['total']));
	}
}
?>