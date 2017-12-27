<?php if(!defined('WEB_ROOT')) exit();?><?php if(empty(Action::$classqueue["Form"])){ require_once(file_exists("do/FormAct.class.php")?"do/FormAct.class.php":"~do/FormAct.class.php"); Action::$classqueue["Form"] = new FormAct(); }Action::$classqueue["Form"]->getformattr();?>
<?php if(empty(Action::$classqueue["Grid"])){ require_once(file_exists("do/GridAct.class.php")?"do/GridAct.class.php":"~do/GridAct.class.php"); Action::$classqueue["Grid"] = new GridAct(); }Action::$classqueue["Grid"]->getheader();Action::$classqueue["Grid"]->getoutputs();Action::$classqueue["Grid"]->getsynpower();Action::$classqueue["Grid"]->getsearch();Action::$classqueue["Grid"]->issearchfd();?>
<table id="GridBase-grid"></table>
<!-- 导出设置 -->
<div id="mx-Grid-Output" title="导出数据" style="display:none;">
	<form method="post" action="util/grid/do/?Grid-outputdata/tp/<?php echo Template::$_tplval['TP']; ?>.html" id="mx-Grid-OutputForm">
		<label for="outype" style="height:20px; line-height:20px; width:270px;">选择导出数据类型:</label>
		<select name="outype" style="width:270px;">
			<?php $_from = Template::$_tplval['OUTPUTDATA']; if (!is_array($_from) && !is_object($_from)){ settype($_from, 'array'); }if (count($_from)){foreach($_from as $key=>Template::$_tplval['outlist']){ ?>
			<option value="<?php echo Template::$_tplval['outlist']['id']; ?>"><?php echo Template::$_tplval['outlist']['title']; ?></option>
			<?php }} unset($_from);?>
		</select>
		<input name="outids" type="hidden" id="mx-Grid-outids" />
	</form>
</div>
<!-- 下载excel模板 -->
<div id="mx-Grid-Excel-out" title="导入excel数据" style="display:none;">
	<div>
		<h3 style="margin:0;">特别提醒</h3>
		<div>由于excel灵活多变,与数据库的字段无法准确对接,故只能从系统中下载的excel模板录入数据,才能被准确导入.</div>
		<div><a href="javascript:;" style="color:red;" onclick="__down_excel(0);">下载excel数据模板</a></div>
	</div>
	<form method="post" action="util/grid/do/?Grid-excelin/appid/<?php echo Template::$_tplval['CONFINI']['id']; ?>.html" id="mx-Grid-Excel-in">
		<input name="title" type="hidden" id="mx-Grid-Excel-in-title" />
		<input name="__typeid" type="hidden" value="<?php  echo $_GET['tp'];  ?>" id="mx-Grid-Excel-in-typeid" />
		<input name="__db_name" type="hidden" value="<?php echo Template::$_tplval['CONFINI']['dbtname']; ?>" id="mx-Grid-Excel-in-dbname" />
		<div style="width:96%; border-top:1px solid #CCCCCC; margin-top:10px; padding-top:10px;">
			<label>上传excel数据</label>
			<input type="text" name="excel" id="util-excel-upload-val" class="mx-fileupload" readonly="true"/>
			<span id="util-excel-upload-div"><img src="images/simpleupload.png" style="cursor:pointer;" class="mx-formsimpleup-img" id="util-excel-upload" align="absmiddle"/></span>
			<input type="hidden" name="excel_path" id="util-excel-upload-path" />
		</div>
	</form>
	<form method="post" action="util/grid/do/?Grid-excelout/appid/<?php echo Template::$_tplval['CONFINI']['id']; ?>.html" id="mx-Grid-Excel-out-down" style="display:none;">
		<input name="title" type="hidden" id="mx-Grid-Excel-out-title" />
		<input name="type" type="hidden" id="mx-Grid-Excel-out-type" />
		<input name="__typeid" type="hidden" value="<?php  echo $_GET['tp'];  ?>" id="mx-Grid-Excel-out-typeid" />
		<input name="db_name" type="hidden" value="<?php echo Template::$_tplval['CONFINI']['dbtname']; ?>" id="mx-Grid-Excel-out-dbname" />
		<input name="outids" type="hidden" id="mx-Grid-Excel-out-outids" />
	</form>
