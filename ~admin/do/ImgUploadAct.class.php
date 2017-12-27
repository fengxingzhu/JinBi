<?php
/**
 * 图片或者FLASH文件
 */
require_once WEB_ROOT.SYS_LIBS.'/tools/Upload.class.php';
class ImgUploadAct
{
	public function up()
	{
		//判断用户状态
		PlugsUserPassAct::islogin('../');
		$error = "";
		$res = array();
		$ptname = $_POST['name'];
		if(!empty($_FILES[$ptname]['error']))
		{
			switch($_FILES[$ptname]['error'])
			{
				case '1':
					$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
					break;
				case '2':
					$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
					break;
				case '3':
					$error = 'The uploaded file was only partially uploaded';
					break;
				case '4':
					$error = 'No file was uploaded.';
					break;
				case '6':
					$error = 'Missing a temporary folder';
					break;
				case '7':
					$error = 'Failed to write file to disk';
					break;
				case '8':
					$error = 'File upload stopped by extension';
					break;
				case '999':
				default:
					$error = 'No error code avaiable';
			}
		}elseif(empty($_FILES[$ptname]['tmp_name']) || $_FILES[$ptname]['tmp_name'] == 'none'){
			$error = 'No file was uploaded..';
		}else{
			$up = new Upload($ptname);
			$res = $up->save('imguplds');
			if($_POST['cw']>0 && $_POST['ch']>0)
				images_bg_tune($res['name'],$res['name'],$_POST['cw'],$_POST['ch']);
			//for security reason, we force to remove all uploaded file
			@unlink($_FILES[$ptname]);
		}
		echo "{";
		echo		"error: '" . $error . "',\n";
		echo		"oldname: '" . $res['oldname'] . "',\n";
		echo		"npath: '" . $res['name'] . "'\n";
		echo "}";
	}
}
?>