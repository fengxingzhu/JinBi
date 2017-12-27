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
<div class="headDiv">
<?php MFInclude::regincludepage('./','index_head.html'); ?>
</div>

<div class="sideLad">
    <div><a href=""><img src="<?php echo WEB_APP; ?>image/img120.jpg"/></a></div>
    <a href="javascript:;" class="close">关闭</a>
</div>
<div class="sideRad">
    <div><a href=""><img src="<?php echo WEB_APP; ?>image/img120.jpg"/></a></div>
    <a href="javascript:;" class="close">关闭</a>
</div>

<div class="wal">
<!--wal-->
<div class="fl indexPart1">

    <div class="list">
      <ul>
    <?php $_from = TagAttrLoop::emslist('cn_home_banner','id desc','__typeid=228','5','','','','',''); if (!is_array($_from) && !is_object($_from)){ settype($_from, 'array'); }if (count($_from)){foreach($_from as $key=>Template::$_tplval['list']){ ?>
        <li><a href=""><img src="<?php echo WEB_APP; ?><?php echo Template::$_tplval['list']['img_path']; ?>"/></a></li>
    <?php }} unset($_from);?> 
      </ul>
    </div>
    <div class="btnDiv"></div>
    <div id="list" style="display:none;">
      <ul>
        <?php $_from = TagAttrLoop::emslist('cn_home_banner','id desc','__typeid=228','5','','','','',''); if (!is_array($_from) && !is_object($_from)){ settype($_from, 'array'); }if (count($_from)){foreach($_from as $key=>Template::$_tplval['list']){ ?>
        <li><?php echo Template::$_tplval['list']['title']; ?></li>
        <?php }} unset($_from);?>
      </ul>
    </div>

</div>
<script type="text/javascript">
$(".indexPart1").slide({titCell:".btnDiv",mainCell:".list ul",autoPage:true,effect:"leftLoop",autoPlay:true});
$(".indexPart1").find('.btnDiv').find('span').each(function(i){
	$(this).html($(".indexPart1").find('#list').find('li').eq(i).html());
	})
</script>
<div class="fr indexPart2">
  <div class="title"><h1 class="blue">发行公告</h1><a href="">+ 查看更多</a></div>
  <div class="list">
    <ul>
      <li><a href="">曹雪芹诞辰300周年金银纪念币发行公告</a></li>
      <li><a href="">中国人民抗日战争暨世界反法西斯</a></li>
      <li><a href="">上海银行成立20周年熊猫加字金银纪念</a></li>
      <li><a href="">新疆维吾尔自治区成立60周年</a></li>
      <li><a href="">长春电影制片厂成立70周年金银纪念</a></li>
      <li><a href="">西藏自治区成立50周年金银纪念币</a></li>
    </ul>
  </div>
