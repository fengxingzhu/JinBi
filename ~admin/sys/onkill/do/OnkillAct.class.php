<?php
/**
 * 在线杀毒
 */
class OnkillAct extends Action
{
	private $scantype = array('html','htm','txt','js','css','php');
	private $nofiles = array(
		'.','..','.settings','.buildpath','.project'
	);
	private $regarr = array(
		"/<iframe(.+)src=http(.*) width=0 height=0><\/iframe>/im",
		"/<iframe(.+)src=http(.*) width=\"0\" height=\"0\"><\/iframe>/im",
		"/<iframe(.+)src=http(.*) width='0' height='0'><\/iframe>/im",
		"/<script(.+)src=http(.*)><\/script>/im",
		"/<script(.+)src='http(.*)'><\/script>/im",
		"/<script(.+)src=\"http(.*)\"><\/script>/im"
	);
	private $tempdata = "";
	private $filetotal = 0;
	private $user = "";
	private $taginfo = ",|,"; //分件分隔符标记
	private $mod = '';
	public function OnkillAct()
	{
		$this->mod = $this->M('Onkill');
		$this->user = Cache::session_get("MXUSER_INFO");
	}
	//读取操作日志
	public function glist()
	{
		$_GET['page'] = $_POST['page'];
		$page = $this->mod->getlist($_POST['rp']);
		$data = $this->mod->get_all();
		echo json_encode(array('rows'=>$data,'page'=>$_GET['page'],'total'=>$page['total']));
	}
	//扫描文件
	public function scans()
	{
		set_time_limit(0);//防止超时
		$this->scanfile(WEB_ROOT);
		$dir = 'temp';
		mk_dir($dir,0777);
		$filename = $dir.'/'.time().mt_rand(100,500).'.txt';
		file_put_contents($filename,$this->tempdata);
		//保存数据
		$insertid = $this->mod->savescans($this->user,$filename,$this->filetotal);
		
		Cache::session_set(array("KillFileName"=>$filename,"KillFileTotal"=>$this->filetotal,"KillFileStart"=>0,"KillFileId"=>$insertid));
		$this->scanjson(array(
			'end'	=>	0,
			'stepapp'	=>	'killdot',
			'msg'	=>	'<div>文件扫描已完成</div>'
		));
	}
	//扫描文件
	private function scanfile($dir)
	{
		$dh=opendir($dir);
		while (false !== $file = readdir($dh))
		{
			if(!in_array($file,$this->nofiles))
			{
				$fullpath=$dir."/".$file;
				if(is_dir($fullpath)){ //目录
					$this->scanfile($fullpath);
				}else{
					$extpos = strripos($file,".");
					$ext = substr($file,$extpos+1);
					$ext = strtolower($ext);
					if(in_array($ext,$this->scantype)){
						$this->tempdata .= $fullpath.$this->taginfo;
						$this->filetotal++;
					}
				}
			}
		}
	}
	//开始杀毒
	public function killdot()
	{
		$files = Cache::session_get("KillFileName");
		$total = Cache::session_get("KillFileTotal");
		$curline = Cache::session_get("KillFileStart");
		if(empty($files) || $curline>$total){
			$this->scanjson(array(
				'end'	=>	0,
				'stepapp'	=>	'endwork',
				'msg'	=>	'<div>正在处理结果...</div>'
			));
		}else{
			$insertid = Cache::session_get("KillFileId");
			
			$this->mod->upkilldot($curline,$insertid);			
			Cache::session_set("KillFileStart",$curline+1);
			
			$filetempstr = file_get_contents($files);
			$efile = explode($this->taginfo,$filetempstr);
			$curfilepath = $efile[$curline];
			
			$this->checkfiles($curfilepath); //查找文件
			
			$msg  = str_replace(WEB_ROOT,"",$curfilepath);
			$msg = $msg==""?"":'<div>正在分析'.$msg.'</div>';
			
			$this->scanjson(array(
				'end'	=>	0,
				'stepapp'	=>	'killdot',
				'msg'	=>	$msg
			));
		}
	}
	//扫描完成
	public function endwork()
	{
		$res = Cache::session_get("KillResults");
		if(empty($res)){
			$msg = "杀毒完成,没有发现可疑文件!";
		}else{
			$res = array_unique($res);
			$strtemp = join(",",$res);
			$strtemp = str_replace(WEB_ROOT,"",$strtemp);
			$msg = "杀毒完成,<span style='color:red'>发现可疑文件如下：".$strtemp."</span>";
		}
		//保存结果
		$insertid = Cache::session_get("KillFileId");
		$this->mod->savekillres($msg,$insertid);
		$this->scanjson(array(
			'end'	=>	1,
			'stepapp'	=>	'',
			'msg'	=>	'<div>'.$msg.'</div>'
		));
	}
	//文件检查
	private function checkfiles($path)
	{
		$res = Cache::session_get("KillResults");
		$res = empty($res)?array():$res;
		$code = file_get_contents($path);
		for($j=0;$j<count($this->regarr);$j++){
			if(preg_match($this->regarr[$j], $code)){
				array_push($res,$path);
			}
		}
		Cache::session_set("KillResults",$res);
	}
	//结果情况反应
	private function scanjson($arr)
	{
		echo json_encode($arr);
	}
	//删除
	public function del()
	{
		$this->mod->del($_POST['ids']);
	}
}
?>