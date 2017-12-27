<?php if(!defined('WEB_ROOT')) exit();?><?php if(empty(Action::$classqueue["Livs"])){ require_once(file_exists("do/LivsAct.class.php")?"do/LivsAct.class.php":"~do/LivsAct.class.php"); Action::$classqueue["Livs"] = new LivsAct(); }Action::$classqueue["Livs"]->getcompents();?>
<div class="ui-state-default left-tree-top" style="margin-right:0;">
	<span><span class="mx-sysmenu"></span> > 创建实例</span>
</div>
<div class="mx-toolbar">
	<a href="javascript:;" class="button" brurl="sys/livs/?app.html"><span class="mx-sysmenu-tree"></span></a>
</div>
<div class="mx-formpanel">
	<form class="ajaxform" method="post" action="sys/livs/do/?Livs-add.html">
	  <fieldset style="width:300px;">
	  <legend>创建实例</legend>
	  <table border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="300">
		    <label>选择类型</label>
			<select name="dir" dataType="Require" itip="请选择类型" onchange="__compentselect(this)">
				<option value="" apiurl="" apiname="">选择类型</option>
				<?php $_from = Template::$_tplval['cmptdata']; if (!is_array($_from) && !is_object($_from)){ settype($_from, 'array'); }if (count($_from)){foreach($_from as $key=>Template::$_tplval['cmpt']){ ?>
					<option value="<?php echo Template::$_tplval['cmpt']['dir']; ?>" apiurl="<?php echo Template::$_tplval['cmpt']['apiurl']; ?>" apiname="<?php echo Template::$_tplval['cmpt']['name']; ?>"><?php echo Template::$_tplval['cmpt']['name']; ?>(<?php echo Template::$_tplval['cmpt']['dir']; ?>)</option>
				<?php }} unset($_from);?>
			</select>
			<input id="sys_livs_apiurl" name="apiurl" type="hidden" value="<?php echo Template::$_tplval['info']['apiurl']; ?>" />
			<input id="sys_livs_appname" name="appname" type="hidden" value="<?php echo Template::$_tplval['info']['appname']; ?>" />
		  </td>
        </tr>
		<tr>
          <td width="300">
		    <label>实例分类</label>
			<select name="gid"  dataType="Require" itip="请选择实例分类">
				<?php if(!isset(Action::$classqueue['Apgs'])){ require_once(file_exists("../apgs/do/ApgsAct.class.php")?"../apgs/do/ApgsAct.class.php":"../apgs/~do/ApgsAct.class.php"); Action::$mpath='../apgs/'; Action::$classqueue['Apgs'] = new ApgsAct(); } $_from = Action::$classqueue['Apgs']->getgroups(); if (!is_array($_from) && !is_object($_from)){ settype($_from, 'array'); }if (count($_from)){foreach($_from as $key=>Template::$_tplval['list']){ ?>
					<option value="<?php echo Template::$_tplval['list']['id']; ?>"><?php echo Template::$_tplval['list']['gname']; ?>(<?php echo Template::$_tplval['list']['gdir']; ?>)</option>
				<?php }} unset($_from);?>
			</select>
		  </td>
        </tr>
		<tr>
          <td width="300">
		    <label>信息审核</label>
			<select name="syngrade">
				<option value="0">不需要审核</option>
				<option value="1">一级审核 </option>
				<option value="2">二级审核 </option>
				<option value="3">三级审核 </option>
				<option value="4">四级审核 </option>
			</select>
		  </td>
        </tr>
        <tr>
          <td width="300">
		    <label>实例中文名称</label>
			<input type="text" name="livname" dataType="Require" itip="请填写实例中文名称" />
		  </td>
        </tr>
		<tr>
          <td width="300">
		    <label>实例名称</label>
			<input type="text" name="proname" dataType="EngNumDl" itip="实例名称只能为英文,数字或者下划线" />
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
<script type="text/javascript">
//组件选择
function __compentselect(t)
{
	var o = $(':selected',t);
	$("#sys_livs_apiurl").val(o.attr("apiurl"));
	$("#sys_livs_appname").val(o.attr("apiname"));
}
</script>