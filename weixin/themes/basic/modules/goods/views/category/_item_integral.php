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
            <div class="d-fine-price">￥<?=$model->defaultSku->market_price + $model->freight?>
</div>
            <div class="zq-discount">赠价值<span class="r-fc2"><?=($model->egd)*100?>%</span>积分</div>
        </div>
    </a>
</li>