<?php
    use yii\widgets\ActiveForm;
?>

<style type="text/css">
    .error_msg{
        margin-bottom:-20px;font-size:12px;
    }
</style>

<!--top info begin-->
<div class="my-sign-container-wraper">
    <div class="my-sign-top">
        <div class="in-my-sign-top">
            <div class="my-sign-top-info">
                <div class="txt">您确保你输入的持卡人与银行卡<span class="meberorange">信息一致</span>，否则将提现失败！</div><div class="img"><img src="/img/tip-bear.gif"></div>
            </div>
        </div>
    </div>
</div>
<!--top info end-->
<!--提现相关内容  begin-->
<div class="balance-top memberbortop">
    <div class="">可提现余额</div>
    <div class="price">￥6000.00</div>
</div>
<div class=" tjdd-center-content">
    <?php
        $form = ActiveForm::begin([
        'id' => 'form',
        'options'=>[
            'class' => 'intjdd-center-content b-card-centent my-jftx-center',
        ],
        'method' => 'post'
    ]); ?>
        <div class="input-box-wrap">
            <div class="input-box">
                <label class="b-card-txt ">提现金额</label>
                <div class="in-input-box">
                    <?=$form->field($model, 'all_money')->textInput([
                                    'placeholder'=>'输入提现金额',
                                ])->label(false)->error(['class'=>'help-block error_msg']) ?>
                </div>
            </div>
        </div>

        <div class="input-box-wrap mt10 memberbortop">
            <div class="input-box">
                <label class="b-card-txt membercolor">收款银行</label>
                <div class="in-input-box">
                    <?=$form->field($model, 'bank_name')->textInput([
                                    'placeholder'=>'请输入收款银行',
                                ])->label(false)->error(['class'=>'help-block error_msg']) ?>
                </div>
            </div>
        </div>

        <div class="input-box-wrap">
            <div class="input-box">
                <label class="b-card-txt membercolor">持卡人</label>
                <div class="in-input-box">
                    <?=$form->field($model, 'user_name')->textInput([
                                    'placeholder'=>'请输入持卡人姓名',
                                ])->label(false)->error(['class'=>'help-block error_msg']) ?>
                </div>
            </div>
        </div>
        <div class="input-box-wrap">
            <div class="input-box">
                <label class="b-card-txt membercolor">银行卡号</label>
                <div class="in-input-box">
                    <?=$form->field($model, 'bank_number')->textInput([
                                    'placeholder'=>'请输入银行卡号',
                                ])->label(false)->error(['class'=>'help-block error_msg']) ?>
                </div>
            </div>
        </div>

        <div class="input-box-wrap mt10 memberbortop">
            <div class="input-box">
                <label class="b-card-txt membercolor">预留手机号</label>
                <div class="in-input-box">
                    <?=$form->field($model, 'mobile')->textInput([
                                    'placeholder'=>'请输入银行预留手机号',
                                ])->label(false)->error(['class'=>'help-block error_msg']) ?>
                </div>
            </div>
        </div>
        <div class="input-box-wrap">
            <div class="input-box">
                <label class="b-card-txt">短信验证码</label>
                <div class="in-input-box">
                    <?=$form->field($model, 'sms_code')->textInput([
                                    'placeholder'=>'请输入验证码',
                                ])->label(false)->error(['class'=>'help-block error_msg']) ?>
                </div>
                <button class="dm-get-btn marnones">获取验证码</button>
            </div>
        </div>
        <!--button begin-->
        <div class="b-card-btn">
            <button href="" class="fr">提交</button>
        </div>
        <!--button end-->

    <?php ActiveForm::end(); ?>
</div>
<!--提现相关内容 end-->