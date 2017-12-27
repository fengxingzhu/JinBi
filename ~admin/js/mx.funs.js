/**
 * 所有ajax调用页面时的公共应用
 **/
function loadpubfn()
{
	//关闭连接提示
	$("#mx-submitting").hide();
	//关闭提示信息
	$('[itip]').poshytip('hide');
	//宽高自适应
	$.mx.autowarp();
	//数据映射
	$(".mx-mapping").each(function(i,o){
		var v = $(o).text(),
			k = $(o).attr("key");
		if(k && v) $(o).text($['mx']['mappdata'][k][v]);
	});
	// tree panel
	$(".filetree").treeview();
	/**
	 * form ajax submit
	 **/
	$(".ajaxform").mxform();
	/**
	 * 加载tree content
	 **/
	$("#treeview-content a[url]").click(function(){
		var url = $(this).attr("url");
		$('[itip]').poshytip('hide');
		mxmask('正在加载...');
		$("#treeview-content").load(url,loadpubfn);
		return false;
	});
	//加载到对应的内容页
	$("#treeview-content a[brurl]").click(function(){
		var url = $(this).attr("brurl");
		$.mx.setparam('url',url);
		$('[itip]').poshytip('hide');
		mxmask('正在加载...');
		$("#treeview-content").load(url,loadpubfn);
		return false;
	});
	//加载到对应的内容页 变量路径
	$("#treeview-content a[valurl]").click(function(){
		var val = $(this).attr("valurl"),
			churltg = $(this).attr("chvalurl"),
			churltg = churltg?churltg:val,
			param = $.mx.getparam(),
			url = param[val];
		$.mx.setparam(churltg,url);
		$('[itip]').poshytip('hide');
		mxmask('正在加载...');
		$("#treeview-content").load(url,loadpubfn);
		return false;
	});
	//列表删除
	$(".mx-list-remove").click(gridlistdel);
	//全选
	$("input[name='allselect']:checkbox").click(function(){
		var check = $(this).attr('checked');
		check = check?true:false;
		var ochson = $("input[type='checkbox'][name='checks']");
		ochson.attr("checked",check);
		var otr = ochson.parent().parent().parent();
		check?otr.addClass("trSelected"):otr.removeClass("trSelected");
	});
	//单个选中时
	$("input[type='checkbox'][name='checks']").click(function(){
		var check = $(this).attr('checked');
		check = check?true:false;
		var otr = $(this).parent().parent().parent();
		check?otr.addClass("trSelected"):otr.removeClass("trSelected");
	});
	//取得当前菜单信息
	$(".mx-sysmenu").each(function(i,o){
		$(o).text($.mx.sysmenu.tab.title+" > "+$.mx.sysmenu.tree.title);
	});
	$(".mx-sysmenu-tab").each(function(i,o){
		$(o).text($.mx.sysmenu.tab.title);
	});
	$(".mx-sysmenu-tree").each(function(i,o){
		$(o).text($.mx.sysmenu.tree.title);
	});
}

//列表删除
function gridlistdel(){
	var delid = $(this).attr("delid"),
		delname = $(this).attr("delname"),
		backurl = $(this).attr("backurl"),
		delurl = $(this).attr("delurl");
	dialog({
		title:'提示',
		content:'确定删除《'+delname+'》吗?,如果确定,删除后将不能恢复!',
		resizable:false,
		bgiframe:false,
		buttons:{
			'是': function(){
				var me = this;
				$.get(delurl+"/id/"+delid+".html",function(){
					Tip({title:'删除提示:',content:'《'+delname+'》删除成功!'});
					tabtreecontent(backurl,function(){
						$(me).dialog('destroy');
					});
				});
			},
			'否': function() {
				$(this).dialog('destroy');
			}
		}
	});
}
//手动排序
function handsort(c)
{
	return function(){
		var ids = [],
			vals = [];
		$(c.tb+" input[name='handsort']").each(function(i,o){
			ids.push($(o).attr("mid"));
			vals.push($(o).val());
		});
		c.post.ids = ids.join(",");
		c.post.vals = vals.join(",");
		$.post(c.url,c.post,function(text){
			Tip({title:'手动排序提示:',content:'手动排序成功!'});
			tabtreecontent(c.flurl);
		});
	};
}
//批量删除
function moredelete(c)
{
	return function(){
		var ids = [];
		$(c.tb+" input[name='checks']").each(function(i,o){
			if($(o).attr("checked")) ids.push($(o).val());
		});
		c.post.ids = ids.join(",");
		if(c.post.ids != ''){
			$.post(c.url,c.post,function(text){
				Tip({title:'批量删除提示:',content:'批量删除成功!'});
				tabtreecontent(c.flurl);
			});
		}else{
			Tip({title:'批量删除提示:',content:'请选择要删除列表项'});
		}
	};
}
/**
 * 添加映射值
 */
