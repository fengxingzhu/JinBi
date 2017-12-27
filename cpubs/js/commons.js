(function($){
$.fn.__jiaodiantu = function(opt){
	/* default options */
	opt = $.extend({
		data:[],	//数据{title,pic_path,link}
		width:300,  //宽
		height:200, //高
		time:4 		//轮播时间 单位秒
	},opt);
	/* 创建DOM */
	var me = this,
		n = 0,
		_time = opt.time*1000, //循环时间
		_data = opt.data,
		_html = [],
		_nums = [], //num HTML
		_imgs = [],	// img link pic HTML
		_len = _data.length; //个数
	for(var i=0;i<_len;i++){
		var _d = _data[i];
		_nums.push('<li>'+(i+1)+'</li>');
		_imgs.push('<a href="'+_d['link']+'" target="_blank"><img src="'+(typeof __WEB_APP=='undefined'?'':__WEB_APP)+_d['pic_path']+'" title="'+_d['title']+'" alt="'+_d['title']+'" /></a>');
	}
	_html.push(
		'<div class="bg"></div>',
		'<div class="title"></div>',
		'<ul>',
		_nums.join(''),
		'</ul>',
		'<div class="list">',
		_imgs.join(''),
		'</div>'
	);
	$(me).addClass('__jiaodiantu').css({width:opt.width,height:opt.height}).html(_html.join(''));
	$(".list a:not(:first-child)",me).hide();
	$(".title",me).html($(".list a:first-child",me).find("img").attr('alt'));
	$("ul li",me).click(function() { 
		var i = $(this).text() - 1;//获取Li元素内的值，即1,2,3,4 
		if (i >= _len) return;
		$(".title",me).html($(".list a",me).eq(i).find("img").attr('alt')); 
		$(".title",me).unbind().click(function(){window.open($(".list a",me).eq(i).attr('href'), "_blank")}) 
		$(".list a",me).filter(":visible").fadeOut(500).parent().children().eq(i).fadeIn(1000); 
		$(this).css({"background":"#be2424",'color':'#000'}).siblings().css({"background":"#6f4f67",'color':'#fff'}); 
	}).eq(0).css({"background":"#be2424",'color':'#000'}); 
	var pub = {
			timeshow:function()
			{
				n = n >=(_len - 1)?0:++n;
				$("ul li",me).eq(n).trigger('click');
			}
		},
		t = setInterval(pub.timeshow,_time);
	$(me).hover(
		function(){
			clearInterval(t);
		},
		function(){
			t = setInterval(pub.timeshow,_time);
		}
	); 
};
})(jQuery);(function($,win){
$.__duilian = function(opt){
	/* default options */
	opt = $.extend({
		top:'center',	//上边距的象素
		width:100, 		//宽
		height:200,		//高
		left:6,			//离左侧的距离
		right:6,		//离右侧的距离
		data:[]			//数据
	},opt);
	var _top = opt.top,
		_width = opt.width,
		_height = opt.height,
		_leftdata = opt.data[0],
		_rightdata = opt.data[1],
		_webapp = typeof __WEB_APP=='undefined'?'':__WEB_APP;
	if(_top=='center'){//计算居中
		var _h = parseInt($(win).height());
		_top = Math.floor((_h-_height)/2);
	}
	var dlcss = '__duilian',
		warpwht = 'width:'+_width+'px;height:'+_height+'px;top:'+_top+'px;',
		html = [];
	html.push(
		'<div class="'+dlcss+'" style="left:'+opt.left+'px;'+warpwht+'">',
			'<div class="content"><a href="'+_leftdata.link+'" target="_blank"><img width="'+_width+'" height="'+_height+'" src="'+_webapp+_leftdata.pic_path+'" border="0"   title="'+_leftdata.title+'" alt="'+_leftdata.title+'"></a></div>',
		'</div>',
		'<div class="'+dlcss+'" style="right:'+opt.right+'px;'+warpwht+'">',
			'<div class="content"><a href="'+_rightdata.link+'" target="_blank"><img width="'+_width+'" height="'+_height+'" src="'+_webapp+_rightdata.pic_path+'" border="0"   title="'+_rightdata.title+'" alt="'+_rightdata.title+'"></a></div>',
		'</div>'
	);
	$(html.join('')).appendTo('body');
	$('body .'+dlcss).show();
	$(win).scroll(function(){
		var scrollTop = $(win).scrollTop();
		$('body .'+dlcss).stop().animate({top:scrollTop+_top});
	});
};
})(jQuery,window);/**
 * 获取JS代码
 **/
function GJS_ADVSLOTS(sid)
{
	var sidtag = 'GJS_ADVSLOTS_'+sid+'';
	document.write('<div id="'+sidtag+'"></div>');
	$.getScript((typeof __WEB_APP=='undefined'?'':__WEB_APP)+'cpubs/gjs/do/?Adv-getcode/id/'+sid+'/randtime/'+Math.random()+'.html');
}