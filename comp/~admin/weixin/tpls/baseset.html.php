<?php if(!defined('WEB_ROOT')) exit();?><div class="ui-state-default left-tree-top" style="margin-right:0;">
	<span><span class="mx-sysmenu"></span></span>
</div>
<?php if(empty(Action::$classqueue["Baseset"])){ require_once(file_exists("do/BasesetAct.class.php")?"do/BasesetAct.class.php":"~do/BasesetAct.class.php"); Action::$classqueue["Baseset"] = new BasesetAct(); }Action::$classqueue["Baseset"]->getconfigs();?>
<div class="mx-formpanel">
	<form class="ajaxform" method="post" action="weixin/do/?Baseset-configs.html">
	  <fieldset style="width:500px;">
	  <legend><span class="mx-sysmenu-tree"></span></legend>
	  <table border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="500">
		    <label>Token</label>
			<input type="text" name="token" dataType="Require" itip="请填写微信Token值" value="<?php echo Template::$_tplval['info']['token']; ?>" />
		  </td>
        </tr>
		<tr>
          <td width="500">
		    <label>用户关注时回复信息</label>
			<textarea name="subscribe" datatype="Require" itip="请填写用户关注时回复信息"><?php echo Template::$_tplval['info']['subscribe']; ?></textarea>
		  </td>
        </tr>
		<tr>
          <td width="500">
		    <label>appID</label>
			<input type="text" name="appid" dataType="Require" itip="请填写appID" value="<?php echo Template::$_tplval['info']['appid']; ?>" />
		  </td>
        </tr>
		<tr>
          <td width="500">
		    <label>appsecret</label>
			<input type="text" name="appsecret" dataType="Require" itip="请填写appsecret" value="<?php echo Template::$_tplval['info']['appsecret']; ?>" />
		  </td>
        </tr>
		<tr>
          <td width="500" class="mx-form-submit">
		    <input type="submit" name="submitButton" value="保存设置" />		  
		  </td>
        </tr>
      </table>
	  </fieldset>
	</form>
</div>