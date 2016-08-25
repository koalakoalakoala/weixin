<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<a class="d-shop-unit" href="<?= Url::to(['/store/store/view?id='.$model->id]); ?>">
    <div class="d-shop-unit-inner">
        <p class="d-shop-cover">
            <img src="<?= Yii::$app->params['img_domain'].$model->store_logo;?>"/>
        </p>
        <div class="d-shop-detail">
            <p class="d-shop-title store-name"><?= $model->store_name; ?></p>
            
        </div>
    </div>
</a>

<style>
.store-name{
	max-height: 64px;
	height:64px;
	padding-top: 12px;
}
</style>


