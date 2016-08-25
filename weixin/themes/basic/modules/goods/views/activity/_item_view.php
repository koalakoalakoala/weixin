<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<li>
	<a class="d-fine-jplist" href="<?=  $model?($model->good?($model->good?Url::to(['/goods/goods/view?id='.$model->good->goods_id]):' '):' '):' ' ?>">
		<div class="d-fine-wrapp">
			<img class="d-fine-timg" src="<?=$model?($model->good?($model->good->goodsgallery?Yii::$app->params['img_domain'].$model->good->goodsgallery->image:'未知'):'未知'):'未知'?>">
		</div>
		<div class="d-fine-info">
			<div class="d-fine-name"><h3><?= $model?($model->good?$model->good->name:'未知'):'未知'?></h3></div>
			<div class="d-fine-price">包邮价:￥<?=$model && isset($model->good) && isset($model->good->defaultSku) ? $model->good->defaultSku->market_price + $model->good->freight : '没有设置默认价格'?></div>
		</div>
	</a>
</li>
