<?php if(!defined('WEB_ROOT')) exit();?><?php if(empty(Action::$classqueue["Form"])){ require_once(file_exists("do/FormAct.class.php")?"do/FormAct.class.php":"~do/FormAct.class.php"); Action::$classqueue["Form"] = new FormAct(); }Action::$classqueue["Form"]->getinfo();Action::$classqueue["Form"]->getform();Action::$classqueue["Form"]->fieldplusjs();?>
<?php echo Template::$_tplval['FORMJS']; ?>
<div class="ui-state-default left-tree-top" style="margin-right:0;">
	<span><span class="mx-sysmenu"></span><?php echo Template::$_tplval['REXTITLE']; ?> -- 修改</span>
</div>
<div class="mx-toolbar">
	<a href="javascript:;" class="button" brurl="util/grid/?app/ag/<?php echo Template::$_tplval['CONFINI']['proname']; ?>/tp/<?php echo Template::$_tplval['TP']; ?>.html"><span class="mx-sysmenu-tree"></span></a>
</div>
<div class="mx-formpanel">
	<form class="ajaxform" method="post" action="util/grid/do/?Form-edit/ag/<?php echo Template::$_tplval['CONFINI']['proname']; ?>/tp/<?php echo Template::$_tplval['TP']; ?>/id/<?php echo Template::$_tplval['info']['id']; ?>.html">
	  <fieldset style="width:<?php echo Template::$_tplval['FIELDSETWIDTH']; ?>px;">
	  <textarea name="formDataInfo" class="mx-formdata"><?php echo Template::$_tplval['data']; ?></textarea>
	  <legend>修改<span class="mx-sysmenu-tree"></span></legend>
	  <?php echo Template::$_tplval['FIELDNODISPLAY']; ?>
	  <table border="0">
        <tr>
        <?php echo Template::$_tplval['FIELDPANEL']; ?>
		</tr>
		<?php  if(Template::$_tplval['CONFINI']['cfg_top_key']==1 || Template::$_tplval['CONFINI']['cfg_pub_key']==1){  ?>
		<tr>
          <td width="<?php echo Template::$_tplval['FIELDSETWIDTH']; ?>" colspan="<?php echo Template::$_tplval['FIELDCOLSPAN']; ?>">
		  <label>发布信息</label>
		  <?php  if(Template::$_tplval['CONFINI']['cfg_top_key']==1){  ?>
		  <div style="width:50%; float:left;">
		  	置顶： 是<input name="__systop" type="radio" value="1" style="height:12px; line-height:12px;" <?php  if(Template::$_tplval['info']['__systop']==1) echo 'checked="checked"';  ?> />　　否<input name="__systop" type="radio" value="0" style="height:12px; line-height:12px;" <?php  if(Template::$_tplval['info']['__systop']==0) echo 'checked="checked"';  ?> />
		  </div>
		  <?php  }  ?>
		  <?php  if(Template::$_tplval['CONFINI']['cfg_pub_key']==1){  ?>
		  <div style="width:50%; float:left;">
		  	是否发布： 是<input name="__syspub" type="radio" value="1" style="height:12px; line-height:12px;" <?php  if(Template::$_tplval['info']['__syspub']==1) echo 'checked="checked"';  ?> />　　否<input name="__syspub" type="radio" value="0" style="height:12px; line-height:12px;" <?php  if(Template::$_tplval['info']['__syspub']==0) echo 'checked="checked"';  ?> />
		  </div>
		  <?php  }  ?>
		  </td>
        </tr>
		<?php  }else{  ?>
		<tr style="display:none;">
			<td width="<?php echo Template::$_tplval['FIELDSETWIDTH']; ?>" colspan="<?php echo Template::$_tplval['FIELDCOLSPAN']; ?>">
				<input name="__systop" type="radio" value="0" checked="checked" />
				<input name="__syspub" type="radio" value="1" checked="checked" />
			</td>
		</tr>
		<?php  }  ?>
		<tr>
          <td width="<?php echo Template::$_tplval['FIELDSETWIDTH']; ?>" class="mx-form-submit" colspan="<?php echo Template::$_tplval['FIELDCOLSPAN']; ?>">
		    <input type="submit" name="submitButton" value="提　交" />
		  </td>
        </tr>
      </table>
	  </fieldset>
	</form>
</div>