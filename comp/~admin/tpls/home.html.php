<?php if(!defined('WEB_ROOT')) exit();?><style type="text/css">
.globalinfo { border-bottom:1px solid #CCCCCC; margin:5px; padding-bottom:5px; float:left; }
.globalinfo dt {  float:left; width:115px; text-indent:10px; }
.globalinfo dd {  float:left; width:230px; }
</style>
<script type="text/javascript">
$(function(){
	$('#myloadlogs').flexigrid({
		title:'我的登录日志',
		height:'auto',
		resizable:false
	});
	//查找当前上传文件运行环境
	var uploader = new plupload.Uploader({
		runtimes:'html5,flash,browserplus,html4',
		browse_button:'runtime_test_btn',
		container:'runtime_test_btn_div',
		flash_swf_url:'plupload/plupload.flash.swf'
	});
	uploader.bind('Init',function(up, params){
		$('#mx_upfile_runtime').html(params.runtime);
	});
	uploader.init();
});
</script>
<?php if(empty(Action::$classqueue["EPub"])){ require_once(file_exists("do/EPubAct.class.php")?"do/EPubAct.class.php":"~do/EPubAct.class.php"); Action::$classqueue["EPub"] = new EPubAct(); }Action::$classqueue["EPub"]->loglogins();Action::$classqueue["EPub"]->upfileinfo();Action::$classqueue["EPub"]->globalinfo();?>
<div class="mx-accordion" style="width:407px; float:left;">
	<div class="ui-state-default left-tree-top" style="margin-right:0; height:28px;">
		<span>服务器信息</span>
	</div>
	<dl class="globalinfo">
		<dt>操作系统:</dt>
		<dd><?php echo Template::$_tplval['OS']; ?></dd>
	</dl>
	<div style="clear:both;"></div>
	<dl class="globalinfo">
		<dt>PHP:</dt>
		<dd><?php echo Template::$_tplval['php']; ?></dd>
	</dl>
	<div style="clear:both;"></div>
	<dl class="globalinfo">
		<dt>WEB服务器软件:</dt>
		<dd><?php echo Template::$_tplval['apache']; ?></dd>
	</dl>
	<div style="clear:both;"></div>
	<dl class="globalinfo">
		<dt>MySQL 版本:</dt>
		<dd><?php echo Template::$_tplval['mysql']; ?></dd>
	</dl>
	<div style="clear:both;"></div>
	<dl class="globalinfo">
		<dt>上传文件大小:</dt>
		<dd><?php echo Template::$_tplval['maxsizeinfo']; ?>mb</dd>
	</dl>
	<div style="clear:both;"></div>
	<dl class="globalinfo">
		<dt>充许上传的文件:</dt>
		<dd>
			<?php $_from = Template::$_tplval['filters']; if (!is_array($_from) && !is_object($_from)){ settype($_from, 'array'); }if (count($_from)){foreach($_from as $key=>Template::$_tplval['list']){ ?>
			<div style="float:left; margin:0; padding:0; text-align:left;">
				<div style="float:left; width:100px; height:20px; line-height:20px; margin:0; padding:0;"><?php echo Template::$_tplval['list']['ftype']; ?></div>
				<div style="float:left; height:20px; line-height:20px;"><?php echo Template::$_tplval['list']['exts']; ?></div>
			</div>
			<div style="clear:both;"></div>
			<?php }} unset($_from);?>
		</dd>
	</dl>
	<dl class="globalinfo">
		<dt>文件上传运行环境:<div id="runtime_test_btn_div"><span id="runtime_test_btn"></span></div></dt>
		<dd id="mx_upfile_runtime"></dd>
	</dl>
	<dl class="globalinfo">
		<dt>MX版本号:</dt>
		<dd><?php echo Template::$_tplval['version']; ?></dd>
	</dl>
</div>
<div class="mx-accordion" cutmargin="420,120" style="float:right; overflow:auto;">
	<table id="myloadlogs">
		<thead>
			<tr>
				<th width="160">登录时间</th>
				<th width="180">IP</th>
				<th width="200">地点</th>
				<th width="140">退出时间</th>
			</tr>
		</thead>
		<tbody>
			<?php $_from = Template::$_tplval['logdata']; if (!is_array($_from) && !is_object($_from)){ settype($_from, 'array'); }if (count($_from)){foreach($_from as $key=>Template::$_tplval['list']){ ?>
			<tr>
				<td><?php echo Template::$_tplval['list']['logintime']; ?></td>
				<td><?php echo Template::$_tplval['list']['ip']; ?></td>
				<td><?php echo Template::$_tplval['list']['address']; ?></td>
				<td><?php echo Template::$_tplval['list']['logoutime']; ?></td>
			</tr>
			<?php }} unset($_from);?>
		</tbody>
	</table>
</div>