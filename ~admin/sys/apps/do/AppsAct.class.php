<?php
/**
 * 组件模型
 */
class AppsAct extends Action
{
	private $UID = '';
	public function AppsAct()
	{
		$this->UID = Cache::session_get("IMUSER_UID");
	}
	//读取应用的配置文件
	public function getapps()
	{
		$path = dirname(dirname(dirname(dirname(__FILE__))));
		$path = str_replace('\\','/',$path);
		$path = $path.'/apps';
		$dh=opendir($path);
		$str = '';
		while (false !== $file = readdir($dh))
		{
			if($file!="." && $file!="..")
			{
				$str .= '<h3 class="apps-title">'.$file.'</h3>';
				$sondir = $path.'/'.$file;
				$sondirdh=opendir($sondir);
				while (false !== $sfile = readdir($sondirdh)){
					if($sfile!="." && $sfile!=".."){
						$config = include($sondir.'/'.$sfile.'/config.php');
						$str .= '
						<a href="javascript:;" brurl="sys/apps/?add/tp/'.$file.'/dir/'.$sfile.'.html" class="icon">
							<div class="left"><img src="apps/'.$file.'/'.$sfile.'/icon.png" border="0"></div>
							<div class="right">
								<span>'.$config['name'].'</span>
								<div>'.$config['summary'].'</div>
							</div>
						</a>
						';
					}
				}
				$str .= '<div style="clear:both;"></div>';
			}
		}
		$this->assign('iconstr',$str);
		closedir($dh);
	}
	//创建应用
	public function getadd()
	{
		$path = dirname(dirname(dirname(dirname(__FILE__)))).'/apps';
		$path = str_replace('\\','/',$path);
		$apppath = $path.'/'.$_GET['tp'].'/'.$_GET['dir'];
		//实例中文名称和实例名称
		$config = include($apppath.'/config.php');
		$this->assign('info',$config);
		$suportdata = include($apppath.'/support.php');
		$supstr = '';
		foreach ($suportdata as $list){
			$supstr .= '
			<tr>
	          <td width="300">
			    <label>信息审核</label>
				<select name="syngrade_'.$list['fieldtable'].'">
					<option value="0">不需要审核</option>
					<option value="1">一级审核 </option>
					<option value="2">二级审核 </option>
					<option value="3">三级审核 </option>
					<option value="4">四级审核 </option>
				</select>
			  </td>
	        </tr>
			<tr>
	          <td width="300">
			    <label>('.$list['component'].')实例中文名称</label>
				<input type="text" name="livname_'.$list['fieldtable'].'" value="'.$list['livname'].'" dataType="Require" itip="请填写实例中文名称" />
			  </td>
	        </tr>
			<tr>
	          <td width="300">
			    <label>('.$list['component'].')实例名称</label>
				<input type="text" name="proname_'.$list['fieldtable'].'" value="'.$list['proname'].'" dataType="EngNumDl" itip="实例名称只能为英文,数字或下划线" />
			  </td>
	        </tr>
        	';
		}
		$this->assign('supstr',$supstr);
		$this->assign('TP',$_GET['tp']);
		$this->assign('DIR',$_GET['dir']);
	}
	//添加实例
	public function add()
	{
		$m = $this->M('Apps');
		$user = Cache::session_get("MXUSER_INFO");
		
		$adminpath = dirname(dirname(dirname(dirname(__FILE__))));
		$adminpath = str_replace('\\','/',$adminpath);
		$path = $adminpath.'/apps';
		$apppath = $path.'/'.$_GET['tp'].'/'.$_GET['dir'];
		//实例中文名称和实例名称
		$suportdata = include($apppath.'/support.php');
		foreach ($suportdata as $list){
			$groups = $m->getgroups($_POST['gid']);
			$_POST['livname'] = $_POST['mtype']=='user'?'会员管理':$_POST['livname_'.$list['fieldtable']];
			$_POST['proname'] = $_POST['mtype']=='user'?'siteuser':$_POST['proname_'.$list['fieldtable']];
			$_POST['syngrade'] = $_POST['mtype']=='user'?'0':$_POST['syngrade_'.$list['fieldtable']];
			//配置选项
			$_POST['cfg_add_key'] = $list['cfg_add_key'];
			$_POST['cfg_edit_key'] = $list['cfg_edit_key'];
			$_POST['cfg_del_key'] = $list['cfg_del_key'];
			$_POST['cfg_page_key'] = $list['cfg_page_key'];
			$_POST['cfg_handsort_key'] = $list['cfg_handsort_key'];
			$_POST['cfg_brower_key'] = $list['cfg_brower_key'];
			$_POST['cfg_top_key'] = $list['cfg_top_key'];
			$_POST['cfg_pub_key'] = $list['cfg_pub_key'];
			//创建实例
			$n = $m->isproname($_POST['proname']);
			if($n>0){
				echo json_encode(array('type'=>'msg','msg'=>'('.$list['type'].'-'.$list['component'].')实例名称已经存在,请更换!'));
				die();
			}
			$_POST['gdir'] = $groups['gdir'];
			//读取对应组件的信息
			$appconfig = include($adminpath.'/util/'.$list['component'].'/config.php');
			$_POST['tpinfo'] = $list['type'];
			$_POST['dir'] = $list['component'];
			$_POST['appname'] = $appconfig['name'];
			$_POST['isform'] = $appconfig['isform'];
			$_POST['apiurl'] = str_replace('{AG}',$_POST['proname_'.$list['fieldtable']],$appconfig['apiurl']);			
			$insertid = $m->add($user);
			//填表单属性
			$formdata = include($apppath.'/'.$list['fieldtable'].'_form.php');
			$m->formatr($insertid,$formdata);
			//装入字段信息
			$fielddata = include($apppath.'/'.$list['fieldtable'].'_fields.php');
			$m->fielddata($insertid,$fielddata);
		}
		echo json_encode(array('type'=>'tab','url'=>$_POST['jumpurl']));
	}
}
?>