</div>
<div class="h25"></div>
<!-- <div class="pageBox">
<div class="bg">
<div class="indexPart11">
     <div class="fl list">
          <div class="name blue"><img src="image/img25_1.png"/>认购意向</div>
          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <th><div>名称</div></th>
              <th width="65">数量(枚)</th>
              <th width="80">数量(元/枚)</th>
            </tr>
          </table>
          <div class="bd">
          <ul>
            <li>
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
              <tr>
                <td><div><a href="">2015年熊猫金币</a></div></td>
                <td width="65">60</td>
                <td width="80">60</td>
              </tr>
            </table>
            </li>
            <li>
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
              <tr>
                <td><div><a href="">2015年熊猫金币</a></div></td>
                <td width="65">60</td>
                <td width="80">60</td>
              </tr>
            </table>
            </li>
            <li>
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
              <tr>
                <td><div><a href="">2015年熊猫金币</a></div></td>
                <td width="65">60</td>
                <td width="80">60</td>
              </tr>
            </table>
            </li>
            <li>
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
              <tr>
                <td><div><a href="">2015年熊猫金币</a></div></td>
                <td width="65">60</td>
                <td width="80">60</td>
              </tr>
            </table>
            </li>
            <li>
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
              <tr>
                <td><div><a href="">2015年熊猫金币</a></div></td>
                <td width="65">60</td>
                <td width="80">60</td>
              </tr>
            </table>
            </li>
          </ul>
          </div>
     </div>
     <div class="fl list list2">
          <div class="name blue"><img src="image/img25_2.png"/>出售意向</div>
          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <th><div>名称</div></th>
              <th width="65">数量(枚)</th>
              <th width="80">数量(元/枚)</th>
            </tr>
          </table>
          <div class="bd">
          <ul>
            <li>
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
              <tr>
                <td><div><a href="">2015年熊猫金币</a></div></td>
                <td width="65">60</td>
                <td width="80">60</td>
              </tr>
            </table>
            </li>
            <li>
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
              <tr>
                <td><div><a href="">2015年熊猫金币</a></div></td>
                <td width="65">60</td>
                <td width="80">60</td>
              </tr>
            </table>
            </li>
            <li>
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
              <tr>
                <td><div><a href="">2015年熊猫金币</a></div></td>
                <td width="65">60</td>
                <td width="80">60</td>
              </tr>
            </table>
            </li>
            <li>
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
              <tr>
                <td><div><a href="">2015年熊猫金币</a></div></td>
                <td width="65">60</td>
                <td width="80">60</td>
              </tr>
            </table>
            </li>
            <li>
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
              <tr>
                <td><div><a href="">2015年熊猫金币</a></div></td>
                <td width="65">60</td>
                <td width="80">60</td>
              </tr>
            </table>
            </li>
          </ul>
          </div>
     </div>
     <div class="fr list">
          <div class="name blue"><img src="image/img25_3.png"/>成交记录</div>
          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
              <th><div>名称</div></th>
              <th width="65">数量(枚)</th>
              <th width="80">数量(元/枚)</th>
            </tr>
          </table>
          <div class="bd">
          <ul>
            <li>
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
              <tr>
                <td><div><a href="">2015年熊猫金币</a></div></td>
                <td width="65">60</td>
                <td width="80">60</td>
              </tr>
            </table>
            </li>
            <li>
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
              <tr>
                <td><div><a href="">2015年熊猫金币</a></div></td>
                <td width="65">60</td>
                <td width="80">60</td>
              </tr>
            </table>
            </li>
            <li>
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
              <tr>
                <td><div><a href="">2015年熊猫金币</a></div></td>
                <td width="65">60</td>
                <td width="80">60</td>
              </tr>
            </table>
            </li>
            <li>
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
              <tr>
                <td><div><a href="">2015年熊猫金币</a></div></td>
                <td width="65">60</td>
                <td width="80">60</td>
              </tr>
            </table>
            </li>
            <li>
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
              <tr>
                <td><div><a href="">2015年熊猫金币</a></div></td>
                <td width="65">60</td>
                <td width="80">60</td>
              </tr>
            </table>
            </li>
          </ul>
          </div>
     </div>
</div>
</div>
</div> -->
<!--更改内容-->
</div><!--版心结束-->

