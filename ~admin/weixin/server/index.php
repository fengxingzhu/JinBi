<?php
/**
 * 微信接口入口文件
 */
define('WEB_ROOT',dirname(dirname(dirname(dirname(str_replace('\\','/',__FILE__))))).'/');//网站根目录
require 'functions.php';//微信公用函数库
require WEB_ROOT.'Edw.php';//调用Edw框架库

if(isset($_GET["echostr"])){//验证微信的有效性
	if(wx_checksignature()){
		echo $_GET["echostr"];
		exit();
	}
}else{
	if(isset($GLOBALS["HTTP_RAW_POST_DATA"])){
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];//微信提交的数据字符串
		$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);//将字符串解析成对象
		$MsgType = $postObj->MsgType; //消息类型
		$msgfile = 'msgs/'.$MsgType.'.php';
		if(file_exists($msgfile)){//如果接口文件存在，则执行
			include($msgfile);//包含接口文件
			$class = 'Wx'.ucfirst($MsgType);//消息类型类
			$obj = new $class($postObj);//初始化
			$obj->deal();//执行消息处理
		}
	}else{
		exit("");
	}
}
?>