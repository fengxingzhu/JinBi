<?php
/**
 * JS优化处理
 */
require_once WEB_ROOT.SYS_LIBS.'/tools/JavaScriptPacker.class.php';
class JSAct extends Action
{
	public function get()
	{
		$script = '';
		$path = $_GET['path'];
		$compdir = '../jcomp/';
		if(file_exists($compdir.$path.'.js')){
			$script = file_get_contents($compdir.$path.'.js');
		}else{
			$ejs = explode(',',$_GET['js']);
			for($i=0;$i<count($ejs);$i++){
				$script .= file_get_contents('../'.$path.'/'.$ejs[$i].'.js');
			}
			if($_GET['y']==1){
				$myPacker = new JavaScriptPacker($script, 0, false, false);
			 	$script = $myPacker->pack();
			}
			mk_dir($compdir,0777);
			file_put_contents($compdir.$path.'.js',$script);
		}
		echo $script;
	}
}
?>