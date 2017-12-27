<?php
/**
 * 模板列表
 */
class DetplAct extends Action
{
	public function DetplAct()
	{
		
	}
	//读取模板
	public function getpls()
	{
		$path = dirname(dirname(dirname(dirname(__FILE__))));
		$path = str_replace('\\','/',$path);
		$path = $path.'/modules/'.$_GET['mdtpl'].'/demo/tpls';
		$dh=opendir($path);
		$farr = array();
		while (false !== $file = readdir($dh))
		{
			if($file!="." && $file!="..")
			{
				array_push($farr,array(
					'mtpinfo'	=>	$_GET['mdtpl'],
					'file'		=>	$file
				));
			}
		}
		closedir($dh);
		return $farr;
	}
	//得到代码
	public function getcode()
	{
		$path = dirname(dirname(dirname(dirname(__FILE__))));
		$path = str_replace('\\','/',$path);
		$path = $path.'/modules/'.$_GET['mdtpl'].'/demo/tpls/'.$_GET['file'].'.html';
		$code = file_get_contents($path);
		$this->assign('TPLINFO','modules/'.$_GET['mdtpl'].'/demo/tpls/'.$_GET['file'].'.html');
		$this->assign('CODEINFO',$code);
	}
}
?>