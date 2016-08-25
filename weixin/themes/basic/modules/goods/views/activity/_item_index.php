<?php 
	use yii\helpers\Html;  
	use yii\helpers\Url;
?>

<div class="d-featu-box">
	<a href="<?=Url::to(['view?id='.$model->id]) ?>">
		<div class="d-pic-box">
			<img src="<?=Yii::$app->params['img_domain'].$model->ico ?>">
			<div class="d-pic-infor">
				<p><?=$model->name ?></p>
				<span><?=date("Y-m-d",$model->start_time) ?></span>
			</div>
		</div>
		<div class="d-article-disc">
			<p><?=$model->remark ?></p>
		</div>
	</a>
</div>