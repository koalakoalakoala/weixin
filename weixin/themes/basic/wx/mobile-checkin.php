<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \weixin\models\ContactForm */

$this->title = '请输入验证您的手机号';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .phone-check{
        padding:20px 12px 0 16px;
    }
	.phone-checks{
		padding:10px 0;
	}
	.phone-checks p{
		color: #333;
		font-size: 12px;
	}
    .phone-check h3{
        font-size: 16px;
        text-align: center;
    }
    .phone-check .input-box{
        margin-top: 20px;
    }
    .phone-check input{
        width: 100%;
        line-height: 34px;
        border:1px #ddd solid;
        padding-left: 10px;
		-webkit-appearance: none;
		background: #fff;
    }
    .sure-btn{
		padding: 15px 0px;
        text-align: center;
    }
    .sure-btn button{
		height: 36px;
		width: 100%;
		display: block;
		background: #ff4507;
		text-align: center;
		line-height: 36px;
		font-size: 16px;
		color: #fff;
		border-radius: 5px;
    }
	.q-infored{
		color:#ff4507;
		margin-top:6px;
	}

</style>
<div class="phone-check">
    <h3><?= Html::encode($this->title) ?></h3>
    <form id="mobile_form" class="input-box" method="post" action="" onsubmit="return check(this)">
        <input id="mobile" type="text" name="phone_num" placeholder="请输入验证您的手机号"/>
		<div id="error_mobile" class="q-infored"></div>
		<div class="phone-checks"><p >*用户首次登陆商城需要进行手机号填写，手机号通过验证后即可以登陆！</p></div>
        <div class="sure-btn">
           <button onclick="return check(this.form)">确定</button>
        </div>
    </form>
</div>

<script>
$(function(){
	$('#mobile_form input[name=phone_num]').blur(function(){
		var mobile = $.trim($("#mobile").val());
		var res= checkMobile(mobile);
	});
});	
	function checkMobile()
	{
		var mobile = $.trim($("#mobile").val());
		//手机号为空
		if(!mobile){
			$("#error_mobile").addClass("q-infored");
			$("#error_mobile").html("请输入手机号");
			return false;
		}else{
			$("#error_mobile").removeClass("q-infored");
			$("#error_mobile").html("");
		}
		
		//手机号格式不正确
		var mobile = $.trim($("#mobile").val());
		var reg = /^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/;
		if(!reg.test(mobile)){
			$("#error_mobile").addClass("q-infored");
			$("#error_mobile").html("手机号不合法");
			return false;
		}else{
			$("#error_mobile").removeClass("q-infored");
			$("#error_mobile").html("");
		}
		return true;
	}
	
	function check(){
		var bool_mobile = checkMobile();
		if(bool_mobile){
			return true;
		}else{
			return false;
		}
	}
	

	

</script>