<div class="indexPart2-1">
  <div class="wal">
        <div class="list-1"> 
        <div class="list-bg"></div>
          <div class="list-title"><span>认购意向</span><a href="" title="">+ 查看更多</a></div>
          <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <thead>
              <tr>
                <th width="398">产品名称</th><th width="140">认购数量(枚)</th><th width="136">买入价格(元/枚)</th><th width="160">历史成交均价(元     /枚)</th><th>历史成交数量(枚)</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>中国熊猫金币发行35周年金银纪念币15克圆形银质纪念币</td><td>10</td><td>330</td><td>320</td><td>50</td>
              </tr>
              <tr>
                <td>中国熊猫金币发行35周年金银纪念币15克圆形银质纪念币</td><td>10</td><td>330</td><td>320</td><td>50</td>
              </tr>
              <tr>
                <td>中国熊猫金币发行35周年金银纪念币15克圆形银质纪念币</td><td>10</td><td>330</td><td>320</td><td>50</td>
              </tr>
            </tbody>
          </table>
          
        </div>
    
      <div class="list-2">  
        <div class="list-bg"></div>
         <div class="list-title"><span>出售意向</span><a href="" title="">+ 查看更多</a></div>
         <table cellpadding="0" cellspacing="0" border="0" width="100%">
           <thead>
             <tr>
               <th width="398">产品名称</th><th width="140">认购数量(枚)</th><th width="136">买入价格(元/枚)</th><th width="160">历史成交均价(元    /枚)</th><th>历史成交数量(枚)</th>
             </tr>
           </thead>
           <tbody>
             <tr>
               <td>中国熊猫金币发行35周年金银纪念币15克圆形银质纪念币</td><td>10</td><td>330</td><td>320</td><td>50</td>
             </tr>
             <tr>
               <td>中国熊猫金币发行35周年金银纪念币15克圆形银质纪念币</td><td>10</td><td>330</td><td>320</td><td>50</td>
             </tr>
             <tr>
               <td>中国熊猫金币发行35周年金银纪念币15克圆形银质纪念币</td><td>10</td><td>330</td><td>320</td><td>50</td>
             </tr>
           </tbody>
         </table>
      </div>
    
      <div class="list-3">  
      <div class="list-bg"></div>
    <div class="list-title"><span>成交记录</span><a href="" title="">+ 查看更多</a></div>
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
      <thead>
        <tr>
          <th width="398">产品名称</th><th width="140">认购数量(枚)</th><th width="136">买入价格(元/枚)</th><th width="160">历史成交均价(元/枚)</th><th>历史成交数量(枚)</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>中国熊猫金币发行35周年金银纪念币15克圆形银质纪念币</td><td>10</td><td>330</td><td>320</td><td>50</td>
        </tr>
        <tr>
          <td>中国熊猫金币发行35周年金银纪念币15克圆形银质纪念币</td><td>10</td><td>330</td><td>320</td><td>50</td>
        </tr>
        <tr>
          <td>中国熊猫金币发行35周年金银纪念币15克圆形银质纪念币</td><td>10</td><td>330</td><td>320</td><td>50</td>
        </tr>
      </tbody>
    </table>
      </div>
  </div>
</div>

<div class="wal"><!--版心开始-->
<!--更改内容结束-->
<div class="h25"></div>
<div class="fl w299">
     <div class="indexPart3">
         <div class="title blue">会员中心</div>
         <ul>
           <li><em>用户名：</em><input type="text" class="input1" /></li>
           <li><em>密　码：</em><input type="password" class="input1" /></li>
           <li><input type="button" class="btn1" value="登  陆" /><input type="button" class="btn1 btn2" value="注  册" /></li>
         </ul>
     </div>
     <div class="indexPart4">
        <ul>
          <li><a href=""><img src="<?php echo WEB_APP; ?>image/nimg25_8.png"/>会员通知</a></li>
          <li><a href=""><img src="<?php echo WEB_APP; ?>image/nimg25_9.png"/>业绩考核</a></li>
          <li><a href=""><img src="<?php echo WEB_APP; ?>image/nimg25_10.png"/>产品发布</a></li>
          <li><a href=""><img src="<?php echo WEB_APP; ?>image/nimg25_11.png"/>交流平台</a></li>
        </ul>
     </div>
     <div class="pageBox">
     <div class="bg">
        <div class="pageTitle"><img src="<?php echo WEB_APP; ?>image/nimg25_4.png"/><h1 class="blue">了解委员会</h1></div>
        <div class="indexPart5">
            <ul>
              <li><div><a href="">委员会简介</a></div></li>
              <li><div><a href="">入会流程</a></div></li>
              <li><div><a href="">组织机构</a></div></li>
              <li><div><a href="">自律公约　</a></div></li>
              <li><div><a href="">领导简介</a></div></li>
              <li><div><a href="">议事规章</a></div></li>
              <li class="li_01"><div><a href="">入会指南　</a></div></li>
              <li class="li_01"><div><a href="">规程规则</a></div></li>
            </ul>
        </div>
     </div>
     </div>
