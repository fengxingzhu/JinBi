<?php if(!defined('WEB_ROOT')) exit();?><?php if(empty(Action::$classqueue["LivConfig"])){ require_once(file_exists("do/LivConfigAct.class.php")?"do/LivConfigAct.class.php":"~do/LivConfigAct.class.php"); Action::$classqueue["LivConfig"] = new LivConfigAct(); }Action::$classqueue["LivConfig"]->getlivs();?>
<div class="ui-state-default left-tree-top" style="margin-right:0;">
	<span><span class="mx-sysmenu"></span> > <?php echo Template::$_tplval['info']['appname']; ?> > 配置</span>
</div>
<div class="mx-toolbar">
	<a href="javascript:;" class="button" brurl="sys/livs/?app.html">组件实例</a>
</div>
<div class="mx-formpanel">
	<form class="ajaxform" method="post" action="sys/livs/do/?LivConfig-save/id/<?php echo Template::$_tplval['info']['id']; ?>.html">
	  <fieldset style="width:300px;">
	  <textarea name="formDataInfo" class="mx-formdata"><?php echo Template::$_tplval['data']; ?></textarea>
	  <legend>配置</legend>
	  <table border="0" cellspacing="0" cellpadding="0">
		<tr>
          <td width="300">
		    <label text="新增">新增</label>
			<div class="datalist" name="cfg_add" col="2">
				<span><input class="groupdata" name="cfg_add" type="radio" value="开启" keyid="1" checked="checked" /><em>开启</em></span>
				<span><input class="groupdata" name="cfg_add" type="radio" value="关闭" keyid="0" /><em>关闭</em></span>
			</div>
			<input name="cfg_add_key" type="hidden" value="<?php echo Template::$_tplval['info']['cfg_add_key']; ?>" />
		  </td>
        </tr>
		<tr>
          <td width="300">
		    <label text="修改">修改</label>
			<div class="datalist" name="cfg_edit" col="2">
				<span><input class="groupdata" name="cfg_edit" type="radio" value="开启" keyid="1" checked="checked" /><em>开启</em></span>
				<span><input class="groupdata" name="cfg_edit" type="radio" value="关闭" keyid="0" /><em>关闭</em></span>
			</div>
			<input name="cfg_edit_key" type="hidden" value="<?php echo Template::$_tplval['info']['cfg_edit_key']; ?>" />
		  </td>
        </tr>
		<tr>
          <td width="300">
		    <label text="删除">删除</label>
			<div class="datalist" name="cfg_del" col="2">
				<span><input class="groupdata" name="cfg_del" type="radio" value="开启" keyid="1" checked="checked" /><em>开启</em></span>
				<span><input class="groupdata" name="cfg_del" type="radio" value="关闭" keyid="0" /><em>关闭</em></span>
			</div>
			<input name="cfg_del_key" type="hidden" value="<?php echo Template::$_tplval['info']['cfg_del_key']; ?>" />
		  </td>
        </tr>
		<tr>
          <td width="300">
		    <label text="翻页">翻页</label>
			<div class="datalist" name="cfg_page" col="2">
				<span><input class="groupdata" name="cfg_page" type="radio" value="开启" keyid="1" checked="checked" /><em>开启</em></span>
				<span><input class="groupdata" name="cfg_page" type="radio" value="关闭" keyid="0" /><em>关闭</em></span>
			</div>
			<input name="cfg_page_key" type="hidden" value="<?php echo Template::$_tplval['info']['cfg_page_key']; ?>" />
		  </td>
        </tr>
		<tr>
          <td width="300">
		    <label text="手动排序">手动排序</label>
			<div class="datalist" name="cfg_handsort" col="2">
				<span><input class="groupdata" name="cfg_handsort" type="radio" value="开启" keyid="1" checked="checked" /><em>开启</em></span>
				<span><input class="groupdata" name="cfg_handsort" type="radio" value="关闭" keyid="0" /><em>关闭</em></span>
			</div>
			<input name="cfg_handsort_key" type="hidden" value="<?php echo Template::$_tplval['info']['cfg_handsort_key']; ?>" />
		  </td>
        </tr>
		<tr>
          <td width="300">
		    <label text="预览">预览</label>
			<div class="datalist" name="cfg_brower" col="2">
				<span><input class="groupdata" name="cfg_brower" type="radio" value="开启" keyid="1" checked="checked" /><em>开启</em></span>
				<span><input class="groupdata" name="cfg_brower" type="radio" value="关闭" keyid="0" /><em>关闭</em></span>
			</div>
			<input name="cfg_brower_key" type="hidden" value="<?php echo Template::$_tplval['info']['cfg_brower_key']; ?>" />
		  </td>
        </tr>
		<tr>
          <td width="300">
		    <label text="置顶">置顶</label>
			<div class="datalist" name="cfg_top" col="2">
				<span><input class="groupdata" name="cfg_top" type="radio" value="开启" keyid="1" checked="checked" /><em>开启</em></span>
				<span><input class="groupdata" name="cfg_top" type="radio" value="关闭" keyid="0" /><em>关闭</em></span>
			</div>
			<input name="cfg_top_key" type="hidden" value="<?php echo Template::$_tplval['info']['cfg_top_key']; ?>" />
		  </td>
        </tr>
		<tr>
          <td width="300">
		    <label text="发布">发布</label>
			<div class="datalist" name="cfg_pub" col="2">
				<span><input class="groupdata" name="cfg_pub" type="radio" value="开启" keyid="1" checked="checked" /><em>开启</em></span>
				<span><input class="groupdata" name="cfg_pub" type="radio" value="关闭" keyid="0" /><em>关闭</em></span>
			</div>
			<input name="cfg_pub_key" type="hidden" value="<?php echo Template::$_tplval['info']['cfg_pub_key']; ?>" />
		  </td>
        </tr>
		<tr>
          <td width="300">
		    <label text="Excel导入">Excel导入</label>
			<div class="datalist" name="cfg_excelin" col="2">
				<span><input class="groupdata" name="cfg_excelin" type="radio" value="开启" keyid="1" checked="checked" /><em>开启</em></span>
				<span><input class="groupdata" name="cfg_excelin" type="radio" value="关闭" keyid="0" /><em>关闭</em></span>
			</div>
			<input name="cfg_excelin_key" type="hidden" value="<?php echo Template::$_tplval['info']['cfg_excelin_key']; ?>" />
		  </td>
        </tr>
		<tr>
          <td width="300">
		    <label text="Excel导出">Excel导出</label>
			<div class="datalist" name="cfg_excelout" col="2">
				<span><input class="groupdata" name="cfg_excelout" type="radio" value="开启" keyid="1" checked="checked" /><em>开启</em></span>
				<span><input class="groupdata" name="cfg_excelout" type="radio" value="关闭" keyid="0" /><em>关闭</em></span>
			</div>
			<input name="cfg_excelout_key" type="hidden" value="<?php echo Template::$_tplval['info']['cfg_excelout_key']; ?>" />
		  </td>
        </tr>
		<tr>
          <td width="500" class="mx-form-submit">
		    <input type="submit" name="submitButton" value="提　交" />
		  </td>
        </tr>
      </table>
	  </fieldset>
	</form>
