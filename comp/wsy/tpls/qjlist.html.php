<?php if(!defined('WEB_ROOT')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="X-UA-Compatible" content="IE=7">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>微请柬列表</title>

<!--[if lte IE 6]>

<script src="script/png.js" type="text/javascript"></script>

    <script type="text/javascript">

        DD_belatedPNG.fix('div, ul, img, li, input , a, h1');

    </script>

<![endif]-->



</head>



<body>

<!--<div style="margin:30px;">

模版分类展示：<a href="<?php echo WEB_APP; ?>?modlist.html" target="_blank"><?php echo DOMAIN; ?>?modlist.html</a>

</div>-->

<div style="margin:30px 0 0 30px;">

已添加微请柬列表：

</div>

<div>

<table border="1" style="width:800px;margin:10px 30px 30px 30px;">

<?php $_from = TagAttrLoop::emslist('wqj_wqj_list','__handsort DESC,id DESC','__typeid=209','100000','','','','',''); if (!is_array($_from) && !is_object($_from)){ settype($_from, 'array'); }if (count($_from)){foreach($_from as $key=>Template::$_tplval['list']){ ?>

	<tr>

		<td>微试用名称：<?php echo Template::$_tplval['list']['title']; ?></td>

		<td>连接地址：<a href="<?php echo WEB_APP; ?>wsy/?app/tp/<?php echo Template::$_tplval['list']['id']; ?>.html" target="_blank"><?php echo DOMAIN; ?>wsy/?app/tp/<?php echo Template::$_tplval['list']['id']; ?>.html</a></td>
		
		<td><img src="<?php echo WEB_APP; ?>wsy/?inc_ewm/id/<?php echo Template::$_tplval['list']['id']; ?>.html"></img></td>
	</tr>

<?php }} unset($_from);?>

</table>

</div>

</body>

</html>

