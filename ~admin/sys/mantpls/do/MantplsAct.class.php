<?php
/**
 * 模板列表
 */
class MantplsAct extends Action
{
	public function MantplsAct()
	{
		
	}
	//读取模板
	public function getpls()
	{
		//读取模板文件名称
		$tpln = read_cache_data('mantpls_list_info');
		$path = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
		$path = str_replace('\\','/',$path);
		$path = $path.'/tpls';
		if(is_dir($path)){
			$dh=opendir($path);
			$farr = array();
			while (false !== $file = readdir($dh))
			{
				if($file!="." && $file!="..")
				{
					//查看模板名称是否存在
					$name = empty($tpln[$file])?'无模板名称':$tpln[$file];
					array_push($farr,array(
						'name'	=>	$name,
						'file'		=>	$file
					));
				}
			}
			closedir($dh);
			return $farr;
		}else{
			return array();
		}
	}
	//编辑模板名称
	public function editname()
	{
		//读取模板文件名称
		$tpln = read_cache_data('mantpls_list_info');
		$tpln[$_POST['f']] = $_POST['n'];
		write_cache_data($tpln, 'mantpls_list_info');
	}
	//得到代码
	public function getcode()
	{
		$path = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
		$path = str_replace('\\','/',$path);
		$path = $path.'/tpls/'.$_GET['file'].'.html';
		$code = file_exists($path)?file_get_contents($path):'';
		$this->assign('TPLINFO','tpls/'.$_GET['file'].'.html');
		$this->assign('CODEINFO',$code);
	}
	//保存代码
	public function save()
	{
		$code = stripslashes($_POST['code']);
		$path = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
		$path = str_replace('\\','/',$path);
		$path = $path.'/'.$_POST['filept'];
		file_put_contents($path,$code);
		echo json_encode(array('type'=>'ajaxcontent','url'=>'sys/mantpls/?app.html'));
	}
}
?>