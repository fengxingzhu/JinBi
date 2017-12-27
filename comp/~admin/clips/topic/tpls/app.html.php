<?php if(!defined('WEB_ROOT')) exit();?><style type="text/css">
.mx-list-advmod {
	background:url(images/advmod.png) no-repeat center left;
}
.mx-list-viewmod {
	background:url(images/search.png) no-repeat center left;
}
</style>
<div style="position:absolute; top:1px; left:1px; right:1px; bottom:1px;">
	<table id="mods-advsgrid">
		<thead>
			<tr>
				<th width="40">排序</th>
				<th width="160">专题名称</th>
				<th width="160">关键字</th>
				<th width="160">风格</th>
				<th width="120">创建时间</th>
				<th width="240">管理</th>
			</tr>
		</thead>
		<tbody>
			<?php if(!isset(Action::$classqueue['Data'])){ require_once(file_exists("do/DataAct.class.php")?"do/DataAct.class.php":"~do/DataAct.class.php"); Action::$mpath=''; Action::$classqueue['Data'] = new DataAct(); } $_from = Action::$classqueue['Data']->getlist(); if (!is_array($_from) && !is_object($_from)){ settype($_from, 'array'); }if (count($_from)){foreach($_from as $key=>Template::$_tplval['list']){ ?>
			<tr>
				<td><?php echo Template::$_tplval['list']['sort']; ?></td>
				<td><?php echo Template::$_tplval['list']['title']; ?></td>
				<td><?php echo Template::$_tplval['list']['keyword']; ?></td>
				<td><?php echo Template::$_tplval['list']['sname']; ?></td>
				<td><?php echo Template::$_tplval['list']['cdate']; ?></td>
				<td>
					<a class="mx-list-icon mx-list-edit" brurl="clips/topic/?frtview/pid/<?php echo Template::$_tplval['list']['id']; ?>.html" href="javascript:;" style="width:65px;">板块管理</a>
					<a class="mx-list-icon mx-list-viewmod" href="../topic/?st_<?php echo Template::$_tplval['list']['id']; ?>/id/<?php echo Template::$_tplval['list']['id']; ?>.html" target="_blank">预览</a>
					<a class="mx-list-icon mx-list-edit" brurl="clips/topic/?edit/id/<?php echo Template::$_tplval['list']['id']; ?>.html" href="javascript:;">修改</a>
					<a class="mx-list-icon mx-list-remove" href="javascript:;" delid="<?php echo Template::$_tplval['list']['id']; ?>" delname="<?php echo Template::$_tplval['list']['title']; ?>" delurl="clips/topic/do/?Data-del" backurl="clips/topic/?app.html">删除</a>
				</td>
			</tr>
			<?php }} unset($_from);?>
		</tbody>
	</table>
</div>
<script type="text/javascript">
$(function(){
	$('#mods-advsgrid').flexigrid({
		title:'<span class="mx-sysmenu"></span>',
		height:'auto',
		showToggleBtn:false,
		resizable:false,
		defcheckbox:true,
		buttons:[
			{
				name:'新增专题',
				bclass:'mx-add',
				onpress:function()
				{
					tabtreecontent('clips/topic/?add.html');
				}
			}
			<?php  if(Template::$_tplval['PWGRADE']==1){  ?>,
			{
				separator: true
			},
			{
				name:'风格管理',
				bclass:'mx-handsort',
				onpress:function()
				{
					tabtreecontent('clips/topic/?stindex.html');
				}
			}
			<?php  }  ?>
		]
	});
});
</script>