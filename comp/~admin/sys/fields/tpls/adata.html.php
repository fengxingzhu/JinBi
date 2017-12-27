<?php if(!defined('WEB_ROOT')) exit();?><?php if(empty(Action::$classqueue["Fields"])){ require_once(file_exists("do/FieldsAct.class.php")?"do/FieldsAct.class.php":"~do/FieldsAct.class.php"); Action::$classqueue["Fields"] = new FieldsAct(); }Action::$classqueue["Fields"]->getlivs();Action::$classqueue["Fields"]->getfdinfo();Action::$classqueue["Fields"]->getotrlivs();?>
<div class="ui-state-default left-tree-top" style="margin-right:0;">
	<span>应用组件 > 应用实例 > <?php echo Template::$_tplval['info']['livname']; ?> > <?php echo Template::$_tplval['fieldata']['fieldlabel']; ?></span>
</div>
<div class="mx-toolbar">
	<a href="javascript:;" class="button" valurl="fieldparenturl" chvalurl="url">实例列表</a>
	<a href="javascript:;" class="button" brurl="sys/fields/?app/id/<?php echo Template::$_tplval['info']['id']; ?>.html">表单字段</a>
</div>
<table id="Fields-grid">
  <thead>
	<tr>
		<th width="20"><input type="checkbox" name="allselect" /></th>
		<th width="40">排序</th>
		<th width="60">键值</th>
		<th width="120">键名</th>
		<th width="200">关联实例</th>
		<th width="40">默认值</th>
	</tr>
</thead>
   <tbody>
		<?php $_from = Template::$_tplval['fdtydata']; if (!is_array($_from) && !is_object($_from)){ settype($_from, 'array'); }if (count($_from)){foreach($_from as $key=>Template::$_tplval['list']){ ?>
		<tr>
			<td><input type="checkbox" name="checks" value="<?php echo Template::$_tplval['list']['id']; ?>" /></td>
			<td><input type="text" name="handsort" mid="<?php echo Template::$_tplval['list']['id']; ?>" value="<?php echo Template::$_tplval['list']['sort']; ?>" style="width:35px;" /></td>
			<td><input type="text" class="edit-field-tdata" name="keyinfo" mid="<?php echo Template::$_tplval['list']['id']; ?>" value="<?php echo Template::$_tplval['list']['keyinfo']; ?>" style="width:55px;" /></td>
			<td><input type="text" class="edit-field-tdata" name="valinfo" mid="<?php echo Template::$_tplval['list']['id']; ?>" value="<?php echo Template::$_tplval['list']['valinfo']; ?>" style="width:115px;" /></td>
			<td><select name="livid" mid="<?php echo Template::$_tplval['list']['id']; ?>">
				<option value="">请选择关联实例</option>
				<?php $_from = Template::$_tplval['livslist']; if (!is_array($_from) && !is_object($_from)){ settype($_from, 'array'); }if (count($_from)){foreach($_from as $key=>Template::$_tplval['gl']){ ?>
				<?php  if(Template::$_tplval['list']['livid']==Template::$_tplval['gl']['id']){  ?>
					<option value="<?php echo Template::$_tplval['gl']['id']; ?>" selected="selected"><?php echo Template::$_tplval['gl']['livname']; ?></option>
				<?php  }else{  ?>
					<option value="<?php echo Template::$_tplval['gl']['id']; ?>"><?php echo Template::$_tplval['gl']['livname']; ?></option>
				<?php  }  ?>
				<?php }} unset($_from);?>
			</select></td>
			<td><input type="checkbox" name="isdef" mid="<?php echo Template::$_tplval['list']['id']; ?>" <?php  if(Template::$_tplval['list']['isdef']==1){  ?> checked="checked" <?php  }  ?> /></td>
		</tr>
		<?php }} unset($_from);?>
