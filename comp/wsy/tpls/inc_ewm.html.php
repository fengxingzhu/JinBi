<?php if(!defined('WEB_ROOT')) exit();?><?php include("../inc/phpqrcode.php");?>
<?php 

//获取 上一级的url

$value = DOMAIN."wsy/?app/tp/".$_GET['id'].".html";

$errorCorrectionLevel = "L";

$matrixPointSize = "4";

QRcode::png($value, false, $errorCorrectionLevel, $matrixPointSize);


 ?>