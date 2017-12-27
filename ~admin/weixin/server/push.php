<?php
/**
 * 微信接口入口文件 推送
 */
define('WEB_ROOT',dirname(dirname(dirname(dirname(str_replace('\\','/',__FILE__))))).'/');//网站根目录
require 'functions.php';//微信公用函数库
require WEB_ROOT.'Edw.php';//调用Edw框架库
if(isset($_POST) && isset($_GET['type'])){
	$pushfile = 'pushs/'.$_GET['type'].'.php';
	if(file_exists($pushfile)){//如果接口文件存在，则执行
		include($pushfile);//包含接口文件
		$class = 'Wx'.ucfirst($_GET['type']);//消息类型类
		$obj = new $class();//初始化
		$obj->deal();//执行消息处理
	}
}
?>