<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<li>
    <a class="d-fine-jplist" href="<?=Url::to(['/goods/goods/view?id='.$model->goods_id]) ?>">
        <div class="d-fine-wrapp">
            <img class="d-fine-timg" src="<?= Yii::$app->params['img_domain'].$model->goodsgallery->image?>">
        </div>
        <div class="d-fine-info">
            <div class="d-fine-name"><h3><?= $model->name?></h3></div>
            <div class="d-fine-price">包邮价:￥<?=isset($model->defaultSku) ? $model->defaultSku->market_price + $model->freight : '没有设置默认价格'?></div>
        </div>
    </a>
</li>