</div>
<script type="text/javascript">
$(function(){
	//审核权限 
	var __pwgpower = <?php echo Template::$_tplval['PYGPWOER']; ?>;
	//查找当前的选中的菜单结点的ID
	var __mid = $(".filetree a.selected").attr("mid");
	//按钮
	var _button = [];
	<?php  if(Template::$_tplval['CONFINI']['cfg_add_key']==1){  ?>
	_button.push({
		name:'新增',
		bclass:'mx-add',
		onpress:function(){
			var url = 'util/grid/?add/ag/<?php echo Template::$_tplval['CONFINI']['proname']; ?>/__mid/'+__mid+'/tp/<?php echo Template::$_tplval['TP']; ?>.html';
			tabtreecontent(url);
		}
	});
	<?php  }  ?>
	<?php  if(Template::$_tplval['CONFINI']['cfg_del_key']==1){  ?>
	_button.push({
		separator: true
	});
	_button.push({
		name: '删除',
		bclass: 'mx-delete',
		onpress : function(){
			var ids = [];
			$('#GridBase-grid input[type="checkbox"][class="noborder"]').each(function(i,o){
				var _val = $(o).val();
				_val = _val.substr(3,_val.length);
				$(o).attr("checked")?ids.push(_val):"";
			});
			var _ids = ids.join(",");
			if(_ids==""){
				Tip({title:'删除提示:',content:'请选择要删除列表项'});
			}else{
				dialog({
					title:'提示',
					content:'确定删除这些吗?,确定后删除将不能恢复!',
					resizable:false,
					bgiframe:false,
					buttons:{
						'是': function(){
							var me = this;
							$.post('util/grid/do/?Grid-del/ag/<?php echo Template::$_tplval['CONFINI']['proname']; ?>/tp/<?php echo Template::$_tplval['TP']; ?>/',{ids:_ids},function(text){
								Tip({title:'批量删除提示:',content:'批量删除成功!'});
								tabtreecontent('util/grid/?app/ag/<?php echo Template::$_tplval['CONFINI']['proname']; ?>/tp/<?php echo Template::$_tplval['TP']; ?>.html');
								$(me).dialog('destroy');
							});
						},
						'否': function() {
							$(this).dialog('destroy');
						}
					}
				});
			}
		}
	});
	<?php  }  ?>
	<?php  if(Template::$_tplval['CONFINI']['cfg_handsort_key']==1){  ?>
	_button.push({
		separator: true
	});
	_button.push({
		name:'手动排序',
		bclass:'mx-handsort',
		onpress:function(){
			var ores = [];
			$('#GridBase-grid input[name="handsortpt"]').each(function(o,i){
				var _id = $(this).attr('did'),
					_v = $(this).val();
				ores.push(_id+':'+_v);
			});
			var _pval = ores.join(',');
			$.post('util/grid/do/?Grid-handsort/ag/<?php echo Template::$_tplval['CONFINI']['proname']; ?>/tp/<?php echo Template::$_tplval['TP']; ?>/',{pval:_pval},function(){
				Tip({title:'手动排序提示:',content:'手动排序成功!'});
				tabtreecontent('util/grid/?app/ag/<?php echo Template::$_tplval['CONFINI']['proname']; ?>/tp/<?php echo Template::$_tplval['TP']; ?>.html');
			});
		}
	});
	_button.push({
		separator: true
	});
	_button.push({
		name:'自动排序',
		bclass:'mx-autosort',
		onpress:function(){
			$.post('util/grid/do/?Grid-autosort/ag/<?php echo Template::$_tplval['CONFINI']['proname']; ?>/tp/<?php echo Template::$_tplval['TP']; ?>/',{pval:''},function(){
				Tip({title:'自动排序提示:',content:'自动排序成功!'});
				tabtreecontent('util/grid/?app/ag/<?php echo Template::$_tplval['CONFINI']['proname']; ?>/tp/<?php echo Template::$_tplval['TP']; ?>.html');
			});
		}
	});
	<?php  }  ?>
	<?php  if(Template::$_tplval['ISSEARCHFDN']==1){  ?>
	_button.push({
		separator: true
	});
	_button.push({
		name:'搜索',
		bclass:'mx-search',
		onpress:function()
		{
			var url = 'util/grid/?search/ag/<?php echo Template::$_tplval['CONFINI']['proname']; ?>/__mid/'+__mid+'/tp/<?php echo Template::$_tplval['TP']; ?>.html';
			tabtreecontent(url);
		}
	});
	<?php  }  ?>
	<?php  if(Template::$_tplval['USERINFO']['pwgrade']==1){  ?>
	_button.push({
		separator: true
	});
	_button.push({
		name:'导入测试数据',
		bclass:'mx-list-filldata',
		onpress:function()
		{
			$.get("util/grid/do/?Grid-filldatatest/ag/<?php echo Template::$_tplval['CONFINI']['proname']; ?>/tp/<?php echo Template::$_tplval['TP']; ?>/",function(text){
				Tip({title:'导入测试数据提示:',content:text});
				tabtreecontent('util/grid/?app/ag/<?php echo Template::$_tplval['CONFINI']['proname']; ?>/tp/<?php echo Template::$_tplval['TP']; ?>.html');
			});
		}
	});
	<?php  }  ?>
	<?php  if(Template::$_tplval['OUTPUTTAG']==1){  ?>
	_button.push({
		separator: true
	});
	_button.push({
		name:'导出数据',
		bclass:'mx-list-filldata',
		onpress:function()
		{
			var ids = [];
			$('#GridBase-grid input[type="checkbox"][class="noborder"]').each(function(i,o){
				var _val = $(o).val();
				_val = _val.substr(3,_val.length);
				$(o).attr("checked")?ids.push(_val):"";
			});
			var _ids = ids.join(",");
			if(_ids==""){
				Tip({title:'提示:',content:'请选择要导出列表项'});
				return;
			}
			dialog({
				id:'mx-Grid-Output',
				resizable:false,
				bgiframe:false,
				buttons: {
					'导出':function() {
						var me = this;
						$("#mx-Grid-outids").val(_ids);
						$("#mx-Grid-OutputForm").ajaxSubmit({
							iframe:true,
							success:function(responseText, statusText, xhr, $form){
								$("#mx-submitting").hide();
								$(me).dialog('destroy');
								Tip({title:"提示",content:'导出成功!'});
							}
						});	
					},
					'关　闭': function() {
						$(this).dialog('destroy');
					}
				}
			});
		}
	});
	<?php  }  ?>
	if('<?php  if(Template::$_tplval['CONFINI']['syngrade']>0) echo 1;  ?>'==1 && __pwgpower[__mid]){
		_button.push({separator: true});
		_button.push({
			name:'审核通过',
			bclass:'mx-list-syngrade',
			onpress:function()
			{
				var ids = [];
				$('#GridBase-grid input[type="checkbox"][class="noborder"]').each(function(i,o){
					var _val = $(o).val();
					_val = _val.substr(3,_val.length);
					$(o).attr("checked")?ids.push(_val):"";
				});
				var _ids = ids.join(",");
				if(_ids==""){
					Tip({title:'提示:',content:'请选择要通过审核列表项'});
					return;
				}
				$.post("util/grid/do/?Grid-syngrade/ag/<?php echo Template::$_tplval['CONFINI']['proname']; ?>/tp/<?php echo Template::$_tplval['TP']; ?>/",{__mid:__mid,ids:_ids},function(text){
					Tip({title:'审核提示:',content:text});
					tabtreecontent('util/grid/?app/ag/<?php echo Template::$_tplval['CONFINI']['proname']; ?>/tp/<?php echo Template::$_tplval['TP']; ?>.html');
				});
			}
		});
	}
	<?php  if(Template::$_tplval['CONFINI']['cfg_excelin_key']==1){  ?>
	_button.push({
		separator: true
	});
	_button.push({
		name:'导入excel数据',
		bclass:'mx-list-filldata',
		onpress:function()
		{
			//导入excel文件
			__upload_excel();
			dialog({
				id:'mx-Grid-Excel-out',
				resizable:false,
				bgiframe:false,
				buttons: {
					'导入':function() {
						var me = this;
						$('#mx-Grid-Excel-in-title').val($.mx.sysmenu.tree.title);
						$('#mx-Grid-Excel-in-typeid').val('<?php  echo $_GET["tp"];  ?>');
						$('#mx-Grid-Excel-in-dbname').val('<?php echo Template::$_tplval['CONFINI']['dbtname']; ?>');
						$("#mx-Grid-Excel-in").ajaxSubmit({
							iframe:true,
							success:function(responseText, statusText, xhr, $form){
								if(responseText!=""){
									var ores = encode(responseText);
									Tip({title:ores.title?ores.title:"提示",content:ores.msg});
								}else{
									$('#mx-Grid-Excel-out').remove();
									$("#mx-submitting").hide();
									$(me).dialog('destroy');
									Tip({title:"提示",content:'导入excel数据成功!'});
									tabtreecontent('util/grid/?app/ag/<?php echo Template::$_tplval['CONFINI']['proname']; ?>/tp/<?php echo Template::$_tplval['TP']; ?>.html');
								}
							}
						});	
					},
					'关　闭': function() {
						$(this).dialog('destroy');
					}
				}
			});
		}
	});
	<?php  }  ?>
	<?php  if(Template::$_tplval['CONFINI']['cfg_excelout_key']==1){  ?>
	_button.push({
		separator: true
	});
	_button.push({
		name:'导出excel数据',
		bclass:'mx-list-filldata',
		onpress:function()
		{
			var ids = [];
			$('#GridBase-grid input[type="checkbox"][class="noborder"]').each(function(i,o){
				var _val = $(o).val();
				_val = _val.substr(3,_val.length);
				$(o).attr("checked")?ids.push(_val):"";
			});
			var _ids = ids.join(",");
			$('#mx-Grid-Excel-out-outids').val(_ids);
			__down_excel(1);
		}
	});
	<?php  }  ?>
	$('#GridBase-grid').flexigrid({
		title:'<span><span class="mx-sysmenu"></span><?php echo Template::$_tplval['REXTITLE']; ?></span><?php echo Template::$_tplval['searchcondion']; ?>',
		url:'util/grid/do/?Grid-glist/ag/<?php echo Template::$_tplval['CONFINI']['proname']; ?>/__mid/'+__mid+'/tp/<?php echo Template::$_tplval['TP']; ?>/',
		svwurl:'util/grid/do/?Grid-fieldwidth/ag/<?php echo Template::$_tplval['CONFINI']['proname']; ?>/tp/<?php echo Template::$_tplval['TP']; ?>/',
		gridheadersorturl:'util/grid/do/?Grid-headersort/ag/<?php echo Template::$_tplval['CONFINI']['proname']; ?>/tp/<?php echo Template::$_tplval['TP']; ?>/',
		dataType:'json',
		height:'auto',
		colModel:[
			<?php echo Template::$_tplval['FIELD_HEADER']; ?>
		],
		sortname: "<?php echo Template::$_tplval['DEFSORT']['name']; ?>",
		sortorder: "<?php echo Template::$_tplval['DEFSORT']['sort']; ?>",
		usepager:<?php  if(Template::$_tplval['CONFINI']['cfg_page_key']==1){  ?>true<?php  }else{  ?>false<?php  }  ?>,
		rp:<?php echo Template::$_tplval['formattr']['rownum']; ?>,
		<?php  if(Template::$_tplval['CONFINI']['cfg_del_key']==1){  ?>checkbox:true,<?php  }  ?>
		showToggleBtn:false,
		resizable:false,
		onToggleCol:true,
		buttons:_button,
		searchitems:[
			<?php echo Template::$_tplval['SEARCHITEM']; ?>
		],
		onSuccess:function(){
			loadpubfn();
			$(".syninfolist").poshytip({
				className: 'tip-yellowsimple',
				alignTo: 'target',
				alignX: 'center',
				offsetY: 5
			});
			//标识字段处理
			$("a[hotagid]").click(function(){
				var me = this,
					key = $(this).attr("key"),
					val = $(this).attr("val"),
					_id = $(this).attr("hotagid");
				$.post("util/grid/do/?Form-toggleinfo/ag/<?php echo Template::$_tplval['CONFINI']['proname']; ?>/tp/<?php echo Template::$_tplval['TP']; ?>/tagid/"+_id+"/",{key:key,v:val},function(text){
					$(me).text(val==0?"否":"是");
					$(me).attr("val",val==1?0:1);
				});
			});
			//单文件
			$("a[simplepath]").click(function(){
				var paths = $(this).attr("simplepath");
				dialog({
					title:'单文件管理',
					content:'<div style="text-align:center"><img src="'+paths+'" border="0"  /></div>',
					width:550,
					height:400,
					resizable:true,
					bgiframe:false,
					buttons:{
						'关　闭': function() {
							$(this).dialog('destroy');
						}
					}
				});
			});
			//多文件上传
			$("a[fileids]").click(function(){
				var me = this,
					ids = $(me).attr("fileids"),
					fieldnid = $(me).attr("fieldnid"),
					filedname = $(me).attr("filedname");
				dialog({
					title:'文件管理',
					content:'<div id="GridBase-filegrids"></div>',
					width:500,
					height:360,
					resizable:false,
					bgiframe:false,
					buttons:{
						'删　除':function(){
							var idsarr = [];
							$(".grid-base-brfiles a.selected").each(function(i,o){
								idsarr.push($(o).attr("pid"));
							});
							var idstr = idsarr.join(",");
							if(idstr==""){
								Tip({title:"删除提示",content:"请选择要删除的文件!"});
							}else{
								$.post("util/grid/do/?Grid-delappends/ag/<?php echo Template::$_tplval['CONFINI']['proname']; ?>/tp/<?php echo Template::$_tplval['TP']; ?>/",{ids:idstr,filedname:filedname,fieldnid:fieldnid,oldids:ids},function(text){
									basegridappends(ids,fieldnid);
									$("a[filedname='"+filedname+"'][fieldnid='"+fieldnid+"']").text(text);
								});
							}
						},
						'修改':function(){
							var upidarr = [],upoldnamearr = [],upsortarr = [],lid = '';
							$(".grid-base-brfiles a[pid]").each(function(i,o){
								upidarr.push($(o).attr("pid"));
								upoldnamearr.push($("input[name='oldname']",o).val()+$("input[name='oldname_ext']",o).val());
								upsortarr.push($("input[name='sort']",o).val());
								lid = $(o).attr('lid');
							});
							if(upidarr.length>0)
								$.post("util/grid/do/?Grid-sortappends/ag/<?php echo Template::$_tplval['CONFINI']['proname']; ?>/tp/<?php echo Template::$_tplval['TP']; ?>/",{upids:upidarr.join(","),upoldnamearr:upoldnamearr.join("||"),upsortarr:upsortarr.join(","),lid:fieldnid,filedname:filedname},function(text){
									basegridappends(ids,fieldnid);
								});
						},
						'关　闭': function() {
							$(this).dialog('destroy');
						}
					}
				});
				basegridappends(ids,fieldnid);
			});
		}
	});
});
//显示附件信息
function basegridappends(ids,lid)
{
	$("#GridBase-filegrids").load("util/grid/?brfiles/ag/<?php echo Template::$_tplval['CONFINI']['proname']; ?>/tp/<?php echo Template::$_tplval['TP']; ?>/fid/"+ids+"/lid/"+lid+"/",function(){
		$(".grid-base-brfiles a").click(function(){
			$(this).toggleClass("selected");
		});
		$(".grid-base-brfiles a").poshytip({
			className: 'tip-yellowsimple',
			alignTo: 'target',
			alignX: 'center',
			offsetY: 5
		});
	});
}
//清除搜索缓存
function basegridclearsearch()
{
	$.get("util/grid/do/?Form-clearsearch/ag/<?php echo Template::$_tplval['CONFINI']['proname']; ?>/tp/<?php echo Template::$_tplval['TP']; ?>.html",function(text){//关闭搜索
		tabtreecontent('util/grid/?app/ag/<?php echo Template::$_tplval['CONFINI']['proname']; ?>/tp/<?php echo Template::$_tplval['TP']; ?>.html');
	});
}
//0:下载excel模板 1:导出数据
function __down_excel(t)
{
	$('#mx-Grid-Excel-out-title').val($.mx.sysmenu.tree.title);
	$('#mx-Grid-Excel-out-type').val(t);
	$('#mx-Grid-Excel-out-typeid').val('<?php  echo $_GET["tp"];  ?>');
	$('#mx-Grid-Excel-out-dbname').val('<?php echo Template::$_tplval['CONFINI']['dbtname']; ?>');
	$("#mx-Grid-Excel-out-down").ajaxSubmit({
		iframe:true,
		success:function(responseText, statusText, xhr, $form){
			$("#mx-submitting").hide();
			Tip({title:"提示",content:'操作成功!'});
		}
	});	
}
//上传excel文件
function __upload_excel()
{
	var uploader = new plupload.Uploader({
		runtimes:'html5,flash,browserplus,html4',
		browse_button:'util-excel-upload',
		container:'util-excel-upload-div',
		max_file_size:__UPLOADMAXSIZE,
		chunk_size:'1mb',
		url:'./do/?FileUpload-simpleup/picid/0.html',
		flash_swf_url:'plupload/plupload.flash.swf',
		filters:[{"title":"excel files","extensions":"xlsx"}]
	});
	uploader.bind('QueueChanged', function(up){
		mxmask('正在上传请等待!');
		uploader.start();
	});
	//错误
	uploader.bind('Error', function(up, args){
		Tip({title:"文件上传提示",content:"【"+args.file.name+"】"+args.message});
		return;
	});
	uploader.bind('FileUploaded',function(up, file, info){
		var res = encode(info.response);
		$("#mx-submitting").hide();
		if(res.error){
			Tip({title:"文件上传提示",content:res.error});
		}else{
			$("#util-excel-upload-val").val(res.name);
			$("#util-excel-upload-path").val(res.path);
			return;
		}
	});
	uploader.init();
}
</script>