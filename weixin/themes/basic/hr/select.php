<?php
use yii\helpers\Url;
$this->title="华融支付";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="user-scalable=no,width=device-width,initial-scale=1" /><!--设置viewport，适应移动设备的显示宽度-->
        <meta name="apple-mobile-web-app-capable" content="yes" /><!--隐藏safari导航栏及工具栏-->
        <meta name="format-detection" content="telephone=no" /><!--禁止safari电话默认拨打-->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><!--所有浏览器都以最新模式显示-->
        <title>我的资料</title>
        <link href="css/comm.css" rel="stylesheet" type="text/css" />
        <link href="css/wcomm.css" rel="stylesheet" type="text/css" />
        <link href="css/wglobal.css" rel="stylesheet" type="text/css" />
        <link href="css/css2.css" rel="stylesheet" type="text/css" />
        <script src='js/jquery-1.9.1.min.js' type="text/javascript"></script>
        <script src='js/common.js' type="text/javascript"></script>
    </head>
    <body>
        <div class="mod_container">
        <div class="container-wraper-bg">
            <!--data-top 头部信息 S-->
            <div class="my-data-top bb bt mt10">
                 <div class="hr-paytop clearfix">
                    <span class="fl">支付金额</span>
                    <span class="amount fr">￥<?=$order->price?></span>
                 </div>
            </div>
            <!--头部信息 E-->
            <!-- data-content 我的资料内容 S-->
            <div class="my-grade-content">
                <div class="hr-paytit">服务由华融支付提供</div>
                <div class="hr-paycont bt">
                    <a href="<?=Url::to(['/hr/bc-pay', 'order_id'=>$order->id])?>">储蓄卡支付 <span class="jt"></span></a>
                    <a href="<?=Url::to(['/hr/cc-pay', 'order_id'=>$order->id])?>">信用卡支付 <span class="jt"></span></a>
                </div>
            </div>
            <!-- data-content 我的资料内容 E--> 
    </div>           
  </div>    
    </body>
</html>
