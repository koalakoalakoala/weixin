<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = "用户注册";
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
                        <?= $form->field($model, 'mobile',['options'=>['class'=>'z-phone']])->textInput(['placeholder'=>"请输入您的手机号码"])->label(false)?>
                    </div>
                </div>
                <div class="valid-text"><?=!empty($msg) ? $msg : ''?></div>
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
                <!--div class="valid-text"></div-->
            </div>
            
            <div class="input-box-wrap">
                <div class="input-box tjr">
                    <label class="b-card-txt">推荐人账户</label>
                    <div class="in-input-box">  
                        <?= $form->field($model, 'r_mobile',['options'=>['class'=>'z-phone']])->textInput(['placeholder'=>"请输入推荐人的注册账户"])->label(false)?>
                    </div>
                </div>
                <div class="valid-text"><?=!empty($r_msg) ? $r_msg : ''?></div>
            </div>
            
            <div class="b-phone-check">
                <span class="dm-checkbox">
                    <input type="checkbox" id="checkboxFourInput" checked="checked" name = "RegisterForm[agreement]" />
                    <label  for="checkboxFourInput"  class="dm-icon"></label>
                </span>
                <a href="<?=Url::to(['agreement'])?>">我已阅读并同意《用户注册协议》</a>
            </div>
            <div class="valid-text mt10" style="float:right;margin-right:540px;">
                <?php 
                        if(isset($model->errors) && isset($model->errors['agreement'])){
                            echo $model->errors['agreement'][0];
                        } 
                ?>
            </div>
            <div class="b-card-btn login-btn">
                <button type="submit" class="fr btn">立即注册</button>
            </div>
        <?php ActiveForm::end(); ?>
     </div>
   <!-- z-form E--> 
</div>
