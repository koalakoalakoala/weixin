<?php
    use yii\helpers\Url;
    use common\enum\ActivityPageEnum;
?>
<?php if ($_GET['activity_id'] == ActivityPageEnum::TUANGOU) { ?>
<li>
    <a class="d-fine-jplist" href="<?=Url::to(['/goods/goods/view', 'id' => $model->goods_id])?>">
        <div class="d-fine-wrapp">
            <img class="d-fine-timg" src="<?= Yii::$app->params['img_domain'].$model->goodsgallery->image ?>">
        </div>
        <div class="d-fine-info">
            <div class="d-fine-name"><h3><?=$model->name?></h3></div>
            <div class="d-fine-price">团购价:￥<?=$model->defaultSku ? $model->defaultSku->market_price + $model->freight : $model->market_price + $model->freight ?></div>
        </div>
    </a>
</li>
<?php } else if ($_GET['activity_id'] == ActivityPageEnum::FANLI) { ?>
<li>
    <a class="d-fine-jplist" href="<?=Url::to(['/goods/goods/view', 'id' => $model->goods_id])?>">
        <div class="d-fine-wrapp">
            <img class="d-fine-timg" src="<?= Yii::$app->params['img_domain'].$model->goodsgallery->image ?>">
        </div>
        <div class="d-fine-info">
            <div class="d-fine-name"><h3><?=$model->name?></h3></div>
            <div class="d-fine-price">包邮价:￥<?=$model->defaultSku ? $model->defaultSku->market_price + $model->freight : $model->market_price + $model->freight ?></div>
        </div>
    </a>
</li>
<?php }