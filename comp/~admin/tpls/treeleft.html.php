<?php if(!defined('WEB_ROOT')) exit();?><?php if(empty(Action::$classqueue["EPub"])){ require_once(file_exists("do/EPubAct.class.php")?"do/EPubAct.class.php":"~do/EPubAct.class.php"); Action::$classqueue["EPub"] = new EPubAct(); }Action::$classqueue["EPub"]->leftree();?>
<div class="ui-state-default left-tree-top" style="margin-right:2px;"><?php echo Template::$_tplval['__TABNAME']; ?></div>
<ul class="filetree" style="border-right:1px solid #C0C0C0; border-left:1px solid #C0C0C0; border-bottom:1px solid #C0C0C0; margin-right:2px; overflow:auto;"  cutmargin="0,148">
	<?php echo Template::$_tplval['__TREELIST']; ?>
</ul>
<script type="text/javascript">
$(function(){
	//获取默认的tab
	var param = $.mx.getparam();
		getreeid = param['treeid'],
		getreeid = typeof getreeid == "undefined"?1:getreeid,
		getree = $(".filetree a[treeid='"+getreeid+"']"),
		geturl = param["url"];
	if(geturl){
		mxmask('正在加载...');
		$("#treeview-content").load(geturl,loadpubfn);
	}
	if(getree.length>0){
		var _url = getree.attr("url");
		getree.addClass("selected");
		$.mx.sysmenu.tree = {
			id:getreeid,
			title:getree.text(),
			url:_url
		};
		if(_url && !geturl){
			mxmask('正在加载...');
			$("#treeview-content").load(_url,loadpubfn);
		}
	}
	//树型菜单连接
	$(".filetree a[url]").click(function(){
		//关闭提示信息
		$('[itip]').poshytip('hide');
		var me = $(this),
			url = me.attr("url"),
			treeid = me.attr("treeid");
		if(treeid && url){
			$(".filetree a[url]").removeClass("selected");
			me.addClass("selected");
			$.mx.setparam('treeid',treeid);
			$.mx.setparam('url','');
			$.mx.sysmenu.tree = {
				id:treeid,
				title:me.text(),
				url:url
			};
			mxmask('正在加载...');
			$("#treeview-content").load(url,loadpubfn);
		}
	});
});
</script>