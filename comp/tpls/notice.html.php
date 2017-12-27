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
<div class="sNav sNav_02">
  <?php MFInclude::regincludepage('./','notice_left.html'); ?>
</div>

<div class="wal">
<!--wal-->
<div class="fl sideNav">
      <div class="title">行业动态</div>
      <div class="list">
         <?php MFInclude::regincludepage('./','notice_left.html'); ?>
      </div>
</div>
<div class="fr w725">
     <div class="pageNow"><a href="<?php echo WEB_APP; ?>app.html">首页</a> > <a href="<?php echo WEB_APP; ?>notice.html">行业动态</a> > <span>发行公告</span></div>
     <!--内容-->
     <div class="news listHover">
        <ul>
          <?php $_plist = TagAttrLoop::emspagelist('cn_cn_news',' id desc','4','__typeid=231','page','','',''); $_from = $_plist['all']; Template::$_tplval['page'] = $_plist['page']; Template::$_tplval['pagejson'] = json_encode($_plist['page']); if (!is_array($_from) && !is_object($_from)){ settype($_from, 'array'); }if (count($_from)){foreach($_from as $key=>Template::$_tplval['list']){ ?>
          <li>
             <!-- 获取日期 -->
             <?php $pubdate = Template::$_tplval['list']['pubdate'] ?>
             <!-- 分割日期,为数组 -->
             <?php $num=explode(',', $pubdate)?>

             <div class="time"><div><?php echo(substr("$num[2]", 0, 1));?><b><?php echo(substr("$num[2]", 1, 2));?></b></div><?php echo($num[0]);?>.<?php echo($num[1]);?></div>
             <div class="name"><a href="<?php echo WEB_APP; ?>noticeShow.html"><font color="red">【<?php echo Template::$_tplval['list']['wzsx']; ?>】</font><?php echo Template::$_tplval['list']['title']; ?></a></div>
             <div class="content">
                <?php echo Template::$_tplval['list']['content']; ?>
             </div>
          </li>            
          <?php }} unset($_from);?>
        </ul>
     </div>
     <div class="pageNum">
     <a href="" class="prev"><em>上一页</em></a><a href="" class="aNow">1</a><a href="">2</a><a href="">3</a><a href="">4</a><a href="">5</a><a href="" class="next"><em>下一页</em></a>
     <span>共65页　向第</span>
     <input type="text" class="input1" />
     <span>页</span>
     <input type="button" class="btn1" value="跳转" />
     </div>
     <!--内容End-->
</div>
<div class="h50"></div>
<!--walEnd-->
</div>

<?php MFInclude::regincludepage('./','index_foot.html'); ?>
</body>
</html>
