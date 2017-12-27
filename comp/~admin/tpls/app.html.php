<?php if(!defined('WEB_ROOT')) exit();?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>MX5 系统管理</title>
<link rel="stylesheet" type="text/css" href="css/login.css" />
<link rel="stylesheet" type="text/css" href="css/buttons.css" />
<script type="text/javascript" src="jui/jquery-1.7.min.js"></script>
<script type="text/javascript" src="jui/jquery.cookie.js"></script>
<script type="text/javascript" src="jplugins/jquery.form.js"></script>
<script type="text/javascript">
$(function(){
	var remember = $.cookie('rememberme'),
		username = $.cookie('username');
	if(remember==1){
		$('input[name="rememberme"]','.forgetmenot').attr('checked',true);
		$('input[name="username"]','#loginform').val(username);
	}
	$('input[name="username"]','#loginform').focus();
	$('input[name="username"]','#loginform').select();
	$('#loginform').ajaxForm({
		success:function(responseText, statusText, xhr, $form){
			var data = eval('('+responseText+')');
			if(data.type=="error"){
				$("#login_error").html(data.msg);
				$("#login_error").show();
				return;
			}else{
				remember = $('input[name="rememberme"]','.forgetmenot').val();
				if(remember==1){
					$.cookie('rememberme',remember,{expires:30});
					$.cookie('username',$('input[name="username"]','#loginform').val(),{expires:30});
				}
				$("#login_error").hide();
				document.location = data.url;
			}
		}
	});
});
</script>
</head>
<body>
	<div id="login" class="mx-ui">
		<h1><img src="images/login.png" border="0" align="absmiddle" />MX5 系统管理</h1>
		<div id="login_error"></div>
		<form id="loginform" action="do/?PlugsUserPass-login.html" method="post" enctype="multipart/form-data">
			<p>
				<label for="user_login">用户名<br /><input type="text" name="username" class="input" value="" /></label>
			</p>
			<p>
				<label for="user_pass">密码<br /><input type="password" name="password" class="input" value="" /></label>
			</p>
			<p class="forgetmenot"><label for="rememberme"><input name="rememberme" type="checkbox" value="1"  /> 记住我的登录信息</label></p>
			<p class="submit">
				<input type="submit" name="submitButton" class="button button-primary button-large" value="登录" />
			</p>
		</form>
	</div>
</body>
</html>