</div>
<div class="fr w679">
     <div class="pageBox">
     <div class="bg">
         <div class="pageTitle"><img src="<?php echo WEB_APP; ?>image/nimg25_3.png"/><h1 class="blue">资讯动态</h1><a href="">+查看更多</a></div>
         <div class="indexPart6">
            <ul>
              <li class="liNow">
                 <div class="box">
                 <div class="imgDiv"><a href=""><img src="<?php echo WEB_APP; ?>image/nimg102_1.jpg"/></a></div>
                 <div class="name"><a href="">2015北京国际钱币博览会精品拍卖会征集公告</a></div>
                 <div class="content">
                     莱比锡位于德国东部的莱比锡盆地中央，在魏塞埃尔斯特河与普莱塞河的交汇处面积141平方公里，人口约60万，是原东德的第二大城市...
                 </div>
                 <div class="time"><div>2014.08</div>31</div>
                 </div>
                 <div class="name2"><a href="">2015北京国际钱币博览会精品拍卖会征集公告</a><em>2016.02.25</em></div>
              </li>
              <li>
                 <div class="box">
                 <div class="imgDiv"><a href=""><img src="<?php echo WEB_APP; ?>image/nimg102_2.jpg"/></a></div>
                 <div class="name"><a href="">关于中国人民抗日战争暨世界反法西斯战争胜利70周年金银纪念</a></div>
                 <div class="content">
                     莱比锡位于德国东部的莱比锡盆地中央，在魏塞埃尔斯特河与普莱塞河的交汇处面积141平方公里，人口约60万，是原东德的第二大城市...
                 </div>
                 <div class="time"><div>2014.08</div>31</div>
                 </div>
                 <div class="name2"><a href="">关于中国人民抗日战争暨世界反法西斯战争胜利70周年金银纪念</a><em>2016.02.25</em></div>
              </li>
              <li>
                 <div class="box">
                 <div class="imgDiv"><a href=""><img src="<?php echo WEB_APP; ?>image/nimg102_3.jpg"/></a></div>
                 <div class="name"><a href="">新兴市场8万亿美元外储蒸发 全球市场将会怎样</a></div>
                 <div class="content">
                     莱比锡位于德国东部的莱比锡盆地中央，在魏塞埃尔斯特河与普莱塞河的交汇处面积141平方公里，人口约60万，是原东德的第二大城市...
                 </div>
                 <div class="time"><div>2014.08</div>31</div>
                 </div>
                 <div class="name2"><a href="">新兴市场8万亿美元外储蒸发 全球市场将会怎样</a><em>2016.02.25</em></div>
              </li>
              <li>
                 <div class="box">
                 <div class="imgDiv"><a href=""><img src="<?php echo WEB_APP; ?>image/nimg102_1.jpg"/></a></div>
                 <div class="name"><a href="">2015北京国际钱币博览会精品拍卖会征集公告</a></div>
                 <div class="content">
                     莱比锡位于德国东部的莱比锡盆地中央，在魏塞埃尔斯特河与普莱塞河的交汇处面积141平方公里，人口约60万，是原东德的第二大城市...
                 </div>
                 <div class="time"><div>2014.08</div>31</div>
                 </div>
                 <div class="name2"><a href="">2015北京国际钱币博览会精品拍卖会征集公告</a><em>2016.02.25</em></div>
              </li>
              <li>
                 <div class="box">
                 <div class="imgDiv"><a href=""><img src="<?php echo WEB_APP; ?>image/nimg102_2.jpg"/></a></div>
                 <div class="name"><a href="">关于中国人民抗日战争暨世界反法西斯战争胜利70周年金银纪念</a></div>
                 <div class="content">
                     莱比锡位于德国东部的莱比锡盆地中央，在魏塞埃尔斯特河与普莱塞河的交汇处面积141平方公里，人口约60万，是原东德的第二大城市...
                 </div>
                 <div class="time"><div>2014.08</div>31</div>
                 </div>
                 <div class="name2"><a href="">关于中国人民抗日战争暨世界反法西斯战争胜利70周年金银纪念</a><em>2016.02.25</em></div>
              </li>
              <li>
                 <div class="box">
                 <div class="imgDiv"><a href=""><img src="<?php echo WEB_APP; ?>image/nimg102_3.jpg"/></a></div>
                 <div class="name"><a href="">新兴市场8万亿美元外储蒸发 全球市场将会怎样</a></div>
                 <div class="content">
                     莱比锡位于德国东部的莱比锡盆地中央，在魏塞埃尔斯特河与普莱塞河的交汇处面积141平方公里，人口约60万，是原东德的第二大城市...
                 </div>
                 <div class="time"><div>2014.08</div>31</div>
                 </div>
                 <div class="name2"><a href="">新兴市场8万亿美元外储蒸发 全球市场将会怎样</a><em>2016.02.25</em></div>
              </li>
            </ul>
         </div>
     </div>
     </div>
     <div class="h25" style="height:18px;"></div>
     <div class="pageBox">
     <div class="bg">
         <div class="pageTitle"><img src="<?php echo WEB_APP; ?>image/nimg25_5.png"/><h1 class="blue">培训学院</h1><a href="">+查看更多</a></div>
         <div class="indexPart7">
              <div class="fl imgDiv"><a href=""><img src="<?php echo WEB_APP; ?>image/nimg134.jpg"/></a></div>
              <div class="fr list">
                <ul>
                  <li><a href="">精美的波兰军舰系列兹罗提纪念</a></li>
                  <li><a href="">精美的波兰军舰系列兹罗提纪念</a></li>
                  <li><a href="">顶级老精稀金币抗跌</a></li>
                  <li><a href="">顶级老精稀金币抗跌</a></li>
                  <li><a href="">金价不稳，金币与金条你该如...</a></li>
                  <li><a href="">金价不稳，金币与金条你该如...</a></li>
                </ul>
              </div>
         </div>
     </div>
     </div>
