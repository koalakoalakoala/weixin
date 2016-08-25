<?php
$this->title = Yii::t('app_member', 'create_money_cash');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="balance-top my-jftx-top">
	<div class=""><?=$moneyModel->attributeLabels()['money']?></div>
	<div class="price">￥<?=$moneyModel->money?></div>
</div>
<!--顶部信息 E-->
<!-- my-txcard-content 提现银行卡内容 S-->
<div class=" tjdd-center-content my-jftx-content">

	<?= $this->render('_form', [
    	'bank'=>$bank,
        'model' => $model,
        'memberModel'=>$memberModel,
        'tx_rate'=>$tx_rate,
        'default_bank' => $default_bank,
    ]) ?>
</div>