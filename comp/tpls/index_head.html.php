<?php if(!defined('WEB_ROOT')) exit();?><div class="wal">
    <a href="<?php echo WEB_APP; ?>app.html" class="logo"><img src="<?php echo WEB_APP; ?>image/logo.png"/></a>
    <div class="topBtn">
        <ul>
          <li><a href="">登陆 / 注册</a></li>
          <li><a href="">企业邮箱登录</a></li>
          <li><a href="">举报入口</a></li>
          <li class="li_01"><div>选择语言</div>
             <dl>
               <dd><a href="">中文</a></dd>
               <dd><a href="">Englisth</a></dd>
             </dl>
          </li>
        </ul>
    </div>
    <div class="nav">
      <ul>
        <li><a href="<?php echo WEB_APP; ?>app.html">首页</a></li>

        <li><a href="<?php echo WEB_APP; ?>about.html" <?php if($_GET['PARENT_TPL_FILE']=="about.html" || $_GET['PARENT_TPL_FILE']=="group.html" || $_GET['PARENT_TPL_FILE']=="Leader.html" || $_GET['PARENT_TPL_FILE']=="Leader2.html" || $_GET['PARENT_TPL_FILE']=="Leader3.html" || $_GET['PARENT_TPL_FILE']=="Leader4.html" ){ ?>  class="aNow" <?php } ?> 
        >关于我们</a></li>

        <li><a href="<?php echo WEB_APP; ?>notice.html" <?php if($_GET['PARENT_TPL_FILE']=="notice.html" || $_GET['PARENT_TPL_FILE']=="news.html" || $_GET['PARENT_TPL_FILE']=="news3.html" || $_GET['PARENT_TPL_FILE']=="news4.html" || $_GET['PARENT_TPL_FILE']=="newShow.html"){ ?>  class="aNow" <?php } ?> 
        >行业动态</a></li>
        
        <li><a href="<?php echo WEB_APP; ?>guide.html" <?php if($_GET['PARENT_TPL_FILE']=="guide.html" || $_GET['PARENT_TPL_FILE']=="process.html" || $_GET['PARENT_TPL_FILE']=="process.html" || $_GET['PARENT_TPL_FILE']=="Convention.html" || $_GET['PARENT_TPL_FILE']=="Convention2.html" || $_GET['PARENT_TPL_FILE']=="Convention3.html"){ ?>  class="aNow" <?php } ?> 
        >规章制度</a></li>

        <li><a href="<?php echo WEB_APP; ?>member.html">会员风采</a></li>
        <li><a href="">会员服务</a></li>
        <li><a href="">培训学院</a></li>
        <li><a href="">联系我们</a></li>
      </ul>
    </div>
</div>