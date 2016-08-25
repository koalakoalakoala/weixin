<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\enum\BankEnum;
?>
<div class=" tjdd-center-content">
<?php        
        $form = ActiveForm::begin([
        'id' => 'form',
        'options' => ['class' => 'home-tuan-lists iobrv intjdd-center-content b-card-centent'], 
        'fieldConfig' => [
            // 'template' => "{label}\n<div class=\"controls\">{input}<span class=\"valid-text\">{error}</span></div>",

        	'template'=>"
			    <div class=\"input-box\">
					<label class=\"b-card-txt\">{label}</label>
					<div class=\"in-input-box\">	
						{input}
					</div>
				</div>
				<div class=\"valid-text\">{error}</div>
			",

            'labelOptions' => ['class' => 'lable-text control-label'],
            'errorOptions'=>['class'=>'valid-text']
        ],
    ]); ?>
	<div class="input-box-wrap">
		<?= $form->field($model, 'username',['options'=>['class'=>'control-group span8']])->textInput(['maxlength' => true,'required'=>true,'placeholder'=>yii::t('app_member','bank_username')]) ?>
	</div>
	<div class="input-box-wrap bank-jt-wrap">
		<?= $form->field($model, 'name',['options'=>['class'=>'control-group span8']])->textInput(['maxlength' => true,'required'=>true,'placeholder'=>'请输入银行名称']) ?>
	</div>
	<div class="input-box-wrap">
		<?= $form->field($model, 'branch',['options'=>['class'=>'control-group span8']])->textInput(['maxlength' => true,'required'=>true,'placeholder'=>'请输入支行名称']) ?>
	</div>
	<div class="input-box-wrap">
		<?= $form->field($model, 'no',['options'=>['class'=>'control-group span8']])->textInput(['maxlength' => true,'required'=>true,'integer'=>true,'placeholder'=>yii::t('app_member','bank_no')]) ?>
	</div>
    <div class="input-box-wrap">
        <?= $form->field($model, 'mobile',['options'=>['class'=>'control-group span8']])->textInput(['maxlength' => true,'required'=>true,'integer'=>true,'placeholder'=>'请输入预留手机号']) ?>
    </div>
 	<div class="mq-list-line clearfix b-card-list-line">
		<div class="mq-list-line-pl">
			<?=$model->attributeLabels()['is_default']?>
			<div class="fr mq-btn mq-list-line-right b-card-checkbox"><input type="checkbox" name='is_default' <?php if($model['is_default']==1) echo "checked";?> id="checkbox-10-1" /><label for="checkbox-10-1"></label></div>
		</div>
	</div>
	<div class="tjdd-btn">
<div class="btn-lie intjdd-btn b-card-btn">
<button class="fr"><?=yii::t('app','Sure')?></button>
</div>
<?php ActiveForm::end(); ?>
</div>
<!-- b-card-content 添加银行卡内容 E--> 

<!--底端-->

</div>