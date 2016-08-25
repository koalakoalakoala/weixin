<?php
use yii\helpers\Url;
$this->title="支付失败";
?>
<!--支付失败内容 S-->
<div class="paysuc-content payfau-content">
    <div class="paysuc-content-img">
        <img src="/img/pay-failure.png">
    </div>
    <div class="goshop-content-txt paysuc-content-txt pay-fau-text">
        <p class="f18"><?=$msg?></p>
    </div>
</div>
<!--支付失败内容 E-->

<!--支付失败按钮 S-->
<div class="tjdd-btn">
    <div class="in-paysuc-btn clearfix">
        <div class="">
            <div class="in-paysuc-btn-box">
                <a href="<?=Url::to(['/order/payment/index', 'order_id'=>$order_id])?>">其它支付方式</a>
            </div>
        </div>
    </div>
</div>
<!--支付失败按钮 E-->