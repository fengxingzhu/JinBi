<?php
/**
 * 数据库备份还原
 */
class DataAct extends Action
{
	private $bakdir = 'dbacks';
	private $mod = '';
	public function DataAct()
	{
		$this->mod = $this->M('Data');
	}
	//获取
	public function tableall()
	{
		$d = $this->mod->gettableall();
		$this->assign('tablelist',$d);
	}
	//数据库备份
	public function backdb()
	{
		if($_POST['weizhi']=="localpc"&&$_POST['fenjuan']=='yes'){
			echo json_encode(array('type'=>'msg','msg'=>'只有选择备份到服务器，才能使用分卷备份功能!'));
			exit();
		}
		if($_POST['fenjuan']=="yes" && !$_POST['filesize']>0){
			echo json_encode(array('type'=>'msg','msg'=>'您选择了分卷备份功能，但未填写分卷文件大小!'));
			exit();
		}
		if($_POST['bfzl']=="quanbubiao"){//备份全部数据
			$d = $this->mod->gettableall();
			$this->backtables($d,'_all');
		}else{ //单表备份
			if($_POST['tablename']==""){
				echo json_encode(array('type'=>'msg','msg'=>'请选择需要备份的表'));
				exit();
			}
			$this->backtables(array($_POST['tablename']),'_'.$_POST['tablename']);
		}
		echo json_encode(array('type'=>'msg','msg'=>'数据库备份完成!'));
	}
	private function backtables($d,$t)
	{
		if($_POST['weizhi']=='server'){//备份至服务器
			$backupdir = WEB_ROOT.$this->bakdir;
			mk_dir($backupdir,0777);
			if($_POST['weizhi']=="server" && !is_writable($backupdir)){
				echo json_encode(array('type'=>'msg','msg'=>'备份文件存放目录'.$backupdir.'不可写，请修改目录属性!'));
				exit();
			}
		}
		if($_POST['weizhi']=='localpc' && $_POST['bfzl']=='danbiao'){
			echo json_encode(array('type'=>'msg','msg'=>'备份到本地只能应用于备份全部数据!'));
			exit();
		}
		if($_POST['fenjuan']!='yes'){ //不分卷
			if(empty($d)){
				echo json_encode(array('type'=>'msg','msg'=>'不能读取数据表!'));
				exit();
			}
			$sql = ''; //sql文件
			for($i=0;$i<count($d);$i++){
				$sql .= $this->tablestruct($d[$i]);// 表结构
				$sql .= $this->gettablecont($d[$i]);//数据
			}
			if($_POST['weizhi']=='localpc'){
				$this->outfile($sql,date('YmdHis').$t.'.sql');
			}else{
				file_put_contents($backupdir.'/'.date('YmdHis').$t.'.sql',$sql);
			}
		}else{//分卷
			$filesize = intval($_POST['filesize']);
			if($filesize<1){
				echo json_encode(array('type'=>'msg','msg'=>'请填写备份文件分卷大小,分卷大小只能填写大于0的整数!'));
				exit();
			}
			if(empty($d)){
				echo json_encode(array('type'=>'msg','msg'=>'不能读取数据表!'));
				exit();
			}
			$sql = ''; //sql文件
			$p = 1; //分卷编号
			$splitupdir = $backupdir.'/'.date('YmdHis').$t;
			mk_dir($splitupdir,0777);
			$ilen = count($d);
			for($i=0;$i<$ilen;$i++){
				$sql .= $this->tablestruct($d[$i]);// 表结构
				$sql .= $this->gettablecont($d[$i]);//数据
				if(strlen($sql)>$filesize*1000){
					file_put_contents($splitupdir.'/sql_'.$p.'.sql',$sql);
					$p++;
					$sql='';
				}elseif ($i==$ilen-1){//写入最后一个文件
					file_put_contents($splitupdir.'/sql_'.$p.'.sql',$sql);
				}
			}
		}
	}
	//表单结构
	private function tablestruct($tn)
	{
		//创建表头
		$sql = "DROP TABLE IF EXISTS `".$tn."`;\n";
		$sql .= $this->mod->gettablecreate($tn).";\n";
		return $sql;
	}
	//读取数据内容
	private function gettablecont($tn)
	{
		$items = $this->mod->getfieldids($tn);
		$d = $this->mod->getdatas($tn);
		$sql = "INSERT INTO `".$tn."` (".join(',',$items).") VALUES \n";
		$fdarr = array();
		foreach($d as $list){
			$vtepm = array();
			foreach($list as $k=>$v) array_push($vtepm,"'".mysql_escape_string($v)."'");
			array_push($fdarr,"(".join(",",$vtepm).")");
		}
		if(empty($fdarr)){
			return '';
		}else{
			$sql .= join(",\n",$fdarr);
			$sql .= ";\n";
			return $sql;
		}
	}
	//输出文件
	private function outfile($sql,$filename)
	{
		header("Content-Encoding: none");
		header("Content-Type: ".(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') ? 'application/octetstream' : 'application/octet-stream'));		
		header("Content-Disposition: ".(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') ? 'inline; ' : 'attachment; ')."filename=".$filename);
		header("Content-Length: ".strlen($sql));
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $sql;
	}
	//读取数据备份文件
	public function getbakfile()
	{
		$path = WEB_ROOT.$this->bakdir;
		if(file_exists($path)){
			$dh=opendir($path);
			$bakinfo = array();
			while (false !== $file = readdir($dh))
			{
				if($file!="." && $file!="..")
				{
					array_push($bakinfo,$file);
				}
			}
			closedir($dh);
			$this->assign('bakdata',$bakinfo);
		}
	}
	//数据恢复
	public function backrestore()
	{
		if(empty($_POST['serverfile'])){
			echo json_encode(array('type'=>'msg','msg'=>'请选择服务器备份文件'));
			exit();
		}
		$path = WEB_ROOT.$this->bakdir;
		$fdir = $path.'/'.$_POST['serverfile'];
		if(is_dir($fdir)){
			$dh = opendir($fdir);
			while (false !== $file = readdir($dh))
			{
				if($file!="." && $file!="..")
				{
					$code = file_get_contents($fdir.'/'.$file);
					$this->mod->dosqlinfo($code);
				}
			}
			closedir($dh);
			echo json_encode(array('type'=>'msg','msg'=>'恢复成功'));
			exit();
		}else{
			$code = file_get_contents($fdir);
			$this->mod->dosqlinfo($code);
			echo json_encode(array('type'=>'msg','msg'=>'恢复成功'));
			exit();
		}
	}
}
?>