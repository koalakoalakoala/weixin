<?php 
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\service\ToolService;
?>
<div class="container-wraper-bg">
<?php 
    $form = ActiveForm::begin([
    'id' => 'form',
    'options' => ['class' => 'intjdd-center-content b-card-centent my-jftx-center'], 

    'fieldConfig' => [
        	'template'=>"
			    <div class=\"input-box\">
					<label class=\"b-card-txt\">{label}</label>
					<div class=\"in-input-box\">	
						{input}
					</div>
				</div>
				{error}
			",

            'labelOptions' => ['class' => 'lable-text control-label'],
            'errorOptions'=>['class'=>'valid-text']
        ],

]); ?>


<!-- <form class="intjdd-center-content b-card-centent my-czmx-content" action="" method="post"> -->
   <div class="input-box-wrap">
		<!-- <div class="input-box">
			<label class="b-card-txt">充值金额</label>
			<div class="in-input-box">	
				<input type="text" name='' id="money" placeholder="请输入充值金额"/>
			</div>
		</div> -->

		<?= $form->field($model, 'money',['options'=>['class'=>'control-group span8']])->textInput([
				'maxlength' => true,'number'=>true,'class'=>'money',
			'required'=>true,'placeholder'=>yii::t('app_member','input_money')]) ?>
	</div>
	<!-- xzzf-title 选择支付方式标题 S-->
	<div class="xzzf-title">
		<div class="inxzzf-title">
			<div class="xzzf-title-box">
				<div class="inxzzf-title-box f18">支付方式</div>
			</div>
		</div>
	</div>
	<!-- xzzf-title 选择支付方式标题 E-->
	
	<!-- xzzf-content 选择支付方式内容 S-->
		<div class="xzzf-wraper">
			<div class="wddz-content xzzf-content">
				<div class="xzzf-content-img"><img src="/img/choicepay_1.png"/></div>
				<div class="xzzf-content-info">
					<p class="f16 fw-b">微信支付</p>
					<p class="f12 mt5 lh20 g-fc">银行卡绑定，微信安全支持</p>
				</div>
			</div>
	  </div>
	
    <div class="b-card-btn">
		<button>
			立即支付
		</button>
	</div>
</form>
<!--底端 E-->
</div>




<script type="text/javascript" language="javascript">
//调用微信JS api 支付
//调用微信JS api 支付
function jsApiCall()
{
	WeixinJSBridge.invoke(
		'getBrandWCPayRequest',
		<?php echo $jsApiParameters;?>,
		function(res){
			WeixinJSBridge.log(res.err_msg);
			if(res.err_msg != 'get_brand_wcpay_request:ok'){
				$.notice("充值失败");
			}else{
                  window.history.go("-2");
            }
		}
	);
}

function callpay()
{
	if (typeof WeixinJSBridge == "undefined"){
	    if( document.addEventListener ){
	        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
	    }else if (document.attachEvent){
	        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
	        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
	    }
	}else{
	    jsApiCall();
	}
}
if(<?php echo $jsApiParameters; ?>){
	callpay();
}
$('form').ajaxForm({
	beforeSubmit:function(){
		var money=$('.money').val();
		if(money == ''){
            $.MsgBox.Alert("","请输入充值金额!");
            return false;
        }
        if(money.indexOf(".")>0){
			var num = money.length-money.indexOf(".");
			if(num > 3){
				$.notice("充值金额最小单位为分哦");
				return false;
			}
         }
        if(money.length >=8){
			$.MsgBox.Alert("","您填写的充值金额过大!");
			return false;
         }
        return true;
	},
	success:function(data){
		if(data.success == 1){

			var href="<?=Url::toRoute('index') ?>?sn="+data.info['sn'];
          	location.href = href;
         }
	},
	dataType:'json'
});
</script>