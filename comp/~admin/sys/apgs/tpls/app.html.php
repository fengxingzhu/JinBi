<?php if(!defined('WEB_ROOT')) exit();?><table id="Apgs-grid">
  <thead>
	<tr>
		<th width="50">分类ID</th>
		<th width="80">创建者</th>
		<th width="100">分类类型</th>
		<th width="200">分类名称</th>
		<th width="120">分类标识(表名前缀)</th>
		<th width="100">操作</th>
	</tr>
</thead>
   <tbody>
		<?php if(!isset(Action::$classqueue['Apgs'])){ require_once(file_exists("do/ApgsAct.class.php")?"do/ApgsAct.class.php":"~do/ApgsAct.class.php"); Action::$mpath=''; Action::$classqueue['Apgs'] = new ApgsAct(); } $_from = Action::$classqueue['Apgs']->getgroups(); if (!is_array($_from) && !is_object($_from)){ settype($_from, 'array'); }if (count($_from)){foreach($_from as $key=>Template::$_tplval['list']){ ?>
		<tr>
			<td><?php echo Template::$_tplval['list']['id']; ?></td>
			<td><?php echo Template::$_tplval['list']['name']; ?></td>
			<td><span class="mx-mapping" key="apgs_typedata"><?php echo Template::$_tplval['list']['typeid']; ?></span></td>
			<td><?php echo Template::$_tplval['list']['gname']; ?></td>
			<td><?php echo Template::$_tplval['list']['gdir']; ?></td>
			<td><a href="javascript:;" brurl="sys/apgs/?edit/id/<?php echo Template::$_tplval['list']['id']; ?>.html" class="mx-list-edit">修改</a><a href="javascript:;" class="mx-list-remove" delid="<?php echo Template::$_tplval['list']['id']; ?>" delname="<?php echo Template::$_tplval['list']['gname']; ?>" delurl="sys/apgs/do/?Apgs-del" backurl="sys/apgs/?app.html">删除</a></td>
		</tr>
		<?php }} unset($_from);?>
</tbody>
</table>
<script type="text/javascript">
$(function(){
	$('#Apgs-grid').flexigrid({
		title:'<span class="mx-sysmenu"></span>',
		height:'auto',
		showToggleBtn:false,
		resizable:false,
		buttons:[
			{
				name:'新增',
				bclass:'mx-add',
				onpress:function(){
					var url = "sys/apgs/?add.html";
					tabtreecontent(url);
					$.mx.setparam('url',url);
				}
			}
		]
	});
});
addmapping('apgs_typedata',['组件','自定义']);
</script>