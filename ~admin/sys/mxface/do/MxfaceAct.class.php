<?php
/**
 * 后台设置
 */
class MxfaceAct extends Action
{
	public function MxfaceAct()
	{
		
	}
	//得到后台头和尾信息
	public function gethfinfo()
	{
		$d = read_cache_data('mx_admin_headfoot');
		if(empty($d)){
			$d = array(
				'head'	=>	'MX 4.0',
				'foot'	=>	'MX 4.0'
			);
			write_cache_data($d,'mx_admin_headfoot');
		}
		$this->assign('info',$d);
	}
	//修改
	public function edit()
	{
		$d = array(
			'head'	=>	$_POST['head'],
			'foot'	=>	$_POST['foot']
		);
		write_cache_data($d,'mx_admin_headfoot');
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/mxface/?app.html'));
	}
}
?>