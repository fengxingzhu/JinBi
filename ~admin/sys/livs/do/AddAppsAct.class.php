<?php
/**
 * 创建应用
 */
class AddAppsAct extends Action
{
	private $userinfo = '';
	public function AddAppsAct()
	{
		$this->userinfo = Cache::session_get("MXUSER_INFO");
	}
	//读取目录
	public function readdirs()
	{
		$path = dirname(dirname(dirname(dirname(__FILE__))));
		$path = str_replace('\\','/',$path);
		$path = $path.'/apps';
		$dh=opendir($path);
		$data = array();
		$str = '';
		while (false !== $file = readdir($dh))
		{
			if($file!="." && $file!="..")
			{
				array_push($data,$file);
			}
		}
		closedir($dh);
		$this->assign('dirdata',$data);
		$this->assign('APPIDS',$_GET['appids']);
	}
	//创建应用
	public function add()
	{
		$m = $this->M('AddApps');
		$path = dirname(dirname(dirname(dirname(__FILE__))));
		$path = str_replace('\\','/',$path);
		$adminpath = $path;
		$path = $path.'/apps';
		$tpdir = $path.'/'.$_POST['appdir'];
		$newpath = $tpdir.'/'.$_POST['enname'];
		if(file_exists($newpath)){
			echo json_encode(array('type'=>'msg','msg'=>'应用英文名称已经存在,请更换!'));
			exit();
		}
		//写配置文件
		$confdata = array(
			'name'		=>	$_POST['name'],
			'author'	=>	$_POST['author'],
			'summary'	=>	$_POST['summary']
		);
		write_cache_data($confdata,'config',$newpath.'/');
		//写取组件
		$eids = explode(',',$_POST['appids']);
		$support = array(); //需要的组件
		for($i=0;$i<count($eids);$i++){
			//组件实例信息
			$comptinfo = $m->getlivs($eids[$i]);
			array_push($support,array(
				'component'=>$comptinfo['dir'],
				'livname'=>$comptinfo['livname'],
				'proname'=>$comptinfo['proname'],
				'cfg_add_key'=>$comptinfo['cfg_add_key'],
				'cfg_edit_key'=>$comptinfo['cfg_edit_key'],
				'cfg_del_key'=>$comptinfo['cfg_del_key'],
				'cfg_page_key'=>$comptinfo['cfg_page_key'],
				'cfg_handsort_key'=>$comptinfo['cfg_handsort_key'],
				'cfg_brower_key'=>$comptinfo['cfg_brower_key'],
				'cfg_top_key'=>$comptinfo['cfg_top_key'],
				'cfg_pub_key'=>$comptinfo['cfg_pub_key'],
				'fieldtable'=>$i
			));
			//表单属性
			$formatr = $m->formatr($eids[$i]);
			$formdata = array(
				'colspan'	=>	$formatr['colspan'],
				'width'		=>	$formatr['width']
			);
			//写入表单属性
			write_cache_data($formdata,$i.'_form',$newpath.'/');
			//字段信息 写入字段信息
			$fields = $m->getfielddata($eids[$i]);
			write_cache_data($fields,$i.'_fields',$newpath.'/');
		}
		//写入需要的组件支持
		write_cache_data($support,'support',$newpath.'/');
		//复制默认图标
		copy($adminpath.'/images/icon.png',$newpath.'/icon.png');
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/livs/?app.html'));
	}
}
?>