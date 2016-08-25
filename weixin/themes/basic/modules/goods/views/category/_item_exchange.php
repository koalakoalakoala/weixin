<?php
use yii\helpers\Url;
?>
<li>
    <a class="d-fine-jplist" href="<?=Url::to(['/goods/goods/view?id=' . $model->goods_id])?>">
        <div class="d-fine-wrapp d-fine-wrapp_p">
            <img class="d-fine-timg" src="<?= Yii::$app->params['img_domain'].$model->goodsgallery->image ?>">
        </div>
        <div class="d-fine-info">
            <div class="d-fine-name"><h3><?=$model->name?></h3></div>
            <div class="d-fine-price">￥<?=$model->defaultSku->market_price + $model->freight?></div>
            <div class="zq-discount"><span class="r-fc2"><?=$model->defaultSku->exchange?></span>消费券 兑换</div>
        </div>
    </a>
</li>