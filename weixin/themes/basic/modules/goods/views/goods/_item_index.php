<?php 
	use yii\helpers\Html;  
	use yii\helpers\Url;
?>
<li>
    <a class="d-fine-jplist" href="<?=Url::to(['view?id='.$model->goods_id])?>">
        <div class="d-fine-wrapp">
            <img class="d-fine-timg" src="<?=isset($model->gallery[0]) ? Yii::$app->params['img_domain'].$model->gallery[0]->image : ''?>">
        </div>
        <div class="d-fine-info">
            <div class="d-fine-name"><h3><?=$model->name?></h3></div>
            <div class="d-fine-price">包邮价:￥<?=$model? (isset($model->defaultSku) ? $model->defaultSku->market_price + $model->freight : "默认价未设置") : '未知'?></div>
        </div>
    </a>
</li>