<?php if(!defined('WEB_ROOT')) exit();?><?php if(empty(Action::$classqueue["EPub"])){ require_once(file_exists("do/EPubAct.class.php")?"do/EPubAct.class.php":"~do/EPubAct.class.php"); Action::$classqueue["EPub"] = new EPubAct(); }Action::$classqueue["EPub"]->upfileinfo();Action::$classqueue["EPub"]->gethfinfo();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="-1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo Template::$_tplval['webinfo']['head']; ?></title>
<link type="text/css" href="css/pub.css" rel="stylesheet" />
<link type="text/css" href="css/tip-yellowsimple/tip-yellowsimple.css" rel="stylesheet" />
<link type="text/css" href="css/jquery.treeview.css" rel="stylesheet" />
<link type="text/css" href="css/jquery.flexigrid.css" rel="stylesheet" />
<link type="text/css" href="plupload/jquery.plupload.queue/css/jquery.plupload.queue.css" rel="stylesheet" />
<link type="text/css" href="themes/gray/jquery-ui.css" rel="stylesheet" />
<script type="text/javascript" src="jui/jquery-1.7.min.js"></script>
<script type="text/javascript" src="do/?JS-get/y/1/path/jui/js/ui.core,jquery.json,ui.tabs,ui.accordion,ui.draggable,ui.resizable,ui.dialog,ui.sortable,effects.core,effects.highlight.html"></script>
<script type="text/javascript" src="do/?JS-get/y/1/path/jplugins/js/jquery.cookie,jquery.poshytip,jquery.treeview,jquery.flexigrid,jquery.form,jquery.ajaxUpload.html"></script>
<script type="text/javascript" src="do/?JS-get/y/0/path/plupload/js/plupload,plupload.flash,plupload.browserplus,pluploadhtml5,pluploadhtml4.html"></script>
<script type="text/javascript" src="plupload/jquery.plupload.queue/jquery.plupload.queue.js"></script>
<script type="text/javascript" src="js/my97/WdatePicker.js"></script>
<script type="text/javascript" src="do/?JS-get/y/1/path/js/js/mx,mx.funs,mx.form.html"></script>
<script type="text/javascript" src="../~editor/eweditor/ewebeditor.js"></script>
<script type="text/javascript" src="../~editor/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../~editor/ckeditor/ckfinder/ckfinder.js"></script>
<script type="text/javascript">
$(function(){
	$.mx.load();
});
var __UPLOADMAXSIZE = '<?php echo Template::$_tplval['maxsizeinfo']; ?>mb';
var __FILTERS = <?php echo Template::$_tplval['filtersjson']; ?>;
</script>
</head>

<body>
<?php if(empty(Action::$classqueue["EPub"])){ require_once(file_exists("do/EPubAct.class.php")?"do/EPubAct.class.php":"~do/EPubAct.class.php"); Action::$classqueue["EPub"] = new EPubAct(); }Action::$classqueue["EPub"]->tabs();Action::$classqueue["EPub"]->getwebsite();?>
<div id="mx-sys-error">
	<div id="mx-sys-error-title"></div>
	<div id="mx-sys-error-content"></div>
</div>
<div class="header">
	<h3><?php echo Template::$_tplval['webinfo']['head']; ?></h3>
	<a href="javascript:;" class="headicon" onclick="logout()"><img src="images/logout.png" border="0" align="absmiddle" />退出</a>
	<a href="javascript:;" class="headicon" onclick="editpassword()"><img src="images/password.png" border="0" align="absmiddle" />修改密码</a>
	<a href="../" class="headicon" target="_blank"><img src="images/home.png" border="0" align="absmiddle" />访问首页</a>
	<a href="javascript:;" class="headicon" style="margin-right:20px;">当前站点：<?php echo Template::$_tplval['WEBSITENAME']; ?></a>
	<!-- 修改密码 -->
	<div id="mx-button-editpassword" title="修改密码" style="display:none;">
		<form method="post" action="do/?EditUser-edpwinfo.html" id="mx-ajaxform-editpassword">
			<label for="oldpassword" style="height:20px; line-height:20px;">原密码:</label>
			<input type="password" name="oldpassword" class="text ui-widget-content ui-corner-all" dataType="Require" itip="请填写原密码" />
			<label for="password" style="height:20px; line-height:20px;">新密码:</label>
			<input type="password" name="password" class="text ui-widget-content ui-corner-all" dataType="Require" itip="请填写新密码" />
			<label for="repassword" style="height:20px; line-height:20px;">重新输入密码:</label>
			<input type="password" name="repassword" class="text ui-widget-content ui-corner-all" dataType="Repeat" to="password" itip="两次输入密码不一致" />
		</form>
	</div>
</div>
<div class="ui-tabs ui-widget ui-widget-content ui-corner-all">
	<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" id="header-tabs-ul">
		<li class="ui-state-default ui-corner-top" url="./?home.html" eq="0" style="display:inline-block;"><a href="javascript:;">首页</a></li>
		<?php $_from = Template::$_tplval['TABS']; if (!is_array($_from) && !is_object($_from)){ settype($_from, 'array'); }if (count($_from)){foreach($_from as $key=>Template::$_tplval['list']){ ?>
		<li class="ui-state-default ui-corner-top" url="./?tabs/pid/<?php echo Template::$_tplval['list']['id']; ?>.html" eq="<?php  echo $key+1;  ?>"><a href="javascript:;"><?php echo Template::$_tplval['list']['title']; ?></a></li>
		<?php }} unset($_from);?>
	</ul>
	<div class="ui-tabs-panel ui-widget-content ui-corner-bottom" id="mx-tabs-content" cutmargin="0,120" style="margin:0; padding:2px;">
	</div>
</div>
<!-- dialog win -->
<div id="mx-dialog-win"></div>
<div class="footer">
<?php echo Template::$_tplval['webinfo']['foot']; ?>
</div>
<div id="mx-uploadwinform" style="overflow:hidden; margin:0; padding:0;">
<form method="post" style="margin:0; padding:0;">
	<div id="uploader" style="width:500px; height: 310px;"></div>
</form>
</div>
</body>
</html>