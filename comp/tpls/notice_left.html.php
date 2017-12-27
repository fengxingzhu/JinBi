<?php if(!defined('WEB_ROOT')) exit();?><ul>
	<li><a href="<?php echo WEB_APP; ?>notice.html" <?php if($_GET['PARENT_TPL_FILE']=="notice.html" || $_GET['PARENT_TPL_FILE']=="newShow.html"){ ?>  class="aNow" <?php } ?> >发行公告</a></li>
	<li><a href="<?php echo WEB_APP; ?>news.html" <?php if($_GET['PARENT_TPL_FILE']=="news.html" ){ ?>  class="aNow" <?php } ?> >工作动态</a></li>
	<li><a href="<?php echo WEB_APP; ?>news3.html" <?php if($_GET['PARENT_TPL_FILE']=="news3.html" ){ ?>  class="aNow" <?php } ?> >会员动态</a></li>
	<li><a href="<?php echo WEB_APP; ?>news4.html" <?php if($_GET['PARENT_TPL_FILE']=="news4.html" ){ ?>  class="aNow" <?php } ?> >市场动态</a></li>
</ul>