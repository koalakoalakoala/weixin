<?php
$this->title = Yii::t('app_member', 'create_point');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="balance-top my-jftx-top">
	<div class=""><?=$moneyModel->attributeLabels()['gold_points']?></div>
	<div class="price"><?=$moneyModel->gold_points?></div>
	<div class="f12 clearfix"><div class="fl">可提取EGD : <span class="r-fc"><?=$edgModel['edg']?></span></div><div class="fr">当前网络黄金价格：<span class="r-fc"><?=$edgModel['hj_integral']?>元/块</span></div></div>
</div>
<!--顶部信息 E-->
<!-- my-txcard-content 提现银行卡内容 S-->
<div class=" tjdd-center-content my-jftx-content">

	<?= $this->render('_form', [
    	'bank'=>$bank,
        'model' => $model,
        'memberModel'=>$memberModel
    ]) ?>
</div>