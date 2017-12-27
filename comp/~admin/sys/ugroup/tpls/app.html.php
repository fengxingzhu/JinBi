<?php if(!defined('WEB_ROOT')) exit();?><script type="text/javascript">
$(function(){
	$('#Ugroup-grid').flexigrid({
		title:'<span class="mx-sysmenu"></span>',
		height:'auto',
		showToggleBtn:false,
		resizable:false,
		buttons : [
			{
				name:'新增',
				bclass:'mx-add',
				onpress:function(){
					var url = "sys/ugroup/?add.html";
					tabtreecontent(url);
					$.mx.setparam('url',url);
				}
			}
		]
	});
});
</script>
<?php if(empty(Action::$classqueue["Ugroup"])){ require_once(file_exists("do/UgroupAct.class.php")?"do/UgroupAct.class.php":"~do/UgroupAct.class.php"); Action::$classqueue["Ugroup"] = new UgroupAct(); }Action::$classqueue["Ugroup"]->getglist();?>
<table id="Ugroup-grid">
  <thead>
	<tr>
		<th width="26">ID</th>
		<th width="300">角色名称</th>
		<th width="180">操作</th>
	</tr>
</thead>
   <tbody>
		<?php $_from = Template::$_tplval['data']; if (!is_array($_from) && !is_object($_from)){ settype($_from, 'array'); }if (count($_from)){foreach($_from as $key=>Template::$_tplval['list']){ ?>
		<tr>
			<td><?php echo Template::$_tplval['list']['id']; ?></td>
			<td><?php echo Template::$_tplval['list']['title']; ?></td>
			<td><a href="javascript:;" brurl="sys/ugroup/?edit/id/<?php echo Template::$_tplval['list']['id']; ?>.html" class="mx-list-edit">修改</a><a href="javascript:;" class="mx-list-remove" delid="<?php echo Template::$_tplval['list']['id']; ?>" delname="<?php echo Template::$_tplval['list']['title']; ?>" delurl="sys/ugroup/do/?Ugroup-del" backurl="sys/ugroup/?app.html">删除</a></td>
		</tr>
		<?php }} unset($_from);?>
</tbody>
</table>