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
<div class="sNav sNav_01">
  <?php MFInclude::regincludepage('./','about_left.html'); ?>
</div>

<div class="wal">
<!--wal-->
<div class="fl sideNav">
      <div class="title">关于我们</div>
      <div class="list">
         <?php MFInclude::regincludepage('./','about_left.html'); ?>
      </div>
</div>
<div class="fr w725">
     <div class="pageNow"><a href="<?php echo WEB_APP; ?>app.html">首页</a> > <a href="<?php echo WEB_APP; ?>about.html">关于我们</a> > <span>领导简介</span></div>
     <!--内容-->
     <div class="pageTab">
        <ul>
          <li class="liNow"><a href="<?php echo WEB_APP; ?>Leader.html">主任委员</a></li>
          <li><a href="<?php echo WEB_APP; ?>Leader3.html">副主任委员</a></li>
          <li><a href="<?php echo WEB_APP; ?>Leader2.html">委员</a></li>
          <li><a href="<?php echo WEB_APP; ?>Leader4.html">秘书长</a></li>
        </ul>
        <span class="clear_f"></span>
     </div>
     <div class="leader">
          <div class="imgDiv"><img src="<?php echo WEB_APP; ?>image/nimg266.jpg"/></div>
          <h1>主任委员：张汉桥</h1>
          <h2>中国金币公司董事会董事、公司党委书记、总经理</h2>
          <div class="content">
              为落实国务院关于将安全产业作为国家战略性产业培育发展的部署要求，以及国家工信部、安监总局《关于促进安全产业发展的指导意见》，进一步推进安全产业的发展，2013年，由重庆安全产业发展集团有限公司等6家单位发起，93家单位支持，正式申请筹备成立中国安全产业协会。
          </div>
     </div>
     <!--内容End-->
</div>
<div class="h50"></div>
<!--walEnd-->
</div>

<div class="footNav">
<div class="wal">
    <ul class="fl">
      <li>
          <h1><a href="">关于我们</a></h1>
          <dl>
           <dd><a href="">委员会简介</a></dd>
           <dd><a href="">委员会构架</a></dd>
           <dd><a href="">领导简介</a></dd>
         </dl>
      </li>
      <li>
         <h1><a href="">行业动态</a></h1>
         <dl>
           <dd><a href="">公告通知</a></dd>
           <dd><a href="">工作动态</a></dd>
           <dd><a href="">会员动态</a></dd>
           <dd><a href="">市场动态</a></dd>
         </dl>
      </li>
      <li>
         <h1><a href="">规章制度</a></h1>
         <dl>
           <dd><a href="">入会指南</a></dd>
           <dd><a href="">入会流程</a></dd>
           <dd><a href="">自律公约</a></dd>
           <dd><a href="">议事规程</a></dd>
           <dd><a href="">管理规则</a></dd>
         </dl>
      </li>
      <li>
         <h1><a href="">培训学院</a></h1>
         <dl>
           <dd><a href="">金币知识</a></dd>
           <dd><a href="">项目介绍</a></dd>
           <dd><a href="">金币课堂</a></dd>
           <dd><a href="">市场报告</a></dd>
         </dl>
      </li>
      <li>
         <h1><a href="">用户指南</a></h1>
         <dl>
           <dd><a href="">注册新用户</a></dd>
           <dd><a href="">账号密码</a></dd>
         </dl>
      </li>
      <li>
         <h1><a href="">会员之家</a></h1>
      </li>
    </ul>
    <div class="fr">
        <h1>联系我们</h1>
        <div class="content">
        热线：010-59311247 <br />
        传真：010-59311247-xxx<br />
        邮箱：123456@163.com<br />
        <a href="">相关链接</a>　<a href="">法律声明</a>　<a href="">隐私保护</a>
        </div>
    </div>
</div>
</div>
<div class="footDiv">
CopyRight ©2000-2014 Chngc.net 京ICP证080121号 京ICP备10003406号 京公网安备110102001642
</div>
</body>
</html>
