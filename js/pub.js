/**
 * 翻页参数解析
 */
function page_paras(data,url,sptor)
{
	sptor = sptor?sptor:'/';
	var p = window.['eval']('('+data+')'),
		url = _url?_url:window.location.href,
		_phtml = url.lastIndexOf(".html"),
		url = _phtml>0?url.substr(0,_phtml):url,
		_ppos = url.indexOf(sptor+p.tag+sptor),
		url = _ppos>0?url.substr(0,_ppos):url;
		url = url+sptor;
	return {p:p,url:url,sptor:sptor};
}
/**
 * 第一种翻页样式
 */
function page_style1(data,url,sptor)
{
	var json = page_paras(data,url,sptor),
		p = json.p,
		url = json.url,
		sptor = json.sptor;
	if(p.total>0){		
		str = '<div class="page" style="text-align:center"><form method="post" class="__ims_page_form" style="margin:0; padding:0;" onsubmit="return false;">每页有'+p.stride+'条记录 当前页为:'+p.current_page+' 共有'+p.last_page+'页 '; 
		str += p.current_page>1?'<a href="'+url+p.tag+sptor+'1.html">第一页</a> |  ':'第一页 |';
		str += p.current_page>1?'<a href="'+url+p.tag+sptor+p.up_page+'.html">上一页</a> ':'';
		str += '<input name="__ims_pagernum" type="text" style="width:30px; height:18px;" value="'+p.current_page+'" /> ';
		str += p.current_page<p.last_page?'<a href="'+url+p.tag+sptor+p.next_page+'.html">下一页</a> | ':'';
		str += p.current_page<p.last_page?'<a href="'+url+p.tag+sptor+p.last_page+'.html">最后一页</a></form></div>':'最后一页</form></div>';
		$(h).html(str);
		$(".__ims_page_form").submit(function(){
			var _val = $("input[name='__ims_pagernum']",this).val();
			_val = _val==""?1:_val;
			document.location = url+p.tag+sptor+_val+".html";
			return false;
		});
		$("input[name='__ims_pagernum']").keydown(function(){
			var _val = $(this).val();
			if('' != _val.substr(0,1))
			{
				if(_val.substr(0,1) == 0)
					$(this).val('');
			}
			if  ('' != _val.replace(/\d/g,''))
			{
				$(this).val(_val.replace(/\D/g,''));
			}
		});
	}
}
/**
 * 第一种翻页样式
 */
function page_style2(data,url,sptor)
{
	var json = page_paras(data,url,sptor),
		p = json.p,
		url = json.url,
		sptor = json.sptor;
	if(p.total>0){		
		var str = '';
		str += '<div class="pages"><span>共'+parseInt(p.last_page)+'页</span>';
		str += parseInt(p.current_page)>1?'<span><a title="" href="'+url+p.tag+sptor+parseInt(p.up_page)+'.html">上一页</a></span>':'';
		var lastpage = Math.ceil(p.current_page/5)*5,
			firstpage = lastpage-4;
		for(var i=firstpage;i<=lastpage;i++){
			var curcss = i==p.current_page?'class="this"':'';
			if(i<=p.last_page)
				str += '<span '+curcss+'><a title="" href="'+url+p.tag+sptor+i+'.html">'+i+'</a></span>';
		}
		if(i<p.last_page) str += '<span>...</span>';
		str += p.current_page<p.last_page?'<span><a title="" href="'+url+p.tag+sptor+p.next_page+'.html">下一页</a></span>':'';
		str += p.current_page<p.last_page?'<span><a title="" href="'+url+p.tag+sptor+p.last_page+'.html">末页</a></span>':'';
		str += '</div>';
		$(h).html(str);
	}
}
/**
 * 内容翻页
 */
function contentPage(id)
{
	var obj = document.getElementById(id);
	var content = obj.innerHTML;
	//计算翻页数
	content = content.toLowerCase();//将字母转换成小写
	var tempep = content.split('<!--/ewebeditor:page-->');
	//过滤掉为空的数组
	var ep = [],tempeplen = tempep.length;
	for(var i=0;i<tempeplen-1;i++){
		if(tempep[i]!='' && tempep[i]!="\n") ep.push(tempep[i]);
	}
	var eplen = ep.length;
	return {
		show:function()
		{
			var chash = document.location.hash,
				curpage = 1;
			if(chash!=""){
				var pn = chash.replace("#cpage=","");
				curpage = parseInt(pn);
			}
			if(eplen<2){
				obj.style.display = "block";
			}else{
				var str = '';
				str += '<div id="EMS-CONTENT-PAGE">'+ep[curpage-1]+'</div>';
				str += '<div class="content-page" id="EMS-CONTENT-PSTYLE" style="text-align: center; padding-top: 15px; font-size:12px;">';
				for(var i=1;i<=eplen;i++){
					if(curpage==i){
						str += '<span style="color:#CCCCCC">['+i+']</span>';
					}else{
						str += '<span onclick="contentPage(\''+id+'\').page('+i+')" style="cursor:pointer">['+i+']</span>';
					}
				}
				str += '</div>';
				document.write(str);
			}
		},
		page:function(p)
		{
			document.getElementById("EMS-CONTENT-PAGE").innerHTML = ep[p-1];
			var str = '';
			for(var i=1;i<=eplen;i++){
				if(p==i){
					str += '<span style="color:#CCCCCC">['+i+']</span>';
				}else{
					str += '<span onclick="contentPage(\''+id+'\').page('+i+')" style="cursor:pointer">['+i+']</span>';
				}
			}
			document.getElementById("EMS-CONTENT-PSTYLE").innerHTML = str;
			document.location.hash = "#cpage="+p;
		}
	};
}