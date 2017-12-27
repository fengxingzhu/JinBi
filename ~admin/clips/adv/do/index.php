<?php
/**
 * 模板输出入口文件
 */
//设置项目路径
define('POST_FILTER', false);//关js,iframe等代码安全检查
require "../../../../Edw.php";
//判断用户状态
PlugsUserPassAct::islogin('../../../');
//实例化项目
$app = new App();
$app->submit();
?>