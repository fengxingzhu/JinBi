<?php
/**
 * 模板输出入口文件
 */
//设置项目路径
define('POST_FILTER',true);//过滤不安全代码
require "../Edw.php";
//实例化项目
$app = new App();
$app->submit();
?>