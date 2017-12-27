<?php if(!defined('WEB_ROOT')) exit();?><?php if(empty(Action::$classqueue["Menu"])){ require_once(file_exists("do/MenuAct.class.php")?"do/MenuAct.class.php":"~do/MenuAct.class.php"); Action::$classqueue["Menu"] = new MenuAct(); }Action::$classqueue["Menu"]->readpmenu();Action::$classqueue["Menu"]->getlivs();?>
<div class="ui-state-default left-tree-top" style="margin-right:0;">
	<span>栏目管理 -- 新增栏目</span>
</div>
<div class="mx-toolbar"><img src="images/lists.png" align="absmiddle" border="0" />上级栏目：<?php echo Template::$_tplval['TITLE_GUID']; ?></div>
<div class="mx-formpanel">
	<form class="ajaxform" method="post" action="sys/column/do/?Menu-add.html">
	  <fieldset style="width:400px;">
	  <legend>新增栏目</legend>
	  <table border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="400">
		  	<label>栏目名称</label>
			<input type="text" name="title" dataType="Require" itip="请填写栏目名称" /><input name="parent_id" type="hidden" value="<?php echo Template::$_tplval['PARENT_ID']; ?>" />
		  </td>
        </tr>
        <tr>
          <td width="400">
		  	<label>应用类型</label>
			<select name="typeid" dataType="Require" itip="请填写栏目名称">
				<option value="1">网站导航</option>
			  	<option value="2">网站管理</option>
			</select>
		  </td>
        </tr>
		<?php  if($_GET['pid']>0){  ?>
		<tr>
          <td width="400">
		  	<label>组件实例</label>
			<select name="livsid" onchange="__menucompsel(this)">
				<option value="-1">选择组件实例</option>
				<?php $_from = Template::$_tplval['LIVS']; if (!is_array($_from) && !is_object($_from)){ settype($_from, 'array'); }if (count($_from)){foreach($_from as $key=>Template::$_tplval['list']){ ?>
				<option value="<?php echo Template::$_tplval['list']['id']; ?>">【<?php echo Template::$_tplval['list']['appname']; ?>】<?php echo Template::$_tplval['list']['livname']; ?>(<?php echo Template::$_tplval['list']['proname']; ?>)</option>
				<?php }} unset($_from);?>
				<option value="0">自定义连接</option>
			</select>
		  </td>
        </tr>
		<tr id="sys-menu-livetypeid" style="display:none;">
          <td width="400">
		  	<label>实例分类</label>
			<select name="livtyid">
				<option value="0">当前分类</option>
				<option value="all">所有分类</option>
			</select>
		  </td>
        </tr>
		<tr id="sys-menu-admurl" style="display:none;">
          <td width="400">
		  	<label>自定义连接</label>
			<input name="admurl" type="text" />
		  </td>
        </tr>
		<?php  }  ?>
		<tr>
          <td width="400">
		  	<label>前台动态URL(单页或者文章详细页无域名连接,(tid)栏目ID,(id)文章ID)</label>
			<input name="frturl" type="text" value="" />
		  </td>
        </tr>
		<tr>
          <td width="400">
		  	<label>生成URL (tid)栏目ID,(id)文章ID,(Y)年,(M)月,(D)日)</label>
			<input name="crturl" type="text" value="" />
		  </td>
        </tr>
		<tr>
          <td width="400">
		  	<label>排　　序</label>
			<input name="sort" type="text" value="<?php  echo $_GET['sort'];  ?>" />
		  </td>
        </tr>
		<tr>
          <td width="400" class="mx-form-submit">
		  	<input type="submit" name="submitButton" ajax="menuadd" value="提　交" />
		  </td>
        </tr>
      </table>
	  </fieldset>
	</form>
</div>
<script type="text/javascript">
function __menucompsel(t)
{
	var v = $(t).val(),
		osel = $("#sys-menu-admurl"),
		olitype = $('#sys-menu-livetypeid');
	if(v==0){
		osel.show();
		$('input[name="admurl"]').val("");
		olitype.hide();
	}else{
		if(v==-1)
			$('input[name="admurl"]').val("");
		osel.hide();
		olitype.show();
	}
}
</script>