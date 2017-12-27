<?php if(!defined('WEB_ROOT')) exit();?><div class="ui-state-default left-tree-top" style="margin-right:0;">
	<span><span class="mx-sysmenu"></span> -- 新增分类</span>
</div>
<div class="mx-toolbar">
	<a href="javascript:;" class="button" brurl="sys/apgs/?app.html"><span class="mx-sysmenu-tree"></span></a>
</div>
<div class="mx-formpanel">
	<form class="ajaxform" method="post" action="sys/apgs/do/?Apgs-add.html">
	  <fieldset style="width:300px;">
	  <legend>新增分类</legend>
	  <table border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="300">
		    <label>分类名称</label>
			<input type="text" name="gname" dataType="Require" itip="请填写分类名称" /><input name="typeid" type="hidden" value="1" />
		  </td>
        </tr>
		<tr>
          <td width="300">
		    <label>分类标识(表名前缀)</label>
			<input type="text" name="gdir" dataType="EngNumDl" itip="分类标识只能是英文,数字或者下划线" />
		  </td>
        </tr>
		<tr>
          <td width="300" class="mx-form-submit">
		    <input type="submit" name="submitButton" value="提　交" />		  
		  </td>
        </tr>
      </table>
	  </fieldset>
	</form>
</div>