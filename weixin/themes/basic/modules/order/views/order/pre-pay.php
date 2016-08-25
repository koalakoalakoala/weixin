<?php
use yii\helpers\Url;
?>
<!--ddzf 顶部信息 S-->
<div class=" ddzf-top">
	<div class="intjdd-top inddzf-top">
		<div class="dm-icon ddzf-top-icon">
		</div>
		<div class="tjdd-top-info ddzf-top-info">
			<div class="clearfix f18">成功下单</div>
			<div class="f14 cl">您的订单已生成，请在24小时内完成支付，否则订单将会被自动取消</div>
		</div>
	</div>
</div>
<!--顶部信息 E-->
<!-- ddzf-content 提交订单中部内容 S-->
<div class="phone-shopbox ddzf-center">
	<div class="ddzf-center-top">
	     您还有 <span class="r-fc"> <?=count($orders)?> </span> 个订单等待支付
	</div>
	<?php foreach($orders as $k => $v){ ?>
		<div class="ddzf-center-container">
			<div class="shop-title cleafix tjdd-center-title ddzf-center-title">
				<?php if(isset($v['store']) && $v['store']->store_logo){ ?> <img src="<?=Yii::$app->params['img_domain'].$v['store']->store_logo?>" style="width:25px;height:25px;" /> <?php } ?> <?=$v->supplier ? '<span class="dm-icon my-index-icon dm-title-icon"></span>' : ''?>
				<span><?=$v->store ? $v->store->store_name : ($v->supplier ? " 中盾自营，[".$v->supplier->name."]供货" : "")?> </span>
				<a href="<?= $v->store ? Url::to(['/store/store/view?id='.$v->store->id]) : "#" ?>" class="shop-jt"><span class="jt right"></span></a>
			</div>
			<div class=" tjdd-center-content">
				<div class="home-tuan-lists iobrv intjdd-center-content inddzf-center-content">

		             <div class="yf-list-line clearfix">
						<div class="fl">订单编号：<span><?=$v->sn?></span></div>
						<?php
						$number = 0;
						foreach($v->ordergoods as $k1 => $v1){
							$number += $v1->number;
						}?>
						<div class="fr"><span class="r-fc"><?=$number?></span> 件商品</div>
					</div>
					<div class="count-list-line clearfix">
						待付：<span class="fw-b">¥<?=$v->price?></span>
					</div>
					<div class="btn-lie ddzf-btn">
						<a href="<?=Url::to(['payment/index?order_id='.$v->id])?>" class="fr">立即支付</a>
					</div>
		       </div>
		    </div>
		 </div>
	 <?php } ?>

	<!-- ddzf-content 提交订单中部内容 E-->
	</div>




















<!-- <a href="" class="fr">立即支付</a> -->