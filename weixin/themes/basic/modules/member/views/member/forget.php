<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = '忘记密码';
?>
<div class="mod_container">
    <!-- z-form S-->
   <div class=" tjdd-center-content mt10 bt">
        <?php $form = ActiveForm::begin([
            'id' => 'member-form',
            'options' => ['class' => 'z-form b-card-centent'],
            'fieldConfig' => [
                'errorOptions' => ['style'=>'color:red;']
            ],         
        ]); ?>             
            <div class="input-box-wrap">
                <div class="input-box">
                    <label class="b-card-txt">您的手机号</label>
                    <div class="in-input-box">  
                        <?= $form->field($model, 'mobile', ['options' => ['class' => 'z-phone']])->textInput(['placeholder'=>"请输入您的手机号码"])->label(false)?>
                    </div>
                </div>
                <div class="valid-text" id="mobile-err"></div>
            </div>
            
             <div class="input-box-wrap">
                <div class="input-box">
                    <label class="b-card-txt">短信验证码</label>
                    <div class="in-input-box">  
                        <input type="text" placeholder="请输入验证码" name="Member[verifycode]"/>
                    </div>
                    <button type="button" class="dm-get-btn">获取验证码<button/>
                </div>
                <div class="valid-text" id="verify-err">
                   <?php
                       if (isset($model->errors['verifycode']) &&
                           isset($model->errors['verifycode'][0]))
                           echo $model->errors['verifycode'][0];
                   ?>
                </div>
            </div>
            
            <div class="input-box-wrap">
                <div class="input-box">
                    <lable class="b-card-txt">账户密码</lable>
                    <div class="in-input-box">  
                        <?= $form->field($model, 'password',['options'=>['class'=>'z-password']])->passwordInput(['placeholder'=>"设置您的账户密码"])->label(false)?>
                        <span  class="z-form-del">×</span>
                        <span class="dm-icon eye-close"></span>
                    </div>
                </div>
            </div>
        
            <div class="b-card-btn login-btn">
                <button type="submit" class="fr btn">立即登录</button>
            </div>
        <?php ActiveForm::end(); ?>
     </div>
   <!-- z-form E--> 
</div>
<script>
    $(function() {
        //获取验证码
        $(".dm-get-btn").click(function () {
            var mobile = $.trim($("#member-mobile").val());
            //var res = testMobile(mobile);
            if (mobile) {
                var url = "<?=Url::to(['get-verify'])?>";
                var btn = $(this);
                var data = {
                    mobile: mobile,
                    '_csrf': '<?=Yii::$app->request->csrfToken?>'
                };
                $.post(url, data, function (data) {
                        console.log(data);
                        var res = eval('(' + data + ')');
                        if (parseInt(res.code) == 200) {
                            setResendText(btn);
                            $("#verify-err").html("");
                        } else if (res.code == 201){
                            $("#mobile-err").css('display','block'); 
                            $("#mobile-err").html(res.m_msg);
                        } else {    
                            $("#verify-err").html(res.msg);
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
    /*function testMobile()
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
    }*/

</script>
