<?php
use yii\widgets\ActiveForm;
$this->title="订单结算";
?>

<div class="balance-top mt10 bt clearfix">
    <div class="fl fon16">所需消费券</div>
    <div class="price fr"><?=$order->price?></div>
</div>
<!-- xzzf-title 选择支付方式标题 S-->
<div class="xzzf-title clearfix">
    <div class="inxzzf-title">
        <div class="xzzf-title-box">
            <div class="inxzzf-title-box f18">支付方式</div>
        </div>
    </div>
</div>
<!-- xzzf-title 选择支付方式标题 E-->

<!-- xzzf-content 选择支付方式内容 S-->
<!--<div class="xzzf-wraper">
	<div class="wddz-content xzzf-content">
		<a href="#" class="zxzf-content-icon"><span id="wx" class="dm-icons no-choice choice"></span></a>
		<div class="xzzf-content-img"><img src="/img/choicepay_1.png"/></div>
		<div class="xzzf-content-info">
			<p class="f16 ">支付宝支付</p>
			<!--<p class="f12 mt5 lh20 g-fc">银行卡绑定，微信安全支持</p>-->
<!--</div>
</div>
<div class="wddz-content xzzf-content">
<a href="#" class="zxzf-content-icon"><span id="wx" class="dm-icons no-choice choice"></span></a>
<div class="xzzf-content-img"><img src="/img/choicepay_2.png"/></div>
<div class="xzzf-content-info">
    <p class="f16 ">微信支付</p>
    <!--<p class="f12 mt5 lh20 g-fc">银行卡绑定，微信安全支持</p>-->
<!--</div>
</div>-->

<div class="balance-top clearfix">
    <div class="fl fon16">我的消费券</div>
    <div class="fr fon16"><?=$exchange?></div>
</div>
</div>

<input id="order_id" type="hidden" value="<?=isset($_GET['order_id']) ? $_GET['order_id'] : ''?>">
<input id="pay_type" type="hidden" />

<!-- xzzf-content 选择支付方式内容  E-->
<?php $form = ActiveForm::begin([
    'id' => 'exchange-pay-form',
]); ?>
<input type='hidden' name='order_id' value='<?=$order->id?>' />
<!--底端 S-->
 <div class="exchange-btn">
	<button class="b-card-btn" >确定</button>
 </div>


<!--底端 E-->
<?php ActiveForm::end(); ?>