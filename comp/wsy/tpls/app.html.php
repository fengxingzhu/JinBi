<?php if(!defined('WEB_ROOT')) exit();?><!DOCTYPE html>
<html style="height:100%;">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
		<meta name="viewport" content="minimal-ui, width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
		<meta content="black"name="apple-mobile-web-app-status-bar-style"/>
		<?php $_from = TagAttrLoop::emslist('wqj_wqj_list','__handsort desc,id desc','__typeid=207','1','','','','',''); if (!is_array($_from) && !is_object($_from)){ settype($_from, 'array'); }if (count($_from)){foreach($_from as $key=>Template::$_tplval['list']){ ?>
		<?php if($_GET['tp']==""){$_GET['tp']=Template::$_tplval['list']['id'];} ?>
		<?php }} unset($_from);?>
		<?php Template::$_tplval['info'] = TagAttrLoop::emsdeital('wqj_wqj_list','id',''.urldecode($_GET["tp"]).'','','','','','','',''); ?>
		<title><?php echo Template::$_tplval['info']['title1']; ?></title>
		<meta name="Keywords" content="<?php echo Template::$_tplval['info']['keywords']; ?>"/>
		<meta name="Description" content="<?php echo Template::$_tplval['info']['description']; ?>" />

		<link rel="stylesheet" href="css/main.css" />
		<script type="text/javascript" src="js/jquery-2.1.0.min.js"></script>
		<script type="text/javascript" src="js/jquery.queryloader2.js"></script>
		<script type="text/javascript" src="js/jquery.touchwipe.1.1.1.js"></script>
		<script type="text/javascript" src="js/function.js"></script>
		<script>
			//android系统上为html添加class：devic-android
			var classNames = [];
			if (navigator.userAgent.match(/android/i)) classNames.push('device-android');
			var html = document.getElementsByTagName('html')[0];
			if (html.classList) html.classList.add.apply(html.classList, classNames);
			
			//加载动画
			jQuery.noConflict();
			(function($) {
				$(document).ready(function () {
				    $("body").queryLoader2({
				    	backgroundColor: '#FFFFFF',
				    	barColor: '#CC0000',
				    	barHeight: 3
				    });
				});
			})(jQuery);
		</script>
	</head>
	<body style="margin:0;padding:0;height:100%; overflow: hidden;">
		<div id="stage">
			<!--
			<div id="scene-5" class="responsive scene">
							<h1 class="label">鑱旂郴鏂瑰紡</h1>
						</div>-->
			
			
			<div id="scene-2" class="responsive scene">
				<h1 class="label">会议安排</h1>
				<table class="schedule">
					<tr>
						<?php $_from = TagAttrLoop::emslist('wqj_meeting','__handsort asc,id desc','class_type_key='.urldecode($_GET["tp"]).'','100','','','','',''); if (!is_array($_from) && !is_object($_from)){ settype($_from, 'array'); }if (count($_from)){foreach($_from as $key=>Template::$_tplval['list']){ ?>
						<td><h2> <?php echo Template::$_tplval['list']['title']; ?> </h2>
						<p>
							<?php echo Template::$_tplval['list']['time']; ?>
							<br/>
							<?php echo Template::$_tplval['list']['content']; ?>
						</p></td>
						<?php }} unset($_from);?>
					</tr>
				</table>
				<div class="center sign-up">
					<button id="sign-up" class="btn-sign"></button>
				</div>
				<?php 
				function getyy($t){
					if(!empty($t)){
						$a = strtotime($t);
						return date('Y年m月d日',$a);
					}
				}
				function getdateF($t){
					if(!empty($t)){
						$a = strtotime($t);
						return date('F-d',$a);
					}
				}				
				 ?>				
				<div class=""  style="position: absolute; bottom: 0px; width: 100%; height: 50%;">
					<table class="meeting-info" style="z-index: 100">
											<tbody>
							<tr>
								<td rowspan="3">
									<div class="meeting-calendar">
										<?php $fdate=getdateF(Template::$_tplval['info']['cdate']);$fdate_arr=explode("-",$fdate); ?>
										<span><?php echo $fdate_arr[0]; ?></span>
										<strong><?php echo $fdate_arr[1]; ?></strong>
									</div>
								</td>
								<td>
									<div class="icon">
										<img src="images/icon_01.png" style="width: 18px;" />
									</div>
								</td>
								<td class="meeting-item"><p><?php echo getyy(Template::$_tplval['info']['cdate']); ?>  <?php echo Template::$_tplval['info']['time']; ?></p></td>
							</tr>
							<tr>
								<td>
									<div class="icon">
										<img src="images/icon_02.png"  style="width: 18px;" />
									</div>
								</td>
								<td class="meeting-item"><p><?php echo Template::$_tplval['info']['scale']; ?></p></td>
							</tr>
							<tr>
								<td>
									<div class="icon">
										<img src="images/icon_03.png"  style="width: 18px;" />
									</div>
								</td>
								<td class="meeting-item"><p><?php echo Template::$_tplval['info']['address']; ?></p></td>
							</tr>
						</tbody>
					</table>
					<div class="map" id="map" style="width: 100%; max-height: 10%;z-index: 100">
						<img src="<?php echo WEB_APP; ?><?php echo Template::$_tplval['info']['map_path']; ?>" alt="地图" style="width: 100%;" />
							<!--
							<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></script>
													<script type="text/javascript"> 
													var map = new BMap.Map("map"); 
													var point = new BMap.Point(116.404, 39.915); 
													map.centerAndZoom(point, 15); -->
							
					</script>
					</div>
				</div>
				<div class="adv">
					<div class="nav-bar">
						<img class="logo-2" src="<?php echo WEB_APP; ?><?php echo Template::$_tplval['info']['logo2_path']; ?>" width="91" />
					</div>
					<div class="slider">
						<table class="adv-list">
							<tbody>
								<tr>
									<?php $_from = TagAttrLoop::emslist('wqj_images','__handsort asc,id desc','class_type_key='.urldecode($_GET["tp"]).'','100','','','','',''); if (!is_array($_from) && !is_object($_from)){ settype($_from, 'array'); }if (count($_from)){foreach($_from as $key=>Template::$_tplval['list']){ ?>
									<td>
										<div class="adv-item">
											<img src="<?php echo WEB_APP; ?><?php echo Template::$_tplval['list']['img_path']; ?>" class="responsive-x adv-img"/>
											<h3><?php echo Template::$_tplval['list']['title1']; ?></h3>
											<h2><?php echo Template::$_tplval['list']['title2']; ?></h2>
										</div>
									</td>
									<?php }} unset($_from);?>
								</tr>
							</tbody>
						</table>
						<div class="row">
							<div class="col-50 prev">
								<span>&lt;</span>
							</div>
							<div class="col-50 next active">
								<span>&gt;</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="scene-3" class="responsive scene">
				<h1 class="label">嘉宾介绍</h1>
				<div class="row responsive view horview" id="guest-list1">					
					<div class="col-50 left-col responsive-y">
						<ul class="ver-center">
							<?php $_from = TagAttrLoop::emslist('wqj_guest','__handsort asc,id desc','class_type_key='.urldecode($_GET["tp"]).' AND isleft_key=1','','','','0,4','',''); if (!is_array($_from) && !is_object($_from)){ settype($_from, 'array'); }if (count($_from)){foreach($_from as $key=>Template::$_tplval['list']){ ?>
							<li>
								<div class="avatar-box"><img src="<?php echo WEB_APP; ?><?php echo Template::$_tplval['list']['img_path']; ?>" width="80" class=" avatar" data-target="#guest-info-<?php echo Template::$_tplval['list']['id']; ?>"/><p <?php if($key%2==0){ ?>style="background-color: rgba(254, 163, 171, 0.75);"<?php }else{ ?>style="background-color: rgba(181, 215, 133, 0.75);"<?php } ?>><?php echo Template::$_tplval['list']['title']; ?></p></div>							
							</li>
							<?php }} unset($_from);?>							
						</ul>
					</div>					
					<div class="col-50 right-col responsive-y">
						<ul class="ver-center">
							<?php $_from = TagAttrLoop::emslist('wqj_guest','__handsort asc,id desc','class_type_key='.urldecode($_GET["tp"]).' AND isleft_key=0','','','','0,3','',''); if (!is_array($_from) && !is_object($_from)){ settype($_from, 'array'); }if (count($_from)){foreach($_from as $key=>Template::$_tplval['list']){ ?>
							<li>
								<div class="avatar-box"><img src="<?php echo WEB_APP; ?><?php echo Template::$_tplval['list']['img_path']; ?>"  width="80" class=" avatar"  data-target="#guest-info-<?php echo Template::$_tplval['list']['id']; ?>"/><p <?php if($key%2==0){ ?>style="background-color: rgba(254, 163, 171, 0.75);"<?php }else{ ?>style="background-color: rgba(181, 215, 133, 0.75);"<?php } ?>><?php echo Template::$_tplval['list']['title']; ?></p></div>						
							</li>
							<?php }} unset($_from);?>							
						</ul>
					</div>
				</div>
				<div class="row responsive view horview" id="guest-list2">
					<div class="col-50 left-col responsive-y">
						<ul class="ver-center">
							<?php $_from = TagAttrLoop::emslist('wqj_guest','__handsort asc,id desc','class_type_key='.urldecode($_GET["tp"]).' AND isleft_key=1','','','','4,4','',''); if (!is_array($_from) && !is_object($_from)){ settype($_from, 'array'); }if (count($_from)){foreach($_from as $key=>Template::$_tplval['list']){ ?>
							<li>
								<div class="avatar-box"><img src="<?php echo WEB_APP; ?><?php echo Template::$_tplval['list']['img_path']; ?>"  width="80" class=" avatar"  data-target="#guest-info-<?php echo Template::$_tplval['list']['id']; ?>"/><p <?php if($key%2==0){ ?>style="background-color: rgba(254, 163, 171, 0.75);"<?php }else{ ?>style="background-color: rgba(181, 215, 133, 0.75);"<?php } ?>><?php echo Template::$_tplval['list']['title']; ?></p></div>
							</li>
							<?php }} unset($_from);?>							
						</ul>
					</div>
					<div class="col-50 right-col responsive-y">
						<ul class="ver-center">
							<?php $_from = TagAttrLoop::emslist('wqj_guest','__handsort asc,id desc','class_type_key='.urldecode($_GET["tp"]).' AND isleft_key=0','','','','3,3','',''); if (!is_array($_from) && !is_object($_from)){ settype($_from, 'array'); }if (count($_from)){foreach($_from as $key=>Template::$_tplval['list']){ ?>
							<li>
								<div class="avatar-box"><img src="<?php echo WEB_APP; ?><?php echo Template::$_tplval['list']['img_path']; ?>"  width="80" class=" avatar"  data-target="#guest-info-<?php echo Template::$_tplval['list']['id']; ?>"/><p <?php if($key%2==0){ ?>style="background-color: rgba(254, 163, 171, 0.75);"<?php }else{ ?>style="background-color: rgba(181, 215, 133, 0.75);"<?php } ?>><?php echo Template::$_tplval['list']['title']; ?></p></div>
							</li>
							<?php }} unset($_from);?>
						</ul>
					</div>
				</div>
				<div class="guest-info-wrap responsive" style="position: absolute;">
					<?php $_from = TagAttrLoop::emslist('wqj_guest','__handsort asc,id desc','class_type_key='.urldecode($_GET["tp"]).'','600','','','','',''); if (!is_array($_from) && !is_object($_from)){ settype($_from, 'array'); }if (count($_from)){foreach($_from as $key=>Template::$_tplval['list']){ ?>
					<div class="guest-info hide" id="guest-info-<?php echo Template::$_tplval['list']['id']; ?>">
						<i style="left:-15px;top:-15px;z-index:1000;"><img src="images/icon_04.png" /></i>
						<div class="img-crop">
							<img src="<?php echo WEB_APP; ?><?php echo Template::$_tplval['list']['imgbig_path']; ?>" width="265" style="max-width: 100%;"/>
						</div>
						<dl>
							<dt><?php echo Template::$_tplval['list']['title']; ?></dt>
							<dd>
								<?php echo Template::$_tplval['list']['content']; ?>
							</dd>
						</dl>
					</div>
					<?php }} unset($_from);?>
				</div>
			</div>
			
			<div id="scene-1" class="responsive scene ">
			
				<img class="bg"  src="<?php echo WEB_APP; ?><?php echo Template::$_tplval['info']['img2_path']; ?>">
				<h1 class="label">会议介绍</h1>
				<div class="center photo-intro">
					<img src="<?php echo WEB_APP; ?><?php echo Template::$_tplval['info']['intro_img_path']; ?>"  alt="会议地点" style="width: 80%" />
				</div>
				<p class="text-intro">
					<?php echo str_replace(array('<p>','</p>'), '', Template::$_tplval['info']['intro_content']); ?>
				</p>
			</div>
			<style>
				#cover .logo{
	position: absolute;
	top: -27%;
	z-index: 2;
	background: transparent url("<?php echo WEB_APP; ?><?php echo Template::$_tplval['info']['logo_path']; ?>") no-repeat center center;
	background-size: 25% auto;
}
				</style>
			<div id="cover" class="responsive scene current">
				<img class="bg" src="<?php echo WEB_APP; ?><?php echo Template::$_tplval['info']['img1_path']; ?>">
				<div class="logo responsive" ></div>
				<div class="rotation-ring responsive"></div>
				<div class="touch-guide">
					<div class="arrow-top">
					</div>
					<p>向上滑动</p>
				</div>
			</div>
			<div class="dialog-modal"  id="sign-up-dialog">
				<div class="dialog">
					<div class="close" style="text-align: right;">
						<i><img src="images/icon_04.png" width="22"/></i>
					</div>
					<form name="form1"  id="form1" method="post" action="do/?Email-email" onSubmit="return Validator.Validate(this,2)">
						<div class="control-group">
							<label>姓名<span class="required">*</span></label>
							<input name="name" class="form-control" type="text" dataType="Require" msg="姓名不能为空" />
						</div>
						<div class="control-group">
							<label>邮箱<span class="required">*</span></label>
							<input name="email" class="form-control" type="text" dataType="Email" msg="邮箱不能为空或者邮箱不正确" />
						</div>
						<div class="control-group">
							<label>手机<span class="required">*</span></label>
							<input name="phone" class="form-control" type="text" dataType="Mobile" msg="手机不能为空或者手机号码不正确" />
						</div>
						<div class="control-group">
							<label>公司<span class="required">*</span></label>
							<input name="company" class="form-control" type="text" dataType="Require" msg="公司不能为空" />
						</div>
						<div class="control-group">
							<label>职位<span class="required">*</span></label>
							<input name="position" class="form-control" type="text" dataType="Require" msg="职位不能为空" />
						</div>
						<input name="tb" type="hidden" value="wqj_registration" />
						<input name="__typeid" type="hidden" value="209" />
						<input name="class_type_key" type="hidden" value="<?php echo $_GET['tp']; ?>">						
						<div class="control-group">
							<button type="submit" class="btn">确 定</button>
						</div>
					</form>
				</div>
			</div>
			<div class="arrow-down"></div>
			<div class="arrow-up"></div>
		</div>
	</body>
</html>