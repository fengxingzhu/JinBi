/**
 * form plugin
 * 与form相关的应用
 */
;(function($){
/**
 * form ajax submit
 **/
$.fn.mxform = function()
{
	var me = this;
	$.mx.formitemdata = $.mx.formitems(me);
	$($.mx.formitemdata).blur(function(){
		return $.mx.formvaildator(me,$(this));
	});
	//ajax提交
	$(me).ajaxForm({
		beforeSubmit:$.mx.validator,
		iframe:true,
		success:function(responseText, statusText, xhr, $form){
			$("#mx-submitting").hide();
			if(responseText!=""){
				$('[itip]').poshytip('hide');
				var ores = encode(responseText);
				switch(ores.type){
					case "msg": Tip({title:ores.title?ores.title:"提示",content:ores.msg}); break;
					case "ajaxcontent": tabtreecontent(ores.url); break;
					case "tab": tabmenuurl(ores.url); break;
					case "jump": document.location = ores.url; break;
				}
			}
		}
	});
	/**
	 * form panel auto layout
	 **/
	$("td",me).each(function(k,o){
		var otd = $(this),
			olabel = otd.find("label"),
			tdwidth = parseInt(otd.attr("width"))-10,
			itemarr = ["input[type!='hidden'][type!='submit'][type!='checkbox'][type!='radio'][class!='noauto'][class!='Wdate noauto']","select[class!='noauto']","textarea"];
		for(var i=0;i<itemarr.length;i++){
			var itdw = otd.find(itemarr[i]);
			if(itdw.length>0) break;
		}
		itdw.attr("class")=="mx-fileupload"?itdw.css("width",tdwidth-36):itdw.css("width",tdwidth);
		olabel.css("width",tdwidth);
		//字段补丁
		var ofdplusfn = itdw.attr('fdplusfn');
		if(ofdplusfn!='' && $['mx']['fdjsplus'][ofdplusfn]){
			$['mx']['fdjsplus'][ofdplusfn].init(itdw);//补丁初始化
		}
	});
	//解析ckeditor编辑器
	$('textarea[edit="ckeditor"]',me).each(function(i,o){
		var editor = CKEDITOR.replace($(this).attr('id'));
		CKFinder.setupCKEditor(editor,'../~editor/ckeditor/ckfinder/');
	});
	//单文件上传
	$(".mx-formsimpleup-img",me).each(function(i,o){
		var buttonid = $(o).attr("id"),
			fieldname = $(o).attr("fieldname"),
			picid = $(o).attr("picid");
		//字段补丁
		var ofdplusfn = $(o).attr('fdplusfn');
		if(ofdplusfn!='' && $['mx']['fdjsplus'][ofdplusfn]){
			$['mx']['fdjsplus'][ofdplusfn].init($(o));//补丁初始化
		}
		var _filters = picid>0?[{"title":"Image files","extensions":"jpg,gif,png"}]:__FILTERS;
		var uploader = new plupload.Uploader({
			runtimes:'html5,flash,browserplus,html4',
			browse_button:buttonid,
			container:buttonid+'-div',
			max_file_size:__UPLOADMAXSIZE,
			chunk_size:'1mb',
			url:'./do/?FileUpload-simpleup/picid/'+picid+'.html',
			flash_swf_url:'plupload/plupload.flash.swf',
			filters:_filters
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
				var ofdplusfn = $("input[name='"+fieldname+"']",me).attr('fdplusfn');
				if(ofdplusfn!='' && $['mx']['fdjsplus'][ofdplusfn]){
					if($['mx']['fdjsplus'][ofdplusfn].uploaded) $['mx']['fdjsplus'][ofdplusfn].uploaded($(o),res,me);//补丁初始化
				}
				$("input[name='"+fieldname+"']",me).val(res.name);
				$("input[name='"+fieldname+"_path']",me).val(res.path);
			}
		});
		uploader.init();
	});
	//多文件上传
	$(".mx-formup-img",me).click(mxuploadfile);
	//datalist 多项数据选择时
	$(".datalist",me).each(function(i,o){
		var width = $(o).parent().attr("width"),
			col = $(o).attr("col"),
			wdtp = Math.floor(width/col)-10;
		$("span",o).each(function(ii,oo){
			$(oo).css('width',wdtp);
		});
		//字段补丁
		var ofdplusfn = $(o).attr('fdplusfn');
		if(ofdplusfn!='' && $['mx']['fdjsplus'][ofdplusfn]){
			$['mx']['fdjsplus'][ofdplusfn].init($(o));//补丁初始化
		}
	});
	//单文件修改
	$(".mx-fileupload-simpleimg").click(mximpleupload);
	//多文件修改
	$(".mx-fileupload-imglist").click(mxuploadplist);
	//当点击radio时查找对应的键名，并将键名赋值给key字段
	$('[type="radio"]',me).click(function(){
		var n = $(this).attr("name"),
			kv = $(this).attr("keyid"),
			kfd = $('input[type="hidden"][name="'+n+'_key"]',me);
		kfd.val($(this).attr("checked")?kv:kfd.val());
	});
	//当点击checkbox时查找对应的键名，并将键名赋值给key字段
	$('[type="checkbox"]',me).click(function(){
		var n = $(this).attr("name"),
			nold = n.substr(0,n.length-3),
			nfd = $('input[type="hidden"][name="'+nold+'"]',me),
			kfd = $('input[type="hidden"][name="'+nold+'_key"]',me),
			groups = $('[name="'+n+'"]',me),
			names = [];
			vals = [];
		for(var i=0;i<groups.length;i++){
			if($(groups[i]).attr("checked")){
				names.push($(groups[i]).val());
				vals.push($(groups[i]).attr("keyid"));
			}
		}
		nfd.val(names.join(","));
		kfd.val(vals.join(","));
	});
	//下拉选择
	$('select',me).change(function(){
		var n = $(this).attr("name"),
			opts = $('option',this),
			kfd = $('input[type="hidden"][name="'+n+'_key"]',me),
			gdsr = $(this).attr('downfields');
		for(var i=0;i<opts.length;i++){
			if(opts.eq(i).attr("selected")) kfd.val(opts.eq(i).attr("keyid"));
		};
		//联动操作
		if(gdsr){
			var downfield = gdsr.split(","),
				downfdlen = downfield.length,
				selectval = kfd.val();
			for(var di=0;di<downfdlen;di++){
				var dftemp = downfield[di],
					downselect = $('select[name="'+dftemp+'"]',me),
					dfoptiondata = $('.gradesearchfieldata[name="'+dftemp+'__data"]',me).find('option'),
					dfoptdatalen = dfoptiondata.length;
				downselect.find('option[keyid!=""]').remove();
				for(var dtempi = 0; dtempi<dfoptdatalen; dtempi++){
					var __downoption = dfoptiondata.eq(dtempi);
					if(__downoption.attr("parentkey")==selectval){
						downselect.append('<option value="'+__downoption.attr("value")+'" keyid="'+__downoption.attr("keyid")+'">'+__downoption.attr("value")+'</option>');
					}
				}
				gradesearchclear(downselect);
			}
		}
	});
	//load Record
	var d = $(".mx-formdata",me).val();
	if(d){
		var dd = encode(d);
		//异步数据时先处理的函数
		var yclfun = $(me).attr('fun');
		if(yclfun) eval(yclfun+'(dd)');
		//text field
		$('[type="text"],[type="hidden"][class!="noload"]',me).each(function(i,o){
			$(o).val(dd[$(o).attr('name')]);
			//补丁
			var ofdplusfn = $(o).attr('fdplusfn');
			if(ofdplusfn!='' && $['mx']['fdjsplus'][ofdplusfn]){
				if($['mx']['fdjsplus'][ofdplusfn].load) $['mx']['fdjsplus'][ofdplusfn].load($(o));//补丁初始化
			}
		});
		//select field
		$('select',me).each(function(i,o){
			var option = $(o).find('option'),
				optlen = option.length,
				optval = dd[$(o).attr('name')],
				gdsr = $(this).attr('downfields'),
				selectval = '';
			for(var i=0;i<optlen;i++){
				if($(option[i]).val()==optval){
					selectval = $(option[i]).attr("keyid");
					$(option[i]).attr("selected","selected");
				}
			}
			//联动操作
			if(gdsr){
				var downfield = gdsr.split(","),
					downfdlen = downfield.length;
				for(var di=0;di<downfdlen;di++){
					var dftemp = downfield[di],
						downselect = $('select[name="'+dftemp+'"]'),
						dfoptiondata = $('.gradesearchfieldata[name="'+dftemp+'__data"]').find('option'),
						dfoptdatalen = dfoptiondata.length;
					for(var dtempi = 0; dtempi<dfoptdatalen; dtempi++){
						var __downoption = dfoptiondata.eq(dtempi);
						if(__downoption.attr("parentkey")==selectval){
							downselect.append('<option value="'+__downoption.attr("value")+'" keyid="'+__downoption.attr("keyid")+'">'+__downoption.attr("value")+'</option>');
						}
					}
				}
			}
			//补丁
			var ofdplusfn = $(o).attr('fdplusfn');
			if(ofdplusfn!='' && $['mx']['fdjsplus'][ofdplusfn]){
				if($['mx']['fdjsplus'][ofdplusfn].load) $['mx']['fdjsplus'][ofdplusfn].load($(o));//补丁初始化
			}
		});
		//textarea field
		$('textarea[class!="noload"]',me).each(function(i,o){
			$(o).val(dd[$(o).attr('name')]);
			//补丁
			var ofdplusfn = $(o).attr('fdplusfn');
			if(ofdplusfn!='' && $['mx']['fdjsplus'][ofdplusfn]){
				if($['mx']['fdjsplus'][ofdplusfn].load) $['mx']['fdjsplus'][ofdplusfn].load($(o));//补丁初始化
			}
		});
		//radio field
		$('[type="radio"][class="groupdata"]',me).each(function(i,o){
			$(o).val() == dd[$(o).attr('name')]?$(o).attr("checked",true):"";
			//补丁
			var ofdplusfn = $(o).attr('fdplusfn');
			if(ofdplusfn!='' && $['mx']['fdjsplus'][ofdplusfn]){
				if($['mx']['fdjsplus'][ofdplusfn].load) $['mx']['fdjsplus'][ofdplusfn].load($(o));//补丁初始化
			}
		});
		//checkbox field
		$('[type="checkbox"][class="groupdata"]',me).each(function(i,o){
			var n = $(o).attr("name"),
				key = $(o).attr("keyid"),
				nold = n.substr(0,n.length-3),
				nlv = $('input[type="hidden"][name="'+nold+'_key"]',me).val(),
				enlv = nlv.split(",");
			$(o).attr("checked",$.inArray(key,enlv)>-1?true:false);
			//补丁
			var ofdplusfn = $(o).attr('fdplusfn');
			if(ofdplusfn!='' && $['mx']['fdjsplus'][ofdplusfn]){
				if($['mx']['fdjsplus'][ofdplusfn].load) $['mx']['fdjsplus'][ofdplusfn].load($(o));//补丁初始化
			}
		});
		//file pic upload field
		$('[type="file"]',me).each(function(i,o){
			var fid = $(o).attr('id'),
				fnpath = $(o).attr('name'),
				pre = $(o).attr('prefix');
			$('#'+fid+'-src').show().attr('src',pre+dd[fnpath+'_path']);
		});
	}
};
/**
 * 表单字段信息
 */
$.mx.formitems = function(jqForm){
	var oitems = [];
	//input表单
	$('input',jqForm).each(function(i,o){
		oitems.push(o);
	});
	//select表单
	$('select',jqForm).each(function(i,o){
		oitems.push(o);
	});
	//textarea表单
	$('textarea',jqForm).each(function(i,o){
		oitems.push(o);
	});
	//datalist 单选多选表单
	$('.datalist',jqForm).each(function(i,o){
		oitems.push(o);
	});
	return oitems;
};
//错误时聚焦的字段
$.mx.formfieldfocus = '';
/**
 * 验证信息
 */
$.mx.formvaildator = function(jqForm,oitems){
	var reg = {
			Require : /.+/, //必填项
			Email : /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/, //验证邮箱
			Phone : /^((\(\d{2,3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}(\-\d{1,4})?$/, //验证电话
			Number : /^\d+$/, //验证数字
			NumberSplit: /^[,\d]+$/, //验证数字
			Integer : /^[-\+]?\d+$/, //验证整数
			English : /^[A-Za-z]+$/, //验证英文
			EngNum: /^[A-Za-z\d]+$/ ,//验证英文或者数字
			EngNumDl: /^[A-Za-z\d_]+$/ ,//验证英文或者数字
			Chinese :  /^[\u0391-\uFFE5]+$/ //验证中文
		},
		itemlen = oitems.length;
	for (var i=0; i<itemlen;i++) {
		var oinput = oitems[i],
			value = $(oinput).val(),
			_dataType = $(oinput).attr('dataType');
		//判断是否有字段plus补丁
		var ofdplusfn = $(oinput).attr('fdplusfn');
		if(ofdplusfn!='' && $['mx']['fdjsplus'][ofdplusfn]){
			if($['mx']['fdjsplus'][ofdplusfn].submit) $['mx']['fdjsplus'][ofdplusfn].submit($(oinput));//补丁初始化
		}
		if(typeof(_dataType) == "object" || typeof(_dataType) == "undefined")  continue;
        if($(oinput).attr("require") == "false" && value == "") continue;
		switch(_dataType){
			case "IdCard" :
			case "Date" :
			case "Repeat": //判断两个值是否一致
				var totag = $(oinput).attr('to'),
				opv = jqForm.find("input[name='"+totag+"']").val();
				if(opv!=value){
					$.mx.formfieldfocus = oinput;
					$.mx.formfielderror(oinput,true);
					return false;
				}else{
					$.mx.formfielderror(oinput,false);
				}
				break;
			case "Range" :
			case "Compare" :
			case "Custom" :
			case "Group" : //多个数据判断
				var n = $(oinput).attr("name"),
				groups = $('input[name="'+n+'"]',jqForm);
				var hasChecked = 0;
				min = $(oinput).attr("min") || 1;
				max = $(oinput).attr("max") || groups.length;
				for(var ii=0;ii<groups.length;ii++){
					if($(groups[ii]).attr("checked")) hasChecked++;
				}
				if(!(min <= hasChecked && hasChecked <= max)){
					$.mx.formfieldfocus = oinput;
					$.mx.formfielderror(oinput,true);
					return false;
				}else{
					$.mx.formfielderror(oinput,false);
				}
				break;
			case "Limit" :
			case "LimitB" :
			case "SafeString":
			default :
				if(!reg[_dataType].test(value)){
					$.mx.formfieldfocus = oinput;
					$.mx.formfielderror(oinput,true);
					return false;
				}else{
					$.mx.formfielderror(oinput,false);
				}
				break;
		}
    }
	return true;
};
//字段错误信息提示
$.mx.formfielderror = function(oinput,t)
{
	var _input = $(oinput),_label = _input.parent().find('label');
	if(t){
		_input.addClass('dataerror');
		_label.addClass('tiperror');
		_label.html(_input.attr("itip"));
	}else{
		_input.removeClass('dataerror');
		_label.removeClass('tiperror');
		_label.html(_label.attr("text"));
	}
};
/**
 * 表单验证
 */
$.mx.validator = function(formData, jqForm, options)
{
	var befun = $(jqForm).attr('befun');
	if(befun){//表单提交处理
		var p = $['mx']['formbefun'][befun]();
		if(p && p.ret==false){
			if(p.title && p.msg) Tip({title:p.title,content:p.msg});
			return false;
		}
	}
	var errortag = $.mx.formvaildator(jqForm,$.mx.formitemdata);
	if(!errortag){
		if($.mx.formfieldfocus!='') $($.mx.formfieldfocus).focus();//跳转到对应错误的地方
		return false;
	}
	mxmask('正在保存数据...');
};
})(jQuery);