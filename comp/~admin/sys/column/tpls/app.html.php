<?php if(!defined('WEB_ROOT')) exit();?><?php if(empty(Action::$classqueue["Menu"])){ require_once(file_exists("do/MenuAct.class.php")?"do/MenuAct.class.php":"~do/MenuAct.class.php"); Action::$classqueue["Menu"] = new MenuAct(); }Action::$classqueue["Menu"]->getlist();Action::$classqueue["Menu"]->readpmenu();?>
<style type="text/css">
.mx-downmenu { display:block; width:65px; float:left; background:url(images/edit.gif) no-repeat center left; text-indent:16px; margin:0 5px; }
.mx-toolbar .mx-toolbarright { float:left; }
</style>
<table id="Menu-grid">
  <thead>
	<tr>
		<th width="20"><input type="checkbox" name="allselect" class="gridcheck"/></th>
		<th width="26">ID</th>
		<th width="80">序号</th>
		<th width="300">标题</th>
		<th width="80">栏目类型</th>
		<th width="80">子栏目数</th>
		<th width="260">操作</th>
	</tr>
</thead>
   <tbody>
		<?php $_from = Template::$_tplval['data']; if (!is_array($_from) && !is_object($_from)){ settype($_from, 'array'); }if (count($_from)){foreach($_from as $key=>Template::$_tplval['list']){ ?>
		<tr>
			<td><input type="checkbox" name="checks" value="<?php echo Template::$_tplval['list']['id']; ?>" class="gridcheck" /></td>
			<td><?php echo Template::$_tplval['list']['id']; ?></td>
			<td><input type="text" name="handsort" mid="<?php echo Template::$_tplval['list']['id']; ?>" value="<?php echo Template::$_tplval['list']['sort']; ?>" style="width:60px;" class="gridcheck" /></td>
			<td><?php echo Template::$_tplval['list']['title']; ?></td>
			<td><span class="mx-mapping" key="menu_typedata"><?php echo Template::$_tplval['list']['typeid']; ?></span></td>
			<td><a href="javascript:;" brurl="sys/column/?app/pid/<?php echo Template::$_tplval['list']['id']; ?>.html"><?php echo Template::$_tplval['list']['sonum']; ?></a></td>
			<td><a href="javascript:;" brurl="sys/column/?app/pid/<?php echo Template::$_tplval['list']['id']; ?>.html" class="mx-downmenu">下级栏目</a><a href="javascript:;" brurl="sys/column/?add/pid/<?php echo Template::$_tplval['list']['id']; ?>.html" class="mx-list-add">新增</a><a href="javascript:;" brurl="sys/column/?edit/pid/<?php echo Template::$_tplval['list']['parent_id']; ?>/id/<?php echo Template::$_tplval['list']['id']; ?>.html" class="mx-list-edit">修改</a><a href="javascript:;" class="mx-list-remove" delid="<?php echo Template::$_tplval['list']['id']; ?>" delname="<?php echo Template::$_tplval['list']['title']; ?>" delurl="sys/column/do/?Menu-del" backurl="sys/column/?app/pid/<?php echo Template::$_tplval['list']['parent_id']; ?>.html">删除</a></td>
		</tr>
		<?php }} unset($_from);?>
</tbody>
</table>
<script type="text/javascript">
$(function(){
	$('#Menu-grid').flexigrid({
		title:'<span class="mx-sysmenu"></span>：<?php echo Template::$_tplval['TITLE_GUID']; ?>',
		height:'auto',
		showToggleBtn:false,
		resizable:false,
		defcheckbox:true,
		buttons : [
			{
				name:'新增',
				bclass:'mx-add',
				onpress:function(){
					var url = "sys/column/?add/pid/<?php echo Template::$_tplval['PARENT_ID']; ?>/sort/<?php echo Template::$_tplval['SORTVAL']; ?>.html";
					tabtreecontent(url);
					$.mx.setparam('url',url);
				}
			},
			{
				separator: true
			},
			{
				name: '删除',
				bclass: 'mx-delete',
				onpress : moredelete({
					tb:'#Menu-grid',
					post:{},
					url:"sys/column/do/?Menu-delmore",
					flurl:"sys/column/?app/pid/<?php echo Template::$_tplval['PARENT_ID']; ?>.html"
				})
			},
			{
				separator: true
			},
			{
				name: '手动排序',
				bclass: 'mx-handsort',
				onpress : handsort({
					tb:'#Menu-grid',
					post:{
						dbname:'<?php echo DB_MX_PRE; ?>menu',
						sortfd:'sort'
					},
					url:"do/?Common-handsort",
					flurl:"sys/column/?app/pid/<?php echo Template::$_tplval['PARENT_ID']; ?>.html"
				})
			}
		]
	});
});
addmapping('menu_typedata',['系统栏目','网站导航','网站管理']);
</script>