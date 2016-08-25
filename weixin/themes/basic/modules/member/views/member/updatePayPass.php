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
		<title>确认订单-精品商城-忘记支付密码</title>
		<link href="css/global.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div class="phone_index" style="background: none;">
				
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

					<!--绑定手机提示-->
					<div class="phone-cozy">
						<div class="tit">您当前手机号：<span class="coblur"><?=substr_replace($mobile,'****',3,4) ?></span></div>
						<div class="cozyprom">
							<input id="paypassbackform-mobile" name="PayPassBackForm[mobile]" class="moibler" type="text" placeholder="请输入您注册时填写的手机号">
							<?php if($model->getErrors('mobile')){ ?>
								<span class="valid-text"><?=$model->getErrors('mobile')[0] ?></span>
							<?php } ?>
							<input class="moibler mobrwidth" type="text" name="PayPassBackForm[verify]" placeholder="请输入验证码">
							<?php if($model->getErrors('verify')){ ?>
								<span class="valid-text"><?=$model->getErrors('verify')[0] ?></span>
							<?php } ?>
							<a id="getVcode" href="#" class="btinr">获取验证码</a>
							<a href="#" class="btinr" style="display: none;">获取验证码（15）</a>
						</div>
						<div class="phone-middle bgred" style="display: block;margin-top:200px;">
							验证码有误，请重新输入
						</div>
						
					</div>
					<div class="tj-fotter queirfov" style="background: none;">
							<?= Html::submitButton(Yii::t('app', '确定')) ?>
							<!-- <a href="#">确定</a> -->
					</div>		

				<?php ActiveForm::end(); ?>	
		</div>
		<script type="text/javascript">
			$(function(){
				$("#getVcode").click(function(){
					var mobile = $("#paypassbackform-mobile").val();
					var reg = /^0?1[3|4|5|8][0-9]\d{8}$/;
 					if(mobile){
 						if (reg.test(mobile)){
 							var m = "<?=$mobile ?>"; //用户关联的手机号
 							var hdm = "<?=substr_replace($mobile,'****',3,4) ?>"; //隐藏中间4位的手机号
 							if(m == mobile){
 								var url = "<?=Url::to(['ajax-get-verify'])?>";
 								var type =  "<?=Service::VERIFY_TYPE_PAYPWD ?>";//指定验证码的类型
	 							$.post(url,{mobile:mobile,type:type},
					                function(data){
					                    console.log(data);
					                }
					            );
 							}else{
 								$.MsgBox.Alert("","请输入注册时绑定的手机号"+hdm);
 								return;
 							} 							
	 					}else{
	 						$.MsgBox.Alert("","请输入正确格式的手机号");
	 						return;
	 					}	
 					}else{
 						$.MsgBox.Alert("","请输入手机号");
 						return;
 					}
 					
				})
			})
		</script>
	</body>
</html>
