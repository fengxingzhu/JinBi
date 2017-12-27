<?php
/**
 * 表单管理
 */
class FieldsAct extends Action
{
	private $mod = '';
	public function FieldsAct()
	{
		$this->mod = $this->M('Fields');
	}
	//列表 
	public function getflist()
	{
		$d = $this->mod->getfields($_GET['id']);
		$this->assign('data',$d);
		$this->assign('SORTVAL',$d[count($d)-1]['sort']+1);
	}
	//读取表单项
	public function getlivs()
	{
		$d = $this->mod->getinsta($_GET['id']);
		$this->assign('info',$d);
	}
	//获取关联实例
	public function getotrlivs()
	{
		$d = $this->mod->getotrlivs($_GET['id']);
		$this->assign('livslist',$d);
	}
	//得到字段信息
	public function getfieldinfo()
	{
		$d = $this->mod->getfield($_GET['fid']);
		if(!empty($_GET['fid'])) $this->assign('fieldata','<textarea name="formDataInfo" class="mx-formdata">'.json_encode($d).'</textarea>');
		$this->assign('fielinfo',$d);
		$this->assign('actinfo',empty($_GET['fid'])?'add':'edit/fid/'.$_GET['fid']);
		
		$this->getvalidainfo();
	}
	//得到字段信息
	public function getfdinfo()
	{
		$d = $this->mod->getfield($_GET['fid']);
		$this->assign('fieldata',$d);
		//得到对应的字段的键值信息
		$fds = $this->mod->getfdinfo($_GET['fid']);
		$this->assign('fdtydata',$fds);
		//查看sort最大值
		$this->assign('SORTINFO',$fds[count($fds)-1]['sort']+1);
	}
	
