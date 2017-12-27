<?php if(!defined('WEB_ROOT')) exit();?><?php include "inc/phpqrcode.php";?>
<?php 

//获取 上一级的url
//$value=$_SERVER['HTTP_REFERER'];

$value = "http://www.qq.com";

$errorCorrectionLevel = "L";

$matrixPointSize = "4";

QRcode::png($value, false, $errorCorrectionLevel, $matrixPointSize);


 ?>