function addmapping(k,d)
{
	$['mx']['mappdata'][k] = d;
}
/**
 * JS调用显示tab content
 */
function tabtreecontent(url,fn)
{
	$("#treeview-content").load(url,function(){
		$.mx.setparam('url',url);
		loadpubfn();
		if(fn) fn();
	});
}
function tabmenuurl(url)
{
	tabtreecontent(url);
	$(".filetree a[url]").removeClass("selected");
	var otree = $("a[url='"+url+"']"),
		treeid = otree.attr("treeid");
	$.mx.setparam('treeid',treeid);
	otree.addClass("selected");
	
}
/**
 * 将字符转换为JSON
 **/
function encode(str)
{
	return $.evalJSON(str);
}
/**
 * 将JSON转换为字符
 **/
function decode(json)
{
	return $.toJSON(json);
}
/**
 * 对话框
 */
function dialog(param)
{
	var defaults = {
		id:'mx-dialog-win',
		modal:true,
		overlay: {
			backgroundColor: '#000',
			opacity: 0.5
		},
		bgiframe:true,
		resizable:true,
		buttons: {
			Ok:function() {
				$(this).dialog('destroy');
			}
		}
	};
	$.extend(defaults,param);
	if(defaults.title && defaults.content){
		$("#"+defaults.id).attr("title",defaults.title);
		$("#"+defaults.id).html(defaults.content);
	}
	$("#"+defaults.id).dialog(defaults);
}
/**
 * 系统错误提示
 */
function Tip(p)
{
	var ob = $("#mx-sys-error"),
		ot = $("#mx-sys-error-title"),
		oc = $("#mx-sys-error-content"),
		defaults = {
			title:'无标题',
			content:'无内容',
			width:260,
			second:3000,
			top:0
		};
	$.extend(defaults,p);
	//计算居中
	defaults.left = ($(window).width()-defaults.width)/2;
	ob.css({
		width:defaults.width,
		top:defaults.top,
		left:defaults.left
	});
	ot.html(defaults.title);
	oc.html(defaults.content);
	ob.slideDown("fast",function(){
		setTimeout("$('#mx-sys-error').slideUp('fast')",defaults.second);
	});
}
/**
 * 文件上传
 **/
