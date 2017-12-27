<?php if(!defined('WEB_ROOT')) exit();?><ul>
  <li><a href="<?php echo WEB_APP; ?>about.html" <?php if($_GET['PARENT_TPL_FILE']=="about.html" ){ ?>  class="aNow" <?php } ?> >委员会简介</a></li>
  <li><a href="<?php echo WEB_APP; ?>group.html" <?php if($_GET['PARENT_TPL_FILE']=="group.html" ){ ?>  class="aNow" <?php } ?> >委员会构架</a></li>
  <li><a href="<?php echo WEB_APP; ?>Leader.html" <?php if($_GET['PARENT_TPL_FILE']=="Leader.html" || $_GET['PARENT_TPL_FILE']=="Leader2.html" || $_GET['PARENT_TPL_FILE']=="Leader3.html" || $_GET['PARENT_TPL_FILE']=="Leader4.html"){ ?>  class="aNow" <?php } ?> >领导简介</a></li>
</ul>