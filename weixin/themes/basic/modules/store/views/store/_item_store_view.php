<?php
use yii\helpers\Url;
?>

<li>
    <a class="d-fine-jplist" href="<?=Url::to(['/store/store/goods-view?id='.$model->goods_id])?>">
        <div class="d-fine-wrapp">
            <img class="d-fine-timg" src="<?=$model->gallery ? Yii::$app->params['img_domain'].$model->gallery[0]->thumb3 : ''?>"/>
        </div>
        <div class="d-fine-info">
            <div class="d-fine-name"><?= $model->name; ?></div>
            <div class="d-fine-price">包邮价:<?= $model? (isset($model->defaultSku) ? $model->defaultSku->market_price : "默认价未设置"):"未知" ?></div>
        </div>
    </a>
</li>
