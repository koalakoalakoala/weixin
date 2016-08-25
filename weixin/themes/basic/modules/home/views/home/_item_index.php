<?php 
	
?>
<?php //var_dump($model);?>
<li>
	<a class="d-fine-jplist" href="/goods/goods/view?id=<?= $model->goods_id ?>">
		<div class="d-fine-wrapp">
			<img class="d-fine-timg" src="<?=$model->goodsgallery ? Yii::$app->params['img_domain'].$model->goodsgallery->image : '' ?>">
		</div>
		<div class="d-fine-info">
			<div class="d-fine-name"><h3><?= $model->name ?></h3></div>
			<div class="d-fine-price">包邮价:￥<?= $model->market_price ?></div>
		</div>
	</a>
</li>