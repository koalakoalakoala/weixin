<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
$this->title = '华融支付-信用卡支付';
?>
        <div class="mod_container">
            <!-- z-form S-->
           <div class=" tjdd-center-content mt10 bt">
                <?php $form = ActiveForm::begin([
                    'id' => 'bc-form',
                    'options' => ['class' => 'z-form b-card-centent'],
                    'fieldConfig' => [
                        'template' => "
                            <div class=\"input-box\">
                                <label class=\"b-card-txt\">{label}</label>
                                <div class=\"in-input-box\">
                                    {input}
                                </div>
                            </div>
                            <div class='help-block', style='margin-bottom:0;font-size:12px;'>{error}</div>
                        ",
                        'labelOptions' => ['class' => 'b-card-txt'],
                        'errorOptions' => ['class'=>'valid-text']
                    ],
                ]); ?>

                    <?= $form->field($model, 'name', ['options' => ['class' => 'input-box-wrap']])
                        ->textInput(['class'=>'input-box-wrap','placeholder'=>'请输入您的真实姓名']) ?>
                    <?= $form->field($model, 'idCard', ['options' => ['class' => 'input-box-wrap']])
                        ->textInput(['class'=>'input-box-wrap','placeholder'=>'请输入您的身份证号']) ?>

                    <?= $form->field($model, 'cardNo', ['options' => ['class' => 'input-box-wrap mt10 bt']])
                        ->textInput(['class'=>'input-box-wrap','placeholder'=>'请输入您的支付信用卡号'])->label('信用卡号') ?>
                    
                    <div class="input-box-wrap">
                        <div class="input-box">
                            <label class="b-card-txt">有效期限</label>
                            <div class="in-input-box">  
                                <input name="HrPay[year]" value="<?=$model->year?>" placeholder="如2015" type="text"/>
                            </div>
                            <div class="z-ibar">/</div>
                            <div class="in-input-box">  
                                <input name="HrPay[month]" value="<?=$model->month?>" placeholder="如01" type="text"/>
                            </div>
                        </div>
                        <div class="valid-text">
                            <?php
                            if (isset($model->errors['year']) &&
                                isset($model->errors['year'][0])) {
                                echo $model->errors['year'][0];
                            }
                            if (isset($model->errors['month']) &&
                                isset($model->errors['month'][0])) {
                                echo $model->errors['month'][0];
                            }

                            ?>
                        </div>
                    </div>

                    <?= $form->field($model, 'cvv2', ['options' => ['class' => 'input-box-wrap']])
                        ->textInput(['class'=>'input-box-wrap','placeholder'=>'请输入信用卡的CVV2安全码']) ?>

                    <?= $form->field($model, 'mobile', ['options' => ['class' => 'input-box-wrap']])
                        ->textInput(['class'=>'input-box-wrap','placeholder'=>'请输入您银行卡预留的手机号码']) ?>


                   <div class="input-box-wrap">
                       <div class="input-box">
                           <label class="b-card-txt">短信验证码</label>
                           <div class="in-input-box">
                               <input name="HrPay[verifyCode]" type="text" placeholder="请输入验证码"/>
                           </div>
                           <button type="button" class="dm-get-btn">获取验证码<button/>
                       </div>
                       <div class="valid-text" id="verify-err">
                           <?php
                           if (isset($model->errors['verifyCode']) &&
                               isset($model->errors['verifyCode'][0]))
                               echo $model->errors['verifyCode'][0];
                           ?>
                       </div>
                   </div>

                    <input id="hrSn" name="hrSn" type="hidden" value="<?=$order->hr_sn?>">
                    <input id="price" name="price" type="hidden" value="<?=$order->price?>">
                    <input id="goodsName" name="goodsName" type="hidden" value="<?=$goods_name?>">
                    
                  <div class="b-card-btn login-btn">
                    <button type="submit" class="fr btn">确定</button>
                 </div>
               <?php ActiveForm::end(); ?>
        </div>
           <!-- z-form E--> 
    </div>


<script type="text/javascript">
    $(function() {
        var hrSn = $("#hrSn").val();
        var price = $("#price").val();
        var goodsName = $("#goodsName").val();
        //获取验证码
        $(".dm-get-btn").click(function () {
            var mobile = $.trim($("#hrpay-mobile").val());
            var res = testMobile(mobile);
            if (res) {
                var url = "<?=Url::to(['get-verify'])?>";
                var btn = $(this);
                var data = {
                    hrSn: hrSn,
                    price: price,
                    mobile: mobile,
                    goodsName: goodsName,
                    '_csrf': '<?=Yii::$app->request->csrfToken?>'
                };
                console.log(data);
                $.post(url, data, function (data) {
                        console.log(data);
                        var res = eval('(' + data + ')');
                        if (parseInt(res.code) == 200) {
                            setResendText(btn);
                            $("#verify-err").html("");
                        } else {
                            $("#verify-err").html("验证码发送失败");
                        }
                    }
                );
            }
        });
    });

    function setResendText(btn)
    {
        var textTmp = 60;
        var text = btn.text();
        btn.attr('disabled', 'disabled');
        btn.addClass("gray");
        btn.text(textTmp + "后重新发送");
        var int = self.setInterval(function () {
            textTmp = textTmp - 1;
            btn.text(textTmp + "后重新发送");
            if (textTmp == 0) {
                btn.text(text);
                btn.removeAttr('disabled');
                btn.removeClass('gray');
                window.clearInterval(int);
            }
        }, 1000);
    }

    /**
     * 验证手机号
     */
    function testMobile()
    {
        var mobile = $.trim($("#hrpay-mobile").val());
        //手机号为空
        if(!mobile){
            $(".field-hrpay-mobile > .help-block > .valid-text").html("预留手机号不能为空。");
            return false;
        }
        //手机号格式不正确
        var reg = /^(0|86|17951)?(13[0-9]|15[012356789]|17[03678]|18[0-9]|14[57])[0-9]{8}$/;
        if(!reg.test(mobile)){
            $(".field-hrpay-mobile > .help-block > .valid-text").html("手机号格式错误");
            return false;
        }else{
            $(".field-hrpay-mobile > .help-block > .valid-text").html("");
        }
        return true;
    }
</script>