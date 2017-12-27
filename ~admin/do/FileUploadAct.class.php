<?php
/**
 * 文件上传
 */
class FileUploadAct extends Action
{
	/**
	 * 添加文件
	 */
	public function add()
	{
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		
		// Settings
		$targetDir = WEB_ROOT."asset/mxupload";
		$cleanupTargetDir = true; // Remove old files
		$maxFileAge = 5 * 3600; // Temp file age in seconds
		
		// 5 minutes execution time
		@set_time_limit(5 * 60);
		
		// Uncomment this one to fake upload time
		// usleep(5000);
		
		// Get parameters
		$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
		$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
		$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';
		$oldfileName = $fileName;
		// Clean the fileName for security reasons
		$fileName = preg_replace('/[^\w\._]+/', '_', $fileName);
		// Make sure the fileName is unique but only if chunking is disabled
		if ($chunks < 2 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)) {
			$ext = strrpos($fileName, '.');
			$fileName_a = substr($fileName, 0, $ext);
			$fileName_b = substr($fileName, $ext);
		
			$count = 1;
			while (file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName_a . '_' . $count . $fileName_b))
				$count++;
		
			$fileName = $fileName_a . '_' . $count . $fileName_b;
		}
		
		$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
		
		// Create target dir
		if (!file_exists($targetDir))
			mk_dir($targetDir);
		
		// Remove old temp files	
		if ($cleanupTargetDir && is_dir($targetDir) && ($dir = opendir($targetDir))) {
			while (($file = readdir($dir)) !== false) {
				$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;
		
				// Remove temp file if it is older than the max age and is not the current file
				if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge) && ($tmpfilePath != "{$filePath}.part")) {
					@unlink($tmpfilePath);
				}
			}
			closedir($dir);
		} else
			die('{"jsonrpc":"2.0","error":"无法创建资源文件夹"}');
			
		
		// Look for the content type header
		if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
			$contentType = $_SERVER["HTTP_CONTENT_TYPE"];
		
		if (isset($_SERVER["CONTENT_TYPE"]))
			$contentType = $_SERVER["CONTENT_TYPE"];
		
		// Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
		if (strpos($contentType, "multipart") !== false) {
			if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
				// Open temp file
				$out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
				if ($out) {
					// Read binary input stream and append it to temp file
					$in = fopen($_FILES['file']['tmp_name'], "rb");
					if ($in) {
						while($buff = fread($in, 4096))
							fwrite($out, $buff);
					} else
						die('{"jsonrpc":"2.0","error":"写入文件资源失败!"}');
					fclose($in);
					fclose($out);
					@unlink($_FILES['file']['tmp_name']);
				} else
					die('{"jsonrpc":"2.0","error":"输出文件资源失败!"}');
			} else
				die('{"jsonrpc":"2.0","error":"上传文件资源失败"}');
		} else {
			// Open temp file
			$out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
			if ($out) {
				// Read binary input stream and append it to temp file
				$in = fopen("php://input", "rb");
		
				if ($in) {
					while ($buff = fread($in, 4096))
						fwrite($out, $buff);
				} else
					die('{"jsonrpc":"2.0","error":"写入文件资源失败!"}');
		
				fclose($in);
				fclose($out);
			} else
				die('{"jsonrpc":"2.0","error":"输出文件资源失败!"}');
		}
		
		$filePath = str_replace('\\','/',$filePath);
		if ($chunks==0 || $chunk == $chunks - 1){ //文件结束
			//改写文件名
			$pathinfo = pathinfo($filePath);
			$fpath = $pathinfo['dirname'];
			$fname = str_replace('.'.$pathinfo['extension'],'',$pathinfo['basename']);
			$ext = strtolower($pathinfo['extension']);
			$newname = 'up'.microtime();
			$newname = str_replace('.','',$newname);
			$newname = str_replace(' ','',$newname);
			$newname = $newname.'.'.$ext;
			$newpath = $fpath.'/'.$newname;
			if(file_exists($newpath)){
				$newname = 'up'.microtime().mt_rand(1000,9999);
				$newname = str_replace('.','',$newname);
				$newname = str_replace(' ','',$newname);
				$newname = $newname.'.'.$ext;
				$newpath = $fpath.'/'.$newname;
			}
			rename($filePath.".part",$newpath);
			if(!empty($_GET['picid']) && ($ext=='gif' || $ext=='jpg' || $ext=='png')){
				$m = $this->M('FileUpload');
				$piconf = $m->getpicinfo($_GET['picid']);
				//颜色代码配置
				$colorarr = include(dirname(dirname(__FILE__)).'/configs/cutimgbg.php');
				$posarr = array(0=>'center',1=>'top',2=>'topleft',3=>'topright',4=>'bottom',5=>'bottomleft',6=>'bottomright',7=>'left',8=>'right');
				//图片
				$picpath = str_replace(WEB_ROOT,"",$newpath);
				if($piconf['ywidth']>0 && $piconf['yheight']>0){
					images_bg_tune($picpath,$picpath,$piconf['ywidth'],$piconf['yheight'],$posarr[$piconf['ypos']],$colorarr[$piconf['ycolor']]['hex']);
				}
				//缩略图
				if($piconf['swidth']>0 && $piconf['sheight']>0){
					$nsmallpath = 'thumb/'.$picpath;
					mk_dir(dirname(WEB_ROOT.$nsmallpath),0777);
					images_bg_tune($picpath,$nsmallpath,$piconf['swidth'],$piconf['sheight'],$posarr[$piconf['spos']],$colorarr[$piconf['scolor']]['hex']);
				}
				//水印
				if(!empty($piconf['water_path'])){
					images_water($picpath,$piconf['water_path'],$posarr[$piconf['water_pos']]);
				}
			}
			$m = $this->M('FileUpload');
			$_POST['oldname'] = $oldfileName;
			$_POST['file'] = str_replace(WEB_ROOT,"",$newpath);
			$_POST['size'] = filesize($newpath);
			$_POST['ext'] = $ext;
			$items = $m->get_fields(DB_MX_PRE.'uploads',array('uptime'));
			$m->insert(DB_MX_PRE.'uploads',$items);
			$insertid = $m->get_insert_id();
			echo json_encode(array(
				'jsonrpc'	=>	'2.0',
				'result'	=>	'',
				'id'		=>	$insertid,
				'name'		=>	$_POST['oldname']
			));
		}else{
			die('{"jsonrpc" : "2.0", "result":""}');
		}
	}
	/**
	 * 单个文件上传
	 */
	public function simpleup()
	{
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		
		// Settings
		$targetDir = WEB_ROOT."asset/mxupload";
		$cleanupTargetDir = true; // Remove old files
		$maxFileAge = 5 * 3600; // Temp file age in seconds
		
		// 5 minutes execution time
		@set_time_limit(5 * 60);
		
		// Uncomment this one to fake upload time
		// usleep(5000);
		
		// Get parameters
		$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
		$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
		$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';
		$oldfileName = $fileName;
		// Clean the fileName for security reasons
		$fileName = preg_replace('/[^\w\._]+/', '_', $fileName);
		// Make sure the fileName is unique but only if chunking is disabled
		if ($chunks < 2 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)) {
			$ext = strrpos($fileName, '.');
			$fileName_a = substr($fileName, 0, $ext);
			$fileName_b = substr($fileName, $ext);
		
			$count = 1;
			while (file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName_a . '_' . $count . $fileName_b))
				$count++;
		
			$fileName = $fileName_a . '_' . $count . $fileName_b;
		}
		
		$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
		
		// Create target dir
		if (!file_exists($targetDir))
			mk_dir($targetDir);
		
		// Remove old temp files	
		if ($cleanupTargetDir && is_dir($targetDir) && ($dir = opendir($targetDir))) {
			while (($file = readdir($dir)) !== false) {
				$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;
		
				// Remove temp file if it is older than the max age and is not the current file
				if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge) && ($tmpfilePath != "{$filePath}.part")) {
					@unlink($tmpfilePath);
				}
			}
			closedir($dir);
		} else
			die('{jsonrpc:"2.0",error:"无法创建资源文件夹"}');
			
		
		// Look for the content type header
		if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
			$contentType = $_SERVER["HTTP_CONTENT_TYPE"];
		
		if (isset($_SERVER["CONTENT_TYPE"]))
			$contentType = $_SERVER["CONTENT_TYPE"];
		
		// Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
		if (strpos($contentType, "multipart") !== false) {
			if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
				// Open temp file
				$out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
				if ($out) {
					// Read binary input stream and append it to temp file
					$in = fopen($_FILES['file']['tmp_name'], "rb");
					if ($in) {
						while($buff = fread($in, 4096))
							fwrite($out, $buff);
					} else
						die('{"jsonrpc":"2.0","error":"写入文件资源失败!"}');
					fclose($in);
					fclose($out);
					@unlink($_FILES['file']['tmp_name']);
				} else
					die('{"jsonrpc":"2.0","error":"输出文件资源失败!"}');
			} else
				die('{"jsonrpc":"2.0","error":"上传文件资源失败"}');
		} else {
			// Open temp file
			$out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
			if ($out) {
				// Read binary input stream and append it to temp file
				$in = fopen("php://input", "rb");
		
				if ($in) {
					while ($buff = fread($in, 4096))
						fwrite($out, $buff);
				} else
					die('{"jsonrpc":"2.0","error":"写入文件资源失败!"}');
		
				fclose($in);
				fclose($out);
			} else
				die('{"jsonrpc":"2.0","error":"输出文件资源失败!"}');
		}
		
		$filePath = str_replace('\\','/',$filePath);
		if ($chunks==0 || $chunk == $chunks - 1){ //文件结束
			//改写文件名
			$pathinfo = pathinfo($filePath);
			$fpath = $pathinfo['dirname'];
			$fname = str_replace('.'.$pathinfo['extension'],'',$pathinfo['basename']);
			$ext = strtolower($pathinfo['extension']);
			$newname = 'up'.microtime();
			$newname = str_replace('.','',$newname);
			$newname = str_replace(' ','',$newname);
			$newname = $newname.'.'.$ext;
			$newpath = $fpath.'/'.$newname;
			if(file_exists($newpath)){
				$newname = 'up'.microtime().mt_rand(1000,9999);
				$newname = str_replace('.','',$newname);
				$newname = $newname.'.'.$ext;
				$newpath = $fpath.'/'.$newname;
			}
			rename($filePath.".part",$newpath);
			if(!empty($_GET['picid']) && ($ext=='gif' || $ext=='jpg' || $ext=='png')){
				$m = $this->M('FileUpload');
				$piconf = $m->getpicinfo($_GET['picid']);
				//颜色代码配置
				$colorarr = include(dirname(dirname(__FILE__)).'/configs/cutimgbg.php');
				$posarr = array(0=>'center',1=>'top',2=>'topleft',3=>'topright',4=>'bottom',5=>'bottomleft',6=>'bottomright',7=>'left',8=>'right');
				//图片
				$picpath = str_replace(WEB_ROOT,"",$newpath);
				if($piconf['ywidth']>0 && $piconf['yheight']>0){
					images_bg_tune($picpath,$picpath,$piconf['ywidth'],$piconf['yheight'],$posarr[$piconf['ypos']],$colorarr[$piconf['ycolor']]['hex']);
				}
				//缩略图
				if($piconf['swidth']>0 && $piconf['sheight']>0){
					$nsmallpath = 'thumb/'.$picpath;
					mk_dir(dirname(WEB_ROOT.$nsmallpath),0777);
					images_bg_tune($picpath,$nsmallpath,$piconf['swidth'],$piconf['sheight'],$posarr[$piconf['spos']],$colorarr[$piconf['scolor']]['hex']);
				}
				//水印
				if(!empty($piconf['water_path'])){
					images_water($picpath,$piconf['water_path'],$posarr[$piconf['water_pos']]);
				}
			}
			echo json_encode(array(
				'jsonrpc'	=>	'2.0',
				'result'	=>	'',
				'path'		=>	str_replace(WEB_ROOT,"",$newpath),
				'name'		=>	$oldfileName,
				'size'		=>	filesize($newpath)
			));
		}else{
			die('{"jsonrpc" : "2.0", "result":""}');
		}
	}
}
?>