<!--<div class="my-sign-top">
	<div class="in-my-sign-top">
		<div class="my-sign-top-info">
			<div class="txt">每天签到可1成长值，连续7天签到，额外奖励5成长值</div><div class="img"><img src="/img/tip-bear.gif"/></div>
		</div>
	</div>
</div>-->
<div class="balance-top my-jftx-top">
	<div class=""><?=$moneyModel->attributeLabels()['gold_points']?></div>
	<div class="price"><?=$moneyModel->gold_points?></div>
	<div class="f12"><span class="r-fc">1</span>积分 = <span class="r-fc">1</span>人民币</div>
</div>
<!--顶部信息 E-->
<!-- my-jfyx-content 添加银行卡内容 S-->
<div class=" tjdd-center-content my-jftx-content">
	<?= $this->render('_cash', [
        'model' => $model,
        'memberModel'=>$memberModel
    ]) ?>
 </div>