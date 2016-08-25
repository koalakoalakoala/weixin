<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = '用户登录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mod_container">
    <!-- z-form S-->
   <div class=" tjdd-center-content mt10 bt">
        <?php $form = ActiveForm::begin([
	'id' => 'member-form',
	'options' => ['class' => 'z-form b-card-centent'],

]);?>
            <div class="input-box-wrap">
                <div class="input-box">
                    <label class="b-card-txt">您的手机号</label>
                    <div class="in-input-box">
                        <?=$form->field($model, 'mobile', ['options' => ['class' => 'z-phone']])->textInput(['placeholder' => "请输入您的手机号码"])->label(false)?>
                    </div>
                </div>
            </div>

            <div class="input-box-wrap">
                <div class="input-box">
                    <lable class="b-card-txt">账户密码</lable>
                    <div class="in-input-box">
                        <?=$form->field($model, 'password', ['options' => ['class' => 'z-password']])->passwordInput(['placeholder' => "请输入您的账户密码"])->label(false)?>
                        <span  class="z-form-del">×</span>
                        <span class="dm-icon eye-close"></span>
                    </div>
                </div>
            </div>

          <div class="b-card-btn login-btn">
            <?=Html::submitButton('立即登录', ['class' => 'btn', 'name' => 'login-button'])?>
         </div>
         <?php ActiveForm::end();?>
         <div class="forget-passw"><a href="/member/member/forget">忘记密码？</a></div>
     </div>
   <!-- z-form E-->
</div>

