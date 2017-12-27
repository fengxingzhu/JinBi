<?php if(!defined('WEB_ROOT')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EDGE">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>金币市场专业委员会</title>
<link href="<?php echo WEB_APP; ?>style/main.css" rel="stylesheet" type="text/css" />
<link href="<?php echo WEB_APP; ?>style/index.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?php echo WEB_APP; ?>script/jquery-1.7.1.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo WEB_APP; ?>script/easing.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo WEB_APP; ?>script/js.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo WEB_APP; ?>script/fun.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo WEB_APP; ?>script/form.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo WEB_APP; ?>script/jquery.SuperSlide.2.1.1.js"></script>
<!--[if lte IE 6]>
<script src="script/png.js" type="text/javascript"></script>
    <script type="text/javascript">
        DD_belatedPNG.fix('div, ul, img, li, input , a');
    </script>
<![endif]--> 
</head>

<body>
<div class="headDiv headDiv2">
<?php MFInclude::regincludepage('./','index_head.html'); ?>
</div>

<div class="memberBg">
<div class="wal">
<!--wal-->
<div class="memberTitle">
    <h1><img src="<?php echo WEB_APP; ?>image/title.png"/></h1>
    <div class="fl msg">张先生， 编号（2001）您好，欢迎登录会员系统登录时间：<?php echo date('Y-m-d H:i:s');?></div>
</div>
<div class="fl w249 memberNav">
    <div class="imgDiv"><img src="<?php echo WEB_APP; ?>image/nimg197.jpg"/></div>
    <h2>会员通知</h2>
    <div class="list">
      <ul>
        <li><a href="">会员通知</a></li>
      </ul>
    </div>
    <h2>会员动态</h2>
    <div class="list">
      <ul>
        <li><a href="">新闻发布</a></li>
        <li><a href="">新闻管理</a></li>
      </ul>
    </div>
    <h2 class="h2Now">余缺调剂</h2>
    <div class="list" style="display:block;">
      <ul>
        <li><a href="" class="aNow">我要求购</a></li>
        <li><a href="">我要出售</a></li>
        <li><a href="">我的供求列表</a></li>
      </ul>
    </div>
    <h2>新闻资讯</h2>
    <div class="list">
      <ul>
        <li><a href="">新闻资讯</a></li>
      </ul>
    </div>
    <h2>业绩提交</h2>
    <div class="list">
      <ul>
        <li><a href="">业绩考核说明</a></li>
        <li><a href="">历史业绩查询</a></li>
      </ul>
    </div>
    <h2>我的产品</h2>
    <div class="list">
      <ul>
        <li><a href="">产品发布</a></li>
        <li><a href="">产品管理</a></li>
      </ul>
    </div>
    <h2>交流平台</h2>
    <div class="list">
      <ul>
        <li><a href="">发布留言</a></li>
        <li><a href="">交流平台</a></li>
        <li><a href="">我的留言</a></li>
      </ul>
    </div>
    <h2>用户设置</h2>
    <div class="list">
      <ul>
        <li><a href="">修改信息</a></li>
        <li><a href="">修改用户密码</a></li>
      </ul>
    </div>
    <h2>常见问题</h2>
    <div class="list">
      <ul>
        <li><a href="">常见问题</a></li>
      </ul>
    </div>
</div>
<div class="fr w722">
    <!--内容-->
    <form method="post" action="do/?Fun-add.html" onSubmit="return Validator.Validate(this,2)">
    <div class="newsForm newsForm2">
       <ul>
          <li><em>求购产品年限：</em>
              <input name="nian" type="text" class="input1 input_hover" value=""  />
          </li>
          <li><em>求购产品项目：</em>
              <input name="project" type="text" class="input1 input_hover" value=""  />
          </li>
          <li><em>求购产品名称：</em>
              <input name="title" type="text" class="input1 input_hover" value=""  />
          </li>
          <li><em>求购产品数量：</em>
             <input name="num" type="text" class="input1" />
             <div class="tips">个</div>
          </li>
          <li><em>求购产品单价：</em>
             <input name="price" type="text" class="input1 input2" />
             <div class="tips">元（人民币）/枚</div>
             <div class="tips"><a href="#" class="blue">参考价格</a></div>
          </li>
          <li><em>手续费：</em>
             <input name="poundage" type="text" class="input1 input2 input_hover" value="当前默认值为0" title="当前默认值为0" />
             <div class="tips">元</div>
          </li>
          <li><em>联系人：</em>
             <input name="name" type="text" class="input1 input_hover" value="默认上次输入的联系人" title="默认上次输入的联系人" />
          </li>
          <li><em>联系方式：</em>
             <input name="tel" type="text" class="input1 input_hover" value="默认上次输入的手机号" title="默认上次输入的手机号" />
          </li>
          <li class="li_01"><em>备注说明：</em>
             <textarea name="instructions" cols="" rows=""></textarea>
          </li>
          <li>
            <input type="hidden" name="pubdate" value="<?php echo date('Y-m-d H:i:s'); ?>"/>
            <input type="hidden" name="user" value="张三"/>
            <input type="hidden" name="jumpurl" value="<?php echo WEB_APP; ?>?yqtjBuy.html"/> 
            <input type="submit" name="submit" class="btn1" value="确认提交" />
          </li>
       </ul>
    </div>
    </form>
    <!--内容End-->
</div>
<div class="h50"></div>
<!--walEnd-->
</div>
</div>

<div class="PerformanceFormLayer">
    <div class="box">
       <div class="msg">恭喜您提交成功</div>
       <div class="btn"><a href="">继续提交</a><a href="">查看历史</a></div>
    </div>
    <div class="btnDiv"><a href="">提 交</a></div>
</div>

<?php MFInclude::regincludepage('./','index_foot.html'); ?>
</body>
</html>