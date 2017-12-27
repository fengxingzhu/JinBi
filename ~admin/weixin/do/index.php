<?php
/**
 * 微信接口数据处理
 */
//设置项目路径
require "../../../Edw.php";
//是否登录
PlugsUserPassAct::islogin('../../');
//实例化项目
$app = new App();
$app->submit();
?>