<?php
/**
 * 邮箱配置
 */
class DataAct extends Action
{
	public function DataAct()
	{
		
	}
	//得到邮箱配置
	public function getconf()
	{
		$data = read_cache_data('mx_mail');
		$this->assign('info',$data);
		$this->assign('data',json_encode($data));
	}
	//写入邮箱配置
	public function add()
	{
		$data = array(
			'smtp'	=>	$_POST['smtp'],
			'port'	=>	$_POST['port'],
			'useremail'	=>	$_POST['useremail'],
			'password'	=>	$_POST['password']
		);
		write_cache_data($data,'mx_mail');
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/mailsd/?app.html'));
	}
}
?>