	//添加字段
	public function add()
	{
		$n = $this->mod->isexits($_POST['appid'],$_POST['name']);
		if($n>0){
			echo json_encode(array('type'=>'msg','msg'=>'该字段名已经存在或为系统保留字,请更换!'));
			exit();
		}
		$this->mod->add();
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/fields/?app/id/'.$_POST['appid'].'.html'));
	}
	//修改字段
	public function edit()
	{
		$n = $this->mod->isexits($_POST['appid'],$_POST['name'],$_GET['fid']);
		if($n>0){
			echo json_encode(array('type'=>'msg','msg'=>'该字段名已经存在或为系统保留字,请更换!'));
			exit();
		}
		$this->mod->edit($_GET['fid']);
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/fields/?app/id/'.$_POST['appid'].'.html'));
	}
	//删除字段
	public function del()
	{
		$this->mod->del($_GET['id']);
	}
	//更新表单
	public function createdbt()
	{
		$this->simpledbct($_GET['id']);
	}
	//批量更新
	public function createdbtmore()
	{
		$eids = explode(',',$_GET['ids']);
		for($i=0;$i<count($eids);$i++){
			if(!empty($eids[$i]))
				$this->simpledbct($eids[$i]);
		}
	}
	//更新一个数据表
	private function simpledbct($id)
	{
		//读取实例信息
		$livs = $this->mod->getlvinfo($id);
		$tables = $this->mod->get_tables();
		$bakdbname = $livs['dbtname'].'_bak';
		//备份原表
		if(in_array($livs['dbtname'],$tables) && !in_array($bakdbname,$tables)){
			$this->mod->query('RENAME TABLE `'.$livs['dbtname'].'` TO `'.$bakdbname.'` ;');
		}
		//查看是否有tree表
		$treedbname = $livs['dbtname'].'_tree';
		if(in_array($treedbname,$tables) && !in_array($treedbname.'_bak',$tables)){
			$this->mod->query('RENAME TABLE `'.$treedbname.'` TO `'.$treedbname.'_bak` ;');
		}
		//后台根目录
		$path = dirname(dirname(dirname(dirname(__FILE__))));
		$path = str_replace('\\','/',$path);
		//应用程序目录
		$gpdir = $path.'/util/'.$livs['dir'];
		//读取表头文件
		$code = file_get_contents($gpdir.'/db.sql');
		$code = str_replace('{TAG_DBNAME}',$livs['dbtname'],$code);
		$ecode = explode(";",$code);
		for($i=0;$i<count($ecode);$i++){
			if(!empty($ecode[$i]) && $ecode[$i]!=''){
				$this->mod->query($ecode[$i]);
			}
		}
		require_once 'FieldSql.class.php';
		$fdtemp = new FieldSql();
		//读取字段
		$fields = $this->mod->getfdlist($id);
		if(!empty($fields)){
			foreach($fields as $list){//字段添加
				$funame = $list['xtype'];
				$fdtemp->{$funame}($livs['dbtname'],$list);
			}
		}
		//恢复数据
		$tables = $this->mod->get_tables();
		if(in_array($bakdbname,$tables)){
			$bakitem = $this->mod->get_fields($bakdbname);
			$bakitemlen = count($bakitem);
			$bakdata = $this->mod->get_all('SELECT * FROM '.$bakdbname.'');
			$newitem = $this->mod->get_fields($livs['dbtname']);
			array_push($newitem,'id'); //将ID也添加上
			foreach ($bakdata as $v){
				$_POST['id'] = $v['id'];
				for($i=0;$i<$bakitemlen;$i++)
					$_POST[$bakitem[$i]] = $v[$bakitem[$i]];
				$this->mod->insert($livs['dbtname'],$newitem);
			}
			$this->mod->query('DROP TABLE '.$bakdbname.'');
		}
		//恢复树型结构信息
		if(in_array($treedbname.'_bak',$tables)){
			$bakitem = $this->mod->get_fields($treedbname);
			$bakitemlen = count($bakitem);
			$bakdata = $this->mod->get_all('SELECT * FROM '.$treedbname.'_bak');
			$newitem = $this->mod->get_fields($treedbname);
			array_push($newitem,'id'); //将ID也添加上
			foreach ($bakdata as $v){
				$_POST['id'] = $v['id'];
				for($i=0;$i<$bakitemlen;$i++)
					$_POST[$bakitem[$i]] = $v[$bakitem[$i]];
				$this->mod->insert($treedbname,$newitem);
			}
			$this->mod->query('DROP TABLE '.$treedbname.'_bak');
		}
		//更新一下数据被更新的次数
		$this->mod->updatedbnum($id);
	}
	//表单属性
	public function getformatr()
	{
		$d = $this->mod->getformatr($_GET['id']);
		$this->assign('form',$d);
	}
	//修改表单属性
	public function formedit()
	{
		$this->mod->editform($_POST['appid']);
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/fields/?app/id/'.$_POST['appid'].'.html'));
	}
	//得到图片处理信息
	public function getpiceditinfo()
	{
		//颜色代码
		$cfdir = dirname(dirname(dirname(dirname(__FILE__))));
		$color = include($cfdir.'/configs/cutimgbg.php');
		$cing = '';
		foreach($color as $k=>$v)
			$cing .= '<option value="'.$k.'">'.$v['name'].'</option>';
		$this->assign('colorbg',$cing);
		//获取生成数据
		$d = $this->mod->getpicinfo($_GET['fid']);
		$this->assign('datapic',json_encode($d));
		$this->assign('datainfo',$d);
	}
	//修改图片处理信息
	public function formpicedit()
	{
		$this->mod->picedit($_GET['fid']);
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/fields/?app/id/'.$_GET['id'].'.html'));
	}
	//删除图片信息
	public function formpicdel()
	{
		$this->mod->picdel($_GET['fid']);
		echo JS('tabtreecontent("sys/fields/?picupload/id/'.$_GET['id'].'/fid/'.$_GET['fid'].'.html");');
	}
	//表单验证信息
	public function getvalidainfo()
	{
		$datatype = array(
			array('val'	=>	'','text'	=>	'无'),
			array('val'	=>	'Require','text'	=>	'必须填写'),
			array('val'	=>	'English','text'	=>	'英文'),
			array('val'	=>	'Number','text'	=>	'数字'),
			array('val'	=>	'Integer','text'	=>	'整数'),
			array('val'	=>	'EngNum','text'	=>	'英文和数字'),
			array('val'	=>	'Chinese','text'	=>	'中文'),
			array('val'	=>	'Phone','text'	=>	'手机电话'),
			array('val'	=>	'Email','text'	=>	'邮箱')
		);
		$this->assign('datatype',$datatype);
	}
	//新增字段分类数据
	public function datadd()
	{
		$this->mod->datadd($_GET['fieldid']);
	}
	//修改数据
	public function dataedit()
	{
		$this->mod->dataedit($_GET['id'],$_POST['name'],$_POST['val']);
	}
	//更改默认排序
	public function updefsort()
	{
		$this->mod->updefsort($_GET['id']);
	}
	//得到所有表 除当前表外
	public function gettables()
	{
		$d = $this->mod->gettables($_GET['id']);
		$this->assign('tableslist',$d);
	}
	//根据表得到字段信息
	public function getfields()
	{
		$d = $this->mod->gettabfield($_POST['tname']);
		echo join(",",$d);
	}
	//读取配套的URL参数
	public function geturlconf()
	{
		$d = $this->mod->getinsta($_GET['id']);
		//后台根目录
		$path = dirname(dirname(dirname(dirname(__FILE__))));
		$path = str_replace('\\','/',$path);
		$mdfile = $path.'/util/'.$d['tpinfo'].'/'.$d['dir'];
		$cnf = include($mdfile.'/urlcnf.php');
		$this->assign('CNF',$cnf);
		//读取字段信息
		$fdlist = $this->mod->getfdlistinfo($d['searchfdids']);
		$this->assign('FDODINFO',$fdlist);
	}
	//获得默认数据信息
	public function getdefdata()
	{
		//后台根目录
		$path = dirname(dirname(dirname(dirname(__FILE__))));
		$path = str_replace('\\','/',$path);
		$path = $path.'/fieldatas';
		$dh=opendir($path);
		$str = array();
		while (false !== $file = readdir($dh))
		{
			if($file!="." && $file!="..")
			{
				$condir = $path.'/'.$file.'/config.php';
				if(file_exists($condir)){
					$config = include($condir);
					$str .= '<option value="'.$file.'">'.$config['name'].'</option>';
				}
			}
		}
		$this->assign('datadefstring',$str);
		closedir($dh);
	}
}
?>