<!DOCTYPE html>

<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use common\service\CommonService as Service;
use yii\widgets\ActiveForm;
?>

<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="user-scalable=no,width=device-width,initial-scale=1" /><!--设置viewport，适应移动设备的显示宽度-->
		<meta name="apple-mobile-web-app-capable" content="yes" /><!--隐藏safari导航栏及工具栏-->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><!--所有浏览器都以最新模式显示-->
		<title>确认订单-精品商城-重置支付密码</title>
		<link href="css/global.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div class="phone_index" style="background: none;">
				<!--绑定手机提示-->
				<?php 
			        $form = ActiveForm::begin([
			        'id' => 'activity-form',
			        'options' => ['class' => 'form-horizontal bui-form-horizontal bui-form bui-form-field-container'], 
			        'fieldConfig' => [
			            'template' => "{label}\n<div class=\"controls\">{input}<span class=\"valid-text\">{error}</span></div>",
			            'labelOptions' => ['class' => 'lable-text control-label'],
			            'errorOptions'=>['class'=>'valid-text']
			        ],
			    ]); ?>
					<div class="phone-cozy">				    

						<div class="cozyprom">
							<input class="moibler" name="PayPassBackForm[password]" type="text" placeholder="请输入新的支付密码">
							<?php if($model->getErrors('password')){ ?>
								<span class="valid-text"><?=$model->getErrors('password')[0] ?></span>
							<?php } ?>
							<input class="moibler" name="PayPassBackForm[confirmPassword]" type="text" placeholder="请确认新的支付密码">
							<?php if($model->getErrors('confirmPassword')){ ?>
								<span class="valid-text"><?=$model->getErrors('confirmPassword')[0] ?></span>
							<?php } ?>
						</div>
						<div class="phone-middle bgred" style="display: block;margin-top:200px;">
							两次密码不相同
						</div>
						
					</div>
					<div class="tj-fotter queirfov" style="background: none;">
							<?= Html::submitButton(Yii::t('app', '确定')) ?>
							<!-- <a href="#">确定</a> -->
					</div>									
				<?php ActiveForm::end(); ?>	
				
			
			
		</div>
	</body>
</html>
