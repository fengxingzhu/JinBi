/**
 * 获取JS代码
 **/
function GJS_ADVSLOTS(sid)
{
	var sidtag = 'GJS_ADVSLOTS_'+sid+'';
	document.write('<div id="'+sidtag+'"></div>');
	$.getScript((typeof __WEB_APP=='undefined'?'':__WEB_APP)+'cpubs/gjs/do/?Adv-getcode/id/'+sid+'/randtime/'+Math.random()+'.html');
}