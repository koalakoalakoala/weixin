<?php
/**
 * @author xiaomalover <xiaomalover@gmail.com>
 * @created 2016/5/27 15:09
 */
use yii\helpers\Url;
?>
<div class="d-featu-box">

    <div class="d-pic-box">
        <a href="<?=Url::to(['/goods/car/view', 'id'=>$model->goods_id])?>"><img src="<?=$model->goodsgallery? Yii::$app->params['img_domain'].$model->goodsgallery->image : '' ?>" ></a>
        <div class="d-pic-infor z-intitlers">
            <p><?=$model->name?></p>
        </div>
    </div>
    <div class="d-article-disc">
        <div class="z-info-titles">
            <div class="z-title-prices">
                <p>经销指导价：<?=$model? (isset($model->defaultSku) ? $model->defaultSku->price : "默认订金未设置") : '未知'?></p>
                <p>订金：<span class="r-fc">￥<?=$model? (isset($model->defaultSku) ? $model->defaultSku->market_price : "默认订金未设置") : '未知'?></span></p>
            </div>
            <div class="z-btn-buy z-buy-gobuyer"><a href="<?=Url::to(['view', 'id'=>$model->goods_id])?>">立即购买</a></div>
        </div>
    </div>
</div>
