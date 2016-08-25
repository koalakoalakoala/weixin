<?php
use yii\helpers\Url;
use common\enum\MoneyEnum;
$this->title="订单结算";
?>

<div class="balance-top mt10 bt clearfix">
	<div class="fl fon16">订单金额</div>
	<div class="price fr">￥<?=$order->price?></div>
</div>
<!-- xzzf-title 选择支付方式标题 S-->
<div class="xzzf-title clearfix">
	<div class="inxzzf-title">
		<div class="xzzf-title-box">
			<div class="inxzzf-title-box f18">选择支付方式</div>
		</div>
	</div>
</div>
<!-- xzzf-title 选择支付方式标题 E-->

<!-- xzzf-content 选择支付方式内容 S-->
<!--<div class="xzzf-wraper">
	<div class="wddz-content xzzf-content">
		<a href="#" class="zxzf-content-icon"><span id="wx" class="dm-icons no-choice choice"></span></a>
		<div class="xzzf-content-img"><img src="/img/choicepay_1.png"/></div>
		<div class="xzzf-content-info">
			<p class="f16 ">支付宝支付</p>
			<!--<p class="f12 mt5 lh20 g-fc">银行卡绑定，微信安全支持</p>-->
		<!--</div>
	</div>
	<div class="wddz-content xzzf-content">
		<a href="#" class="zxzf-content-icon"><span id="wx" class="dm-icons no-choice choice"></span></a>
		<div class="xzzf-content-img"><img src="/img/choicepay_2.png"/></div>
		<div class="xzzf-content-info">
			<p class="f16 ">微信支付</p>
			<!--<p class="f12 mt5 lh20 g-fc">银行卡绑定，微信安全支持</p>-->
		<!--</div>
	</div>-->

	<div class="wddz-content xzzf-content">
		<a class="cleafix hrpay-link" href="<?=Url::to(['/hr/select', 'order_id'=>$_GET['order_id']])?>">
			<span class="zxzf-content-icon"><i></i><span id="hr" class="dm-icons no-choice choice"></span></span>
			<div class="xzzf-content-img fl"><img src="/img/choicepay_3.png"/></div>
			<div class="xzzf-content-info fl">
				<p class="f16 ">华融支付</p>
				<p class="f12 mt5 lh20 g-fc">可银行卡大金额支付</p>
			</div>
		</a>
	</div>
</div>

<input id="order_id" type="hidden" value="<?=isset($_GET['order_id']) ? $_GET['order_id'] : ''?>">
<input id="pay_type" type="hidden" />

<!-- xzzf-content 选择支付方式内容  E-->

<!--底端 S-->
<!--<div class="tjdd-btn">
	  <div class="btn-lie intjdd-btn inxzzf-btn">
		<a href="#xzzf-inputpsw" class="fr xzzf-pbtn" id="payNow">立即支付</a>
	 </div>
</div>-->
<!--底端 E-->

<!-- 支付密码弹出框 begn-->
<div class="d-bodybg  xzzf-pswbom">
	<div class="d-bodyeject d-minheight d-minheightp">
		<div class="body_contr">
			<div class="chenker ">
				<p class="wordker">请输入支付密码</p>
				<div class="xzzf-inputbox">
					<input type="password" class="xzzf-inputpsw"  name="xzzf-inputpsw"/>
					<lable class="zfpsw-err"></lable>
				</div>
				<!--div class="xzzf-forget clearfix"><a href="<?=Url::to(['/member/member/zfpwd'])?>" class="fr">忘记密码了吗？</a></div-->
			</div>

			<div class="pkvoir">
				<div class="btn-zir"><a href="javascript:void(0);">取消</a></div>
				<div class="btn-go"><a href="javascript:void(0);" id="paySub" >支付</a></div>
			</div>
		</div>
		
		<!-- <div class="body_contr2">
			<div class="chenkerp">
				余额不足，请充值!
			</div>

			<div class="pkvoir zf-sure-btn">
				<a href="javascript:void(0);" id="paySub">确 &nbsp;&nbsp;&nbsp;定</a>
			</div>
		</div> -->
		
	</div>
