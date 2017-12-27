/**
 * mx的基础类 全局类
 */
;(function($,doc,win){
$.mx = {
	//版本信息
	version:'1.0',
	//全局变量
	global:{},
	//菜单信息
	sysmenu:{},
	//映射数据源
	mappdata:{
		bool:['否','是']
	},
	//form提交前处理
	formbefun:{},
	//field puls
	fdjsplus:{},
	//浏览器的高
	height: function() {
		// handle IE 6
		if ($.browser.msie && $.browser.version < 7) {
			var scrollHeight = Math.max(
				doc.documentElement.scrollHeight,
				doc.body.scrollHeight
			);
			var offsetHeight = Math.max(
				doc.documentElement.offsetHeight,
				doc.body.offsetHeight
			);
	
			if (scrollHeight < offsetHeight) {
				return $(win).height();
			} else {
				return scrollHeight;
			}
		// handle "good" browsers
		} else {
			return $(win).height();
		}
	},
	//浏览器的宽
	width: function() {
		// handle IE 6
		if ($.browser.msie && $.browser.version < 7) {
			var scrollWidth = Math.max(
				doc.documentElement.scrollWidth,
				doc.body.scrollWidth
			);
			var offsetWidth = Math.max(
				doc.documentElement.offsetWidth,
				doc.body.offsetWidth
			);
	
			if (scrollWidth < offsetWidth) {
				return $(win).width();
			} else {
				return scrollWidth;
			}
		// handle "good" browsers
		} else {
			return $(win).width();
		}
	},
	/**
	 * 读取参数
	 **/
	getparam:function(){
		var hash = win.location.hash,
			hashstr = hash.substr(1,hash.length),
			epara = hashstr.split("&"),
			res = {};
		for(var i=0;i<epara.length;i++){
			var epram = epara[i].split("=");
			if(epram[0]) res[epram[0]] = epram[1];
		}
		return res;
	},
	/**
	 * 设置参数
	 **/
	setparam:function(k,v)
	{
		var get = this.getparam(),
			hash = [];
		get[k] = v;
		for(var i in get){
			if(get[i]!='') hash.push(i+"="+get[i]);
		}
		win.location.hash = hash.join("&");
	},
	//自适应
	autowarp:function()
	{
		var me = $.mx,
			gl = me.global;
		gl.height = me.height();
		gl.width = me.width();
		//自适应处理
		$("[cutmargin]").each(function(i,o){
			var ctwh = $(o).attr("cutmargin") || '0,0',
				ectwh = ctwh.split(",");
			if(ectwh[0]>0) $(o).css('width',gl.width-ectwh[0]);
			if(ectwh[1]>0) $(o).css('height',gl.height-ectwh[1]);
		});
		//如果蒙版存在
		var omask = $("#mx-submitting");
		if(omask.length>0){
			omask.css({width:gl.width,height:gl.height});
		}
	},
	//mx的头部tab
	tabs:function(){
		$("#header-tabs-ul >li").click(function(){
			//关闭提示信息
			$('[itip]').poshytip('hide');
			var me = $(this),
				_url = me.attr("url"),
				_eq = me.attr("eq");
			win.location.hash = "tab="+_eq;
			//清除别的状态
			$("#header-tabs-ul >li").each(function(i,o){
				$(o).removeClass("ui-tabs-selected ui-state-active");
			});
			//设置当前tab状态
			$(this).addClass("ui-tabs-selected ui-state-active");
			$.mx.sysmenu.tab = {
				id:_eq,
				title:me.text(),
				url:_url
			};
			mxmask('正在加载...');
			$("#mx-tabs-content").load(_url,function(){ loadpubfn();});
		});
		//默认加载的tab
		var get = this.getparam(),
			tabindex = get['tab']?get['tab']:0,
			tabs = $("#header-tabs-ul >li").eq(tabindex),
			_url = tabs.attr("url");
		tabs.addClass("ui-tabs-selected ui-state-active");
		$.mx.sysmenu.tab = {
			id:tabindex,
			title:tabs.text(),
			url:_url
		};
		$("#mx-tabs-content").load(_url,function(){ loadpubfn();});
	},
	//加载mx的ui
	load:function()
	{
		var me = this;
		me.tabs();
		me.autowarp();
		loadpubfn();
		//更换主题
		$("#mx-theme-listview a").click(function(){
			$("#mx-theme-listview a").not(this).each(function(i,o){
				$(this).removeClass("selected");
			});
			$(this).toggleClass("selected");
		});
		$(win).resize(me.autowarp);
	}
};
})(jQuery,document,window);