<?php
use yii\helpers\Url;
use common\enum\OrderEnum;
use common\enum\StoreEnum;
use common\enum\LevelEnum;

$this->title = Yii::t('app_member', 'my_center');
$this->params['breadcrumbs'][] = $this->title;

$dir = Yii::getAlias('@webroot');
?>
<div class="my-index-top">
<!--<img class="zd-toppic" src="/img/log.png">-->
<div class="zdt-top dm-top-bg">
	<?php if(!empty($model->member_info->avatar)){?>
		<img src="<?= $model->member_info->avatar?>"/>
	<?php }else{?>
		<img src="/img/wo.png"/>
	<?php }?>
	<div class="tjdd-top-info info">
		<!--<span class="jt right my-index-jt"></span>-->
		<?php if (!Yii::$app->user->isGuest) { ?>
			<div class="zd-f16"><?=$model['username']?></div>
		<?php } else { ?>
			<div class="zd-f16"><a href="<?=Url::to(['/member/member/login'])?>"><span>登录</span></a><i class="make-wrap-before"></i><a href="<?=Url::to(['/member/member/register'])?>"><span>注册</span></a></div>
		<?php } ?>
		<!--<div class="f12 stute"><span><?/*=$model->levels->name*/?></span>-->
        <?php /*if($model->store_id>0){*/?><!--
            <?php /*if($store->ischeck==StoreEnum::STORE_OK){*/?>
		         <span class="ml"><?/*=yii::t('app_member','has_store')*/?></span>
		     <?php /*}elseif($store->ischeck==1){*/?>
		         <span class="ml">审核通过</span>
		     <?php /*}elseif($store->ischeck==2){*/?>
		     	 <span class="ml">拒绝</span>
		     <?php /*}elseif($store->ischeck==4){*/?>
		     	 <span class="ml">已关闭</span>
		     <?php /*}*/?>

		<?php /*}else{*/?>
				<span class="m1">未开店</span>
		<?php /*}*/?>
		</div>-->
	</div>
	</div>
	<ul class="dm-top-menu">
		<!--<li><a href="<?=Url::toRoute('balance/index')?>">零钱<br/>￥<?=$moneyModel->money?></a></li>
		<li><a href="<?=Url::to(['frozen/index'])?>">冻结<br/>￥<?=$moneyModel->fronze_money?></a></li>-->
		<!--<li><a href="<?/*=Url::toRoute('cashmoney/index')*/?>"><?/*=$moneyModel->attributeLabels()['cash_money']*/?><br/>￥<?/*=$moneyModel->cash_money*/?></a></li>-->
	</ul>
</div>
<!--<div class="member-listers">
	<a href="/member/moneycash/create" class="list">
		<span class="dm-icon my-index-icon my-index-icon11"></span>
		<span>提现</span>
		<span class="jt dm-list-right"></span>
	</a>
</div>-->
<!--my-index-top 个人中心头部 (背景)E-->

<!-- my-index-bottom 个人中心下部内容 S-->
<div class="my-index-bottom">
	<!--  免运费的模块 S-->
	<div class="my-index-order">
		<a href="<?=Url::to(['/member/order'])?>" class="list">
			<span class="dm-icon my-index-icon my-index-icon1"></span>
			<span><?=yii::t('app_member','my_order')?></span>
			<span class="jt dm-list-right"></span>
	   </a>
	   <!-- 菜单-->

	   <ul class="dm-order-menu">
<!--	   	    <li>-->
<!--	   	    	<a href="--><?//=Url::to(['/member/order'])?><!--" class="btn menu-btn1">-->
<!--					<span class="dm-icon my-index-menuicon my-index-icon7"></span>-->
<!--					<span class="txt">--><?//=yii::t('app_member','all')?><!--<span class="red">--><?//=$order_count['all_count'] ? '('.$order_count['all_count'].')' : ''?><!--</span></span>-->
<!--				</a>-->
<!--	   	    </li>-->
	   	    <li>
	   	    	<a href="<?=Url::to(['/member/order/wait-pay'])?>" class="btn menu-btn1">
					<span class="dm-icon my-index-menuicon my-index-icon8"></span>
					<span class="txt"><?=OrderEnum::getOrderStatus(OrderEnum::ORDER_TYPE,OrderEnum::WAITING_PAYMENT)?><span class="red"><?=$order_count['wait_pay_count'] ? '('.$order_count['wait_pay_count'].')' : ''?></span></span>
				</a>
	   	    </li>
	   	    <li>
	   	    	<a href="<?=Url::to(['/member/order/wait-receive'])?>" class="btn menu-btn1">
					<span class="dm-icon my-index-menuicon my-index-icon9"></span>
					<span class="txt"><?=OrderEnum::getOrderStatus(OrderEnum::ORDER_TYPE,OrderEnum::WAITING_RECEVE)?><span class="red"><?=$order_count['wait_receive_count'] ? '('.$order_count['wait_receive_count'].')' : ''?></span></span>
				</a>
	   	    </li>
	   	    <li>
	   	    	<a href="<?=Url::to(['/member/order/wait-comment'])?>" class="btn menu-btn1">
					<span class="dm-icon my-index-menuicon my-index-icon10"></span>
					<span class="txt">已完成<span class="red"><?=$order_count['wait_comment_count'] ? '('.$order_count['wait_comment_count'].')' : ''?></span></span>
				</a>
	   	    </li>
	   </ul>
	</div>
	<div class="dm-shop-list d-fine-prbox ">
		<a href="<?=Url::to(['/member/order/my-back'])?>" class="list">
			<span class="dm-icon my-index-icon my-index-icon2"></span>
			<span><?=yii::t('app_member','my_back_order') ?></span>
			<span class="jt dm-list-right"></span>
	   </a>
	  <!-- <a href="#" class="list">
			<span class="dm-icon my-index-icon my-index-icon3"></span>
			<span><?/*=yii::t('app_member','my_review') */?></span>
			<span class="jt dm-list-right"></span>
	   </a>-->
	   <a href="<?=Url::to('/member/cashmoney/');?>" class="list">
			<span class="dm-icon my-index-icon my-index-icon4"></span>
			<span>我的米券</span>
			<span class="jt dm-list-right"></span>
	   </a>
	   <a href="<?=Url::to('/member/exchange-money/');?>" class="list">
       			<span class="dm-icon my-index-icon my-index-icon44"></span>
       			<span>我的消费券</span>
       			<span class="jt dm-list-right"></span>
       	   </a>
	   <a href="<?=Url::toRoute('address/index') ?>"
	   class="my-grade-list-line my-data-list clearfix">
	   <span class="dm-icon my-data-icon my-data-icon8" ></span>
	   <?=yii::t('app_member','my_address')?><span class="jt"></span></a>
	   <!--<a href="<?=Url::toRoute('profit/index')?>" class="list <!--list-mg">
			<span class="dm-icon my-index-icon my-index-icon5"></span>
			<span><?=yii::t('app_member','my_team') ?></span>
			<span class="jt dm-list-right"></span>
	   </a>-->
<!-- 	   <a href="<?=Url::toRoute('setting')?>" class="list list-mg">
			<span class="dm-icon my-index-icon my-index-icon6"></span>
			<span><?=yii::t('app_member','setting') ?></span>
			<span class="jt dm-list-right"></span>
	   </a> -->
	</div>
</div>