</tbody>
</table>
<!-- 新增数据 -->
<div id="mx-button-fieldwinpanel" itip="新增数据" style="display:none;">
	<form method="post" id="mx-ajaxform-fieldwinpanel">
		<label for="name">排序:</label>
		<input type="text" name="sort" class="text ui-widget-content ui-corner-all" value="<?php echo Template::$_tplval['SORTINFO']; ?>" />
		<label for="name">键值:</label>
		<input type="text" name="keyinfo" class="text ui-widget-content ui-corner-all" />
		<label for="email">键名:</label>
		<input type="text" name="valinfo" class="text ui-widget-content ui-corner-all" />
		<label for="livid">关联实例:</label>
		<div><select name="livid" class="text ui-widget-content ui-corner-all">
			<option value="">请选择关联实例</option>
			<?php $_from = Template::$_tplval['livslist']; if (!is_array($_from) && !is_object($_from)){ settype($_from, 'array'); }if (count($_from)){foreach($_from as $key=>Template::$_tplval['gl']){ ?>
			<option value="<?php echo Template::$_tplval['gl']['id']; ?>"><?php echo Template::$_tplval['gl']['livname']; ?></option>
			<?php }} unset($_from);?>
		</select>
		</div>
	</form>
</div>
<script type="text/javascript">
$(function(){
	$('#Fields-grid').flexigrid({
		title:'<?php echo Template::$_tplval['fieldata']['fieldlabel']; ?> 数据列表',
		height:'auto',
		showToggleBtn:false,
		resizable:false,
		defcheckbox:true,
		buttons : [
			{
				name:'新增',
				bclass:'mx-add',
				onpress:function(){
					fieldwinpanel();
				}
			},
			{
				separator: true
			},
			{
				name: '手动排序',
				bclass: 'mx-handsort',
				onpress : handsort({
					tb:'#Fields-grid',
					post:{
						dbname:'<?php echo DB_MX_PRE; ?>fieldatas',
						sortfd:'sort'
					},
					url:"do/?Common-handsort",
					flurl:"sys/fields/?adata/id/<?php echo Template::$_tplval['info']['id']; ?>/fid/<?php echo Template::$_tplval['fieldata']['id']; ?>.html"
				})
			},
			{
				separator: true
			},
			{
				name: '删除',
				bclass: 'mx-delete',
				onpress : moredelete({
					tb:'#Fields-grid',
					post:{
						dbname:'<?php echo DB_MX_PRE; ?>fieldatas'
					},
					url:"do/?Common-moredelete",
					flurl:"sys/fields/?adata/id/<?php echo Template::$_tplval['info']['id']; ?>/fid/<?php echo Template::$_tplval['fieldata']['id']; ?>.html"
				})
			}
		]
	});
	//blur时保存修改信息
	$('input[class="edit-field-tdata"]').blur(function(){
		var id = $(this).attr("mid"),
			name = $(this).attr("name"),
			val = $(this).val();
		$.post("sys/fields/do/?Fields-dataedit/id/"+id,{name:name,val:val},function(){
			
		});
	});
	//下拉选择实例
	$('#Fields-grid select[name="livid"]').change(function(){
		var id = $(this).attr("mid"),
			name = $(this).attr("name"),
			val = $(':selected',this).val();
		$.post("sys/fields/do/?Fields-dataedit/id/"+id,{name:name,val:val},function(){
			
		});
	});
	//默认值
	$('input[type="checkbox"][name="isdef"]').click(function(){
		var id = $(this).attr("mid"),
			val = $(this).attr("checked")?1:0;
		$.post("sys/fields/do/?Fields-dataedit/id/"+id,{name:'isdef',val:val},function(){
			
		});
	});
});
//填写数据
function fieldwinpanel()
{
	var ofrm = $("#mx-ajaxform-fieldwinpanel");
	ofrm.attr("action","sys/fields/do/?Fields-datadd/fieldid/<?php echo Template::$_tplval['fieldata']['id']; ?>");
	dialog({
		id:'mx-button-fieldwinpanel',
		resizable:false,
		bgiframe:false,
		buttons: {
			'提　交':function() {
				var me = this;
				ofrm.ajaxSubmit({
					success:function(responseText, statusText, xhr, $form){
						$(me).dialog('destroy');
						tabtreecontent("sys/fields/?adata/id/<?php echo Template::$_tplval['info']['id']; ?>/fid/<?php echo Template::$_tplval['fieldata']['id']; ?>.html");
					}
				});
			},
			'关　闭': function() {
				$(this).dialog('destroy');
			}
		}
	});
}
</script>