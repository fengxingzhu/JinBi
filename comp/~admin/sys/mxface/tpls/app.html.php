<?php if(!defined('WEB_ROOT')) exit();?><div class="ui-state-default left-tree-top" style="margin-right:0;">
	<span><span class="mx-sysmenu-tree"></span></span>
</div>
<div class="mx-toolbar">
	<a href="javascript:;" class="button" url="sys/mxface/?app.html"><span class="mx-sysmenu-tree"></span></a>
</div>
<?php if(empty(Action::$classqueue["Mxface"])){ require_once(file_exists("do/MxfaceAct.class.php")?"do/MxfaceAct.class.php":"~do/MxfaceAct.class.php"); Action::$classqueue["Mxface"] = new MxfaceAct(); }Action::$classqueue["Mxface"]->gethfinfo();?>
<div class="mx-formpanel">
	<form class="ajaxform" method="post" action="sys/mxface/do/?Mxface-edit.html">
	  <fieldset style="width:500px;">
	  <legend>后台设置</legend>
	  <table border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="500">
		    <label>head信息</label>
			<textarea name="head" dataType="Require" itip="请填写head信息"><?php echo Template::$_tplval['info']['head']; ?></textarea>
		  </td>
		</tr>
		<tr>
          <td width="500">
		  	<label>foot信息</label>
			<textarea name="foot" dataType="Require" itip="请填写head信息"><?php echo Template::$_tplval['info']['foot']; ?></textarea>
		  </td>
        </tr>
		<tr>
          <td width="500" class="mx-form-submit" colspan="2">
		    <input type="submit" name="submitButton" value="提　交" />
		  </td>
        </tr>
      </table>
	  </fieldset>
	</form>
</div>