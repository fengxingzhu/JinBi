<?php if(!defined('WEB_ROOT')) exit();?><style type="text/css">
.mx-list-advmod {
	background:url(images/advmod.png) no-repeat center left;
}
.mx-list-viewmod {
	background:url(images/search.png) no-repeat center left;
}
.mx-list-getcode {
	background:url(images/code.png) no-repeat center left;
}
</style>
<div style="position:absolute; top:1px; left:1px; right:1px; bottom:1px;">
	<table id="mods-advsgrid">
		<thead>
			<tr>
				<th width="40">ID</th>
				<th width="200">广告位名称</th>
				<th width="100">广告位尺寸</th>
				<th width="240">广告位描述</th>
				<th width="120">广告模型</th>
				<th width="320">管理</th>
			</tr>
		</thead>
		<tbody>
			<?php if(!isset(Action::$classqueue['Data'])){ require_once(file_exists("do/DataAct.class.php")?"do/DataAct.class.php":"~do/DataAct.class.php"); Action::$mpath=''; Action::$classqueue['Data'] = new DataAct(); } $_from = Action::$classqueue['Data']->getlist(); if (!is_array($_from) && !is_object($_from)){ settype($_from, 'array'); }if (count($_from)){foreach($_from as $key=>Template::$_tplval['list']){ ?>
			<tr>
				<td><?php echo Template::$_tplval['list']['id']; ?></td>
				<td><?php echo Template::$_tplval['list']['ptitle']; ?></td>
				<td><?php echo Template::$_tplval['list']['width']; ?>*<?php echo Template::$_tplval['list']['height']; ?></td>
				<td><?php echo Template::$_tplval['list']['summary']; ?></td>
				<td><?php echo Template::$_tplval['list']['atitle']; ?></td>
				<td>
					<a class="mx-list-icon mx-list-edit" brurl="clips/adv/?tcode<?php echo Template::$_tplval['list']['advmid']; ?>/id/<?php echo Template::$_tplval['list']['id']; ?>.html" href="javascript:;" style="width:65px;">编辑广告</a>
					<?php  if(Template::$_tplval['PWGRADE']==1){  ?><a class="mx-list-icon mx-list-getcode" href="javascript:;" style="width:65px;" slotid="<?php echo Template::$_tplval['list']['id']; ?>">获取代码</a><?php  }  ?>
					<a class="mx-list-icon mx-list-viewmod" href="clips/adv/?vtcode/id/<?php echo Template::$_tplval['list']['id']; ?>.html" target="_blank">预览</a>
					<a class="mx-list-icon mx-list-edit" brurl="clips/adv/?edit/id/<?php echo Template::$_tplval['list']['id']; ?>.html" href="javascript:;">修改</a>
					<a class="mx-list-icon mx-list-remove" href="javascript:;" delid="<?php echo Template::$_tplval['list']['id']; ?>" delname="<?php echo Template::$_tplval['list']['ptitle']; ?>" delurl="clips/adv/do/?Data-del" backurl="clips/adv/?app.html">删除</a>
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
				name:'新增广告位',
				bclass:'mx-add',
				onpress:function()
				{
					tabtreecontent('clips/adv/?add.html');
				}
			}
			<?php  if(Template::$_tplval['PWGRADE']==1){  ?>,
			{
				separator: true
			},
			{
				name:'广告模型',
				bclass:'mx-list-advmod',
				onpress:function()
				{
					tabtreecontent('clips/adv/?advs.html');
				}
			}
			<?php  }  ?>
		]
	});
	//获取代码
	$('#mods-advsgrid a.mx-list-getcode').click(function(){
		dialog({
			title:'获取代码',
			width:650,
			height:260,
			content:'<div id="clips-adv-getcodediv"></div>',
			resizable:false,
			bgiframe:false,
			buttons:{
				'关闭': function() {
					$(this).dialog('destroy');
				}
			}
		});
		var soltid = $(this).attr('slotid');
		$.get('clips/adv/tpls/getcode.html?'+Math.random(),function(text){
			text = text.replace('{SLOT_ID}',soltid);
			$('#clips-adv-getcodediv').html(text);
			$('input[value="复制代码"]').click(function(){
				var copyid = $(this).attr('copyid'),
					cnt = $('#'+copyid).val();
				if(window.clipboardData){
					window.clipboardData.setData("Text",cnt);
					Tip({title:'提示:',content:'复制成功!'});
				}else{
					Tip({title:'提示:',content:'复制失败,请手动复制!'});
				}
			});
		});
	});
});
</script>