</div>
<script type="text/javascript">
$('.mx-formpanel input[name="cfg_add"]').each(function(i,o){
	if($(o).attr('keyid')=='<?php echo Template::$_tplval['info']['cfg_add_key']; ?>') $(o).attr('checked',true);
});
$('.mx-formpanel input[name="cfg_edit"]').each(function(i,o){
	if($(o).attr('keyid')=='<?php echo Template::$_tplval['info']['cfg_edit_key']; ?>') $(o).attr('checked',true);
});
$('.mx-formpanel input[name="cfg_del"]').each(function(i,o){
	if($(o).attr('keyid')=='<?php echo Template::$_tplval['info']['cfg_del_key']; ?>') $(o).attr('checked',true);
});
$('.mx-formpanel input[name="cfg_page"]').each(function(i,o){
	if($(o).attr('keyid')=='<?php echo Template::$_tplval['info']['cfg_page_key']; ?>') $(o).attr('checked',true);
});
$('.mx-formpanel input[name="cfg_handsort"]').each(function(i,o){
	if($(o).attr('keyid')=='<?php echo Template::$_tplval['info']['cfg_handsort_key']; ?>') $(o).attr('checked',true);
});
$('.mx-formpanel input[name="cfg_brower"]').each(function(i,o){
	if($(o).attr('keyid')=='<?php echo Template::$_tplval['info']['cfg_brower_key']; ?>') $(o).attr('checked',true);
});
$('.mx-formpanel input[name="cfg_top"]').each(function(i,o){
	if($(o).attr('keyid')=='<?php echo Template::$_tplval['info']['cfg_top_key']; ?>') $(o).attr('checked',true);
});
$('.mx-formpanel input[name="cfg_pub"]').each(function(i,o){
	if($(o).attr('keyid')=='<?php echo Template::$_tplval['info']['cfg_pub_key']; ?>') $(o).attr('checked',true);
});
$('.mx-formpanel input[name="cfg_excelin"]').each(function(i,o){
	if($(o).attr('keyid')=='<?php echo Template::$_tplval['info']['cfg_excelin_key']; ?>') $(o).attr('checked',true);
});
$('.mx-formpanel input[name="cfg_excelout"]').each(function(i,o){
	if($(o).attr('keyid')=='<?php echo Template::$_tplval['info']['cfg_excelout_key']; ?>') $(o).attr('checked',true);
});
</script>