<?php if(!defined('WEB_ROOT')) exit();?><ul>
    <li><a href="<?php echo WEB_APP; ?>guide.html" <?php if($_GET['PARENT_TPL_FILE']=="guide.html" ){ ?>  class="aNow" <?php } ?> >入会指南</a></li>
    <li><a href="<?php echo WEB_APP; ?>process.html" <?php if($_GET['PARENT_TPL_FILE']=="process.html" ){ ?>  class="aNow" <?php } ?> >入会流程</a></li>
    <li><a href="<?php echo WEB_APP; ?>Convention.html" <?php if($_GET['PARENT_TPL_FILE']=="Convention.html" ){ ?>  class="aNow" <?php } ?> >自律公约</a></li>
    <li><a href="<?php echo WEB_APP; ?>Convention2.html" <?php if($_GET['PARENT_TPL_FILE']=="Convention2.html" ){ ?>  class="aNow" <?php } ?> >议事规程</a></li>
    <li><a href="<?php echo WEB_APP; ?>Convention3.html" <?php if($_GET['PARENT_TPL_FILE']=="Convention3.html" ){ ?>  class="aNow" <?php } ?> >管理规则</a></li>
</ul>