</div>
<!-- 支付密码弹出框 end-->

<script type="text/javascript">

	//调用微信JS api 支付
//	function jsApiCall()
//	{   var order_id = $("#order_id").val();
//		WeixinJSBridge.invoke(
//			'getBrandWCPayRequest',
//			<?php //echo $jsApiParameters; ?>//,
//			function(res){
//				WeixinJSBridge.log(res.err_msg);
//				if(res.err_msg != 'get_brand_wcpay_request:ok'){
//					if(res.err_msg == 'get_brand_wcpay_request:cancel'){
//						$.MsgBox.Alert("","您已取消支付");
//					}
//				}else{
//	                //微信支付成功，跳转到支付成功页面
//	                location.href= "<?//=Url::to(['success']);?>//";
//	            }
//			}
//		);
//	}

	//微信支付点击触发事件
//	function callpay()
//	{
//		if (typeof WeixinJSBridge == "undefined"){
//		    if( document.addEventListener ){
//		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
//		    }else if (document.attachEvent){
//		        document.attachEvent('WeixinJSBridgeReady', jsApiCall);
//		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
//		    }
//		}else{
//		    jsApiCall();
//		}
//	}

	var icon= $('.zxzf-content-icon');
    icon.click(function(){
        $(this).children().addClass('choice');
        $(this).parent().siblings().children('a').children().removeClass('choice');
    });

    $('.btn-zir,.zf-sure-btn').click(function(){
		$('.xzzf-pswbom').hide();
	});

	$(function(){
		$("#payNow").click(function() {
			var type = $(".choice").attr('id');
			var order_id = $("#order_id").val();
			if (type == 'wx') {
				//调用微信的jsApi进行支付
				callpay();
			} else if (type == 'ktx') {
				$('.xzzf-pswbom').show();
				$('.body_contr').show();
				$('.body_contr2').hide();
				$('.zfpsw-err').hide();
				$('.xzzf-inputpsw').val('').focus();
				$("#pay_type").val(<?=MoneyEnum::MONEY?>);
			} else if (type == 'bktx') {
				$('.xzzf-pswbom').show();
				$('.body_contr').show();
				$('.body_contr2').hide();
				$('.zfpsw-err').hide();
				$('.xzzf-inputpsw').val('').focus();
				$("#pay_type").val(<?=MoneyEnum::CZ_MONEY?>);
			}else if(type == 'hr'){
				location.href = "<?=Url::to(['/hr/select'])?>?order_id=" + order_id;
			}else{
				/*$.MsgBox.Alert("","请选择正确支付方式");*/
				$('.zfpsw-err').show().text('请选择正确支付方式');
				
			}
		})

		$("#paySub").click(function(){
			var type = $("#pay_type").val();
			var order_id = $("#order_id").val();
			var zfpwd = $(".xzzf-inputpsw").val();
			if(zfpwd == "" || zfpwd == null){
				/*$.MsgBox.Alert("","支付密码不能为空");*/
				$('.zfpsw-err').show().text('支付密码不能为空');
				return;
			}
			var url = "<?=Url::to(['balapay'])?>";
			$.post(url,{type:type,order_id:order_id,zfpwd:zfpwd,'_csrf':'<?=Yii::$app->request->csrfToken?>'},
                function(data){
                	var res = eval('(' + data + ')');
        			if(parseInt(res.code) == 200){
        				location.href = "<?=Url::to(['success'])?>";
                    }else{
                    	if(res.msg.trim() == "支付密码错误"){
                    		$('.zfpsw-err').show().text('支付密码错误');
							return;
                    	}else{
                    		$.MsgBox.Alert("","余额不足，请充值");
                      //       console.log(res);
                    		// $('.body_contr2').show();
                    		// $('.body_contr').hide();
                    	}
                    }
                }
            );
		})
	})
	$('.xzzf-inputpsw').focus(function(){
		$('.zfpsw-err').hide();
	});
</script>