</div>
<div class="h20"></div>
<?php $_from = TagAttrLoop::emslist('cn_home_ads',' id desc','','4','','','','',''); if (!is_array($_from) && !is_object($_from)){ settype($_from, 'array'); }if (count($_from)){foreach($_from as $key=>Template::$_tplval['list']){ ?>
<div><a href="<?php echo Template::$_tplval['list']['link']; ?>"><img src="<?php echo WEB_APP; ?><?php echo Template::$_tplval['list']['img_path']; ?>"/></a></div>
<?php }} unset($_from);?>
<div class="h20"></div>
<div class="pageBox">
<div class="bg">
     <div class="pageTitle"><img src="<?php echo WEB_APP; ?>image/nimg25_6.png"/><h1 class="blue">会员风采</h1><a href="">+查看更多</a></div>
     <div class="indexPart8">
          <a href="" class="btn">入会指南</a>
          <div class="list listHover">
            <ul>
              <li>
                 <div class="imgDiv"><a href=""><img src="<?php echo WEB_APP; ?>image/nimg171_1.jpg"/></a></div>
                 <div class="name"><a href="">德国发行莱比锡城年纪念银币</a></div>
              </li>
              <li>
                 <div class="imgDiv"><a href=""><img src="<?php echo WEB_APP; ?>image/nimg171_2.jpg"/></a></div>
                 <div class="name"><a href="">德国发行莱比锡城年纪念银币</a></div>
              </li>
              <li>
                 <div class="imgDiv"><a href=""><img src="<?php echo WEB_APP; ?>image/nimg171_3.jpg"/></a></div>
                 <div class="name"><a href="">德国发行莱比锡城年纪念银币</a></div>
              </li>
              <li>
                 <div class="imgDiv"><a href=""><img src="<?php echo WEB_APP; ?>image/nimg171_4.jpg"/></a></div>
                 <div class="name"><a href="">德国发行莱比锡城年纪念银币</a></div>
              </li>
              <li>
                 <div class="imgDiv"><a href=""><img src="<?php echo WEB_APP; ?>image/nimg171_5.jpg"/></a></div>
                 <div class="name"><a href="">德国发行莱比锡城年纪念银币</a></div>
              </li>
            </ul>
          </div>
     </div>
</div>
</div>
<div class="h20"></div>
<div class="pageBox">
<div class="bg">
     <div class="pageTitle"><img src="<?php echo WEB_APP; ?>image/img25.png"/><h1 class="blue">会员产品</h1><a href="">+查看更多</a></div>
     <div class="indexPart8">
          <div class="list listHover">
            <ul>
              <li>
                 <div class="imgDiv"><a href=""><img src="<?php echo WEB_APP; ?>image/nimg171_1.jpg"/></a></div>
                 <div class="name"><a href="">德国发行莱比锡城年纪念银币</a></div>
              </li>
              <li>
                 <div class="imgDiv"><a href=""><img src="<?php echo WEB_APP; ?>image/nimg679_1.jpg"/></a></div>
                 <div class="name"><a href="">德国发行莱比锡城年纪念银币</a></div>
              </li>
              <li>
                 <div class="imgDiv"><a href=""><img src="<?php echo WEB_APP; ?>image/nimg171_4.jpg"/></a></div>
                 <div class="name"><a href="">德国发行莱比锡城年纪念银币</a></div>
              </li>
              <li>
                 <div class="imgDiv"><a href=""><img src="<?php echo WEB_APP; ?>image/nimg171_3.jpg"/></a></div>
                 <div class="name"><a href="">德国发行莱比锡城年纪念银币</a></div>
              </li>
              <li>
                 <div class="imgDiv"><a href=""><img src="<?php echo WEB_APP; ?>image/nimg171_5.jpg"/></a></div>
                 <div class="name"><a href="">德国发行莱比锡城年纪念银币</a></div>
              </li>
            </ul>
          </div>
     </div>
     <script type="text/javascript">
	 $('.indexPart8').each(function(){
		 $(this).slide({mainCell:"ul",autoPlay:true,effect:"leftMarquee",vis:5,interTime:50,trigger:"click"});
		 })
     </script>
</div>
</div>
<div class="h20"></div>
<div class="fl pageBox indexPart9">
<div class="bg">
    <div class="tab">
      <ul>
        <li class="liNow">贵金属行情</li>
        <li>贵金属走势</li>
      </ul>
    </div>
    <div class="tabContentDiv">
         <div class="tabContent">
              <dl>
                <dd class="ddNow">当天</dd>
                <dd>一个月</dd>
                <dd>三个月</dd>
                <dd>一年</dd>
                <dt>伦敦金</dt>
              </dl>
              <div class="imgDiv"><img src="<?php echo WEB_APP; ?>image/nimg272.jpg"/></div>
         </div>
    </div>
</div>
</div>
<div class="fr pageBox indexPart10">
<div class="bg">
    <div class="pageTitle"><img src="<?php echo WEB_APP; ?>image/nimg25_7.png"/><h1>友情链接</h1><a href="">+查看更多</a></div>
    <div class="list">
      <ul>
        <li><a href="">深圳国宝造币有限公司</a></li>
        <li><a href="">加拿大皇家造币厂</a></li>
        <li><a href="">澳大利亚皇家造币厂</a></li>
        <li><a href="">中国麦朵尔艺术俱乐部</a></li>
        <li><a href="">奥地利国家银行造币厂</a></li>
        <li><a href="">深圳国宝造币有限公司</a></li>
        <li><a href="">深圳国宝造币有限公司</a></li>
        <li><a href="">加拿大皇家造币厂</a></li>
        <li><a href="">澳大利亚皇家造币厂</a></li>
        <li><a href="">中国麦朵尔艺术俱乐部</a></li>
        <li><a href="">奥地利国家银行造币厂</a></li>
        <li><a href="">深圳国宝造币有限公司</a></li>
        <li><a href="">深圳国宝造币有限公司</a></li>
        <li><a href="">加拿大皇家造币厂</a></li>
        <li><a href="">澳大利亚皇家造币厂</a></li>
        <li><a href="">中国麦朵尔艺术俱乐部</a></li>
        <li><a href="">奥地利国家银行造币厂</a></li>
        <li><a href="">深圳国宝造币有限公司</a></li>
      </ul>
    </div>
</div>
</div>
<div class="h20"></div>
<!--walEnd-->
</div>

<?php MFInclude::regincludepage('./','index_foot.html'); ?>
</body>
</html>