function mxuploadfile()
{
	var me = this,
		fid = $(this).attr("fid"),
		picid = $(this).attr("picid"),
		names = [],
		ids = [],
		oldnames = $("#mx-form-upload-"+fid).val(),
		oldids = $("#mx-form-uploadids-"+fid).val();
	names = oldnames.split(",");
	ids = oldids.split(",");
	dialog({
		id:'mx-uploadwinform',
		title:'文件上传',
		width:500,
		height:360,
		resizable:false,
		bgiframe:false,
		buttons:{
			'关　闭': function() {
				$(this).dialog('destroy');
			}
		}
	});
	var _filters = picid>0?[{"title":"Image files","extensions":"jpg,gif,png"}]:__FILTERS;
	$("#uploader").pluploadQueue({
		// General settings
		runtimes: 'html5,flash,browserplus,html4',
		url: './do/?FileUpload-add/picid/'+picid+'.html',
		max_file_size:__UPLOADMAXSIZE,
		chunk_size:'1mb',
		unique_names: false,
		// Specify what files to browse for
		filters:_filters,

		// Flash/Silverlight paths
		flash_swf_url: 'plupload/plupload.flash.swf',

		// Post init events, bound after the internal events
		init:{
			FileUploaded: function(up, file, info) {
				var res = encode(info.response);
				if(res.error){
					Tip({title:"文件上传提示",content:res.error});
				}else{
					if(res.name) names.push(res.name);
					var _names = [],_nameslen = names.length;
					for(var i=0;i<_nameslen;i++){
						if(names[i]!='') _names.push(names[i]);
					}
					$("#mx-form-upload-"+fid).val(_names.join(","));
					if(res.id) ids.push(res.id);
					var _ids = [],_idslen = ids.length;
					for(var i=0;i<_idslen;i++){
						if(ids[i]!='') _ids.push(ids[i]);
					}
					$("#mx-form-uploadids-"+fid).val(_ids.join(","));
				}
			},
			Error: function(up, args) {
				// Called when a error has occured
				Tip({title:"文件上传提示",content:args.file.name});
				return;
			}
		}
	});
}
//单文件上传
function mximpleupload()
{
	var me = this,
		fid = $(me).attr("fid"),
		ag = $(me).attr("ag"),
		tp = $(me).attr("tp"),
		id = $(me).attr("nid"),
		filedname = $("#mx-form-upload-"+fid).attr("name"),
		fileoldname = $("#mx-form-upload-"+fid).val(),
		filepath = $("#mx-form-simpleuploadids-"+fid).val();
	dialog({
		title:'单文件管理',
		content:'<div style="text-align:center"><img src="../'+filepath+'" border="0"  /></div>',
		width:500,
		height:360,
		resizable:true,
		bgiframe:false,
		buttons:{
			'删　除':function(){
				var box = this;
				$.post("util/grid/do/?Grid-delsimplefile/ag/"+ag+"/tp/"+tp+"/",{id:id,filedname:filedname},function(text){
					$("#mx-form-upload-"+fid).val("");
					$("#mx-form-simpleuploadids-"+fid).val("");
					$(box).dialog('destroy');
				});
			},
			'关　闭': function() {
				$(this).dialog('destroy');
			}
		}
	});
}
//多文件管理
function mxuploadplist()
{
	var me = this,
		fid = $(me).attr("fid"),
		ag = $(me).attr("ag"),
		tp = $(me).attr("tp"),
		ids = $("#mx-form-uploadids-"+fid).val(),
		filedname = $("#mx-form-upload-"+fid).attr("name");
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
					$.post("util/grid/do/?Grid-delappends/ag/"+ag+"/tp/"+tp+"/isformeditflag/1/",{ids:idstr,filedname:filedname,fieldnid:fid,oldids:ids},function(text){
						formmanappends(ag,tp,ids,fid);
						var otext = eval('('+text+')');
						$("#mx-form-upload-"+fid).val(otext.names);
						$("#mx-form-uploadids-"+fid).val(otext.ids);
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
					$.post("util/grid/do/?Grid-sortappends/ag/"+ag+"/tp/"+tp+"/isformeditflag/1/",{upids:upidarr.join(","),upoldnamearr:upoldnamearr.join("||"),upsortarr:upsortarr.join(","),lid:fid,filedname:filedname},function(text){
						formmanappends(ag,tp,ids,fid);
						var otext = eval('('+text+')');
						$("#mx-form-upload-"+fid).val(otext.names);
						$("#mx-form-uploadids-"+fid).val(otext.ids);
					});
			},
			'关　闭': function() {
				$(this).dialog('destroy');
			}
		}
	});
	formmanappends(ag,tp,ids,fid);
}
function formmanappends(ag,tp,ids,lid)
{
	$("#GridBase-filegrids").load("util/grid/?brfiles/ag/"+ag+"/tp/"+tp+"/fid/"+ids+"/lid/"+lid+"/",function(){
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
//退出登录
function logout()
{
	dialog({
		title:'提示',
		content:'确定退出吗?',
		resizable:false,
		bgiframe:false,
		buttons:{
			'是': function() {
				document.location = "do/?PlugsUserPass-logout.html";
			},
			'否': function() {
				$(this).dialog('destroy');
			}
		}
	});
}
//修改密码
function editpassword()
{
	dialog({
		id:'mx-button-editpassword',
		resizable:false,
		bgiframe:false,
		buttons: {
			'修改密码':function() {
				var me = this;
				$("#mx-ajaxform-editpassword").ajaxSubmit({
					beforeSubmit:$.mx.validator,
					success:function(responseText, statusText, xhr, $form){
						if(responseText=="1"){
							$("#mx-submitting").hide();
							$(me).dialog('destroy');
							Tip({title:"提示",content:'密码修改成功,下次登录生效!'});
						}else{
							$("#mx-submitting").hide();
							Tip({title:"提示",content:responseText});
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
//更改主题
function changetheme()
{
	dialog({
		id:'mx-theme-listview',
		resizable:false,
		bgiframe:false,
		width:430,
		height:190,
		buttons: {
			'确　定':function() {
				var oselected = '',me = this;
				$("#mx-theme-listview a").each(function(i,o){
					var cs = $(o).attr("class");
					oselected = cs == 'selected'?o:oselected;
				});
				if(oselected==''){
					Tip({title:"更改主题提示",content:"请选择一个主题"});
				}else{
					var _theme = $(oselected).attr("theme");
					$.post("do/?EditUser-theme.html",{theme:_theme},function(text){
						$(me).dialog('destroy');
						Tip({title:"更改主题提示",content:"主题修改成功,下次登录生效!"});
					});
				}
			},
			'关　闭': function() {
				$(this).dialog('destroy');
			}
		}
	});
}
//清空多级联动
function gradesearchclear(t,me)
{
	var gdsr = t.attr('downfields');
	if(gdsr){
		var downfield = gdsr.split(","),
			downfdlen = downfield.length;
		for(var di=0;di<downfdlen;di++){
			var dftemp = downfield[di],
				downselect = $('select[name="'+dftemp+'"]',me);
			downselect.find('option[keyid!=""]').remove();
			gradesearchclear(downselect);
		}
	}
}
//蒙板效果
function mxmask(msg)
{
	//正在向服务器传送数据
	var omask = $("#mx-submitting");
	if(omask.length<1){
		omask = $("<div>").appendTo("body");
		omask.attr("id","mx-submitting");
		var oling = $("<div>").appendTo(omask);
		oling.attr("id","mx-subloing");
		oling.html('<img src="images/loading.gif" align="absmiddle"><span id="mx-submitting-msg"></span>');
	}
	var _w = $.mx.width(),_h = $.mx.height();
	omask.css({width:_w,height:_h});
	$("#mx-subloing").css({left:(_w-120)/2,top:(_h-30)/2});
	$("#mx-submitting-msg").html(msg);
	omask.show();
}
/**
 * 图片文件上传
 */
function mxajaxFileUpload(t)
{
	mxmask('正在上传...');
	var name = $(t).attr('name'),
		feid = $(t).attr('id'),
		cw = $(t).attr('cw'),
		ch = $(t).attr('ch');
	$.ajaxUpload({
		url:'do/?ImgUpload-up.html',
		secureuri:false,
		fileElementId:feid,
		dataType: 'json',
		data:{name:name,cw:cw,ch:ch,id:'id'},
		success: function (data, status)
		{
			$("#mx-submitting").hide();
			if(typeof(data.error) != 'undefined')
			{
				if(data.error != ''){
					Tip({title:"图片上传提示",content:data.error});
				}else{
					if(data.npath!=''){
						$('#'+feid).trigger('blur');
						$(t).parent().parent().find('.mxformerrors').hide();
						$('#'+feid+'-path').val(data.npath);
						$('#'+feid+'-name').val(data.oldname);
						$('#'+feid+'-src').show().attr('src',$('#'+feid).attr('prefix')+data.npath);
					}
				}
			}
		},
		error: function (data, status, e)
		{
			$("#mx-submitting").hide();
			alert(e);
		}
	});
	return false;
}