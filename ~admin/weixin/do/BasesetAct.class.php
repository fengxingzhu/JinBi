<?php
/**
 * 微信基础设置
 */
class BasesetAct extends Action
{
	public function __construct()
	{
		
	}
	//得到后台头和尾信息
	public function getconfigs()
	{
		$d = read_cache_data('wx_configs');
		$this->assign('info',$d);
	}
	/**
	 * 保存基本配置信息
	 */
	public function configs()
	{
		$data = array('token'=>$_POST['token'],'subscribe'=>$_POST['subscribe'],'appid'=>$_POST['appid'],'appsecret'=>$_POST['appsecret']);
		write_cache_data($data, 'wx_configs');
		echo json_encode(array('type'=>'msg','msg'=>'基础设置保存成功!'));
	}
}
?>