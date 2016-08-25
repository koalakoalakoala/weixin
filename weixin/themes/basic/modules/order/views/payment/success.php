<?php
use yii\helpers\Url;
$this->title = '支付成功';
?>
<!-- 内页统一头部 E-->
<!--支付成功内容 S-->
    <div class="paysuc-content">
    	<div class="paysuc-content-img">
    		<img src="/img/pay-success.png">
    	</div>
		<div class="goshop-content-txt paysuc-content-txt">
			<p class="f18">恭喜您，支付成功！</p>
			<p class="f18">您已成功兑换商品，<span class="w4db">花费 <span class="fw-b">960000</span> 消费券</span><p class="f14 mt10">我们将尽快发货！</p></p>
		</div>
  </div>
<!--支付成功内容 E-->

<!--支付成功按钮 S-->
  <div class="tjdd-btn">
	  <div class="in-paysuc-btn clearfix">
		<div class="paysuc-btn-box"><div class="in-paysuc-btn-box"><a href="<?=Url::to(['/member/order/index'])?>" class="fr b-btn-bg">查看我的订单</a></div></div>
		<div class="paysuc-btn-box"><div class="in-paysuc-btn-box"><a href="<?=Url::to(['/home/home/index'])?>" class="fr ">继续购物</a></div></div>
	 </div>
	 <div class="in-paysuc-btn clearfix">
		<div class="in-paysuc-btn-box"><a href="<?=Url::to(['/home/home/index'])?>" class="fr ">继续购物</a></div>
	 </div>
</div>

<!--支付成功按钮 E-->
<script type="text/javascript">
	$(function(){
		$(window).load(function(){
			if($(this).width()<400){
				$('.w4db').css({'display':'block','text-align':'center'});
			}
		});
	})
</script>