<?php
/**
 * 站点管理
 */
class DataAct extends Action
{
	private $userinfo = '';
	public function DataAct()
	{
		$this->userinfo = Cache::session_get("MXUSER_INFO");
	}
	//读取站点
	public function getglist()
	{
		$this->cratedefsite();
		$website = read_cache_data('mx_website');
		$this->assign('data',$website);
	}
	//新增站点
	public function add()
	{
		//查找当前标识是否存在
		$this->cratedefsite();
		$website = read_cache_data('mx_website');
		$tagis = false;
		$wdata = array();
		foreach ($website as $list){
			if($list['tag'] == $_POST['tag']) $tagis = true;
			array_push($wdata,$list);
		}
		if($tagis){
			echo json_encode(array('type'=>'msg','msg'=>'该站点标识已经存在,请更换!'));
			exit();
		}
		//判断用户是否存在
		$m = $this->M('Data');
		$is = $m->getuseris($_POST['username']);
		if(empty($is)){
			//写入超管账号
			$m->addspuer();
			//写入系统后台菜单
			$m->menuadd($this->userinfo);
			//写入站点信息
			array_push($wdata,array('webname'=>$_POST['webname'],'tag'=>$_POST['tag'],'username'=>$_POST['username'],'summary'=>$_POST['summary']));
			write_cache_data($wdata,'mx_website');
			echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/verman/?app.html'));
		}else{
			echo json_encode(array('type'=>'msg','msg'=>'该账号已经存在,请更换超管账号!'));
		}
	}
	//删除站点
	public function delsite()
	{
		$website = read_cache_data('mx_website');
		$data = array();
		foreach ($website as $list){
			if($list['tag'] != $_POST['tag']) $data[] = $list;
		}
		write_cache_data($data,'mx_website');
		//删除超管账号
		$m = $this->M('Data');
		$m->deluser($_POST['tag']);
	}
	//创建默认数据
	private function cratedefsite()
	{
		$website = read_cache_data('mx_website');
		if(empty($website)){
			$data = array(
				array('webname'=>'默认站点','tag'=>'mx','username'=>'root','summary'=>'默认站点')
			);
			write_cache_data($data,'mx_website');
		}
	}
}
?>