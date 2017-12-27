<?php if(!defined('WEB_ROOT')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EDGE">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>金币市场专业委员会</title>
<link href="<?php echo WEB_APP; ?>style/main.css" rel="stylesheet" type="text/css" />
<link href="<?php echo WEB_APP; ?>style/index.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?php echo WEB_APP; ?>script/jquery-1.7.1.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo WEB_APP; ?>script/easing.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo WEB_APP; ?>script/js.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo WEB_APP; ?>script/fun.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo WEB_APP; ?>script/form.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo WEB_APP; ?>script/jquery.SuperSlide.2.1.1.js"></script>
<!--[if lte IE 6]>
<script src="script/png.js" type="text/javascript"></script>
    <script type="text/javascript">
        DD_belatedPNG.fix('div, ul, img, li, input , a');
    </script>
<![endif]--> 
</head>

<body>
<div class="headDiv">
<?php MFInclude::regincludepage('./','index_head.html'); ?>
</div>
<div class="sNav sNav_03">
  <?php MFInclude::regincludepage('./','guide_left.html'); ?>
</div>

<div class="wal">
<!--wal-->
<div class="fl sideNav">
      <div class="title">规章制度</div>
      <div class="list">
         <?php MFInclude::regincludepage('./','guide_left.html'); ?>
      </div>
</div>
<div class="fr w725">
     <div class="pageNow"><a href="">首页</a> > <a href="">规章制度</a> > <span>入会流程</span></div>
     <!--内容-->
     <div class="about">
        <div class="imgDiv"><img src="<?php echo WEB_APP; ?>image/nimg667.png"/></div>
     </div>
     <!--内容End-->
</div>
<div class="h50"></div>
<!--walEnd-->
</div>

<?php MFInclude::regincludepage('./','index_foot.html'); ?>
</body>
</html>
