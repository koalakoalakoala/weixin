<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
		<?php if($model){ ?>
			<!-- 内页统一头部 E-->
			   <!--my_jftx 顶部信息 S-->
				<div class="my-sign-top">
					<div class="in-my-sign-top">

						<div class="my-sign-top-info">
							<div class="txt">1.如果您已在中盾商城注册过会员，请输入注册时填写的手机号码<br/>
								<span class="shopsh-rfc">2.推荐关系一旦锁定，无法更改，假如您目前的推荐人是中盾商城，可以进行一次修改</span>
							</div>
							<div class="img"><img src="/img/tip-bear.gif"/></div>
						</div>
					</div>
				</div>

			<!--顶部信息 E-->
			<!-- my-jfyx-content 添加银行卡内容 S-->
		       <div class=" tjdd-center-content my-jftx-content b-phone-content">

				   <form class="intjdd-center-content b-card-centent my-jftx-center">

					   <input type="hidden" class="b-phone-incl" id="id" value="<?= $model->id;?>"/>

					   <div class="input-box-wrap">
							<div class="input-box">
								<label class="b-card-txt">昵&nbsp;&nbsp;称</label>
								<div class="in-input-box">
									<input type="text" class="b-phone-incl" placeholder="输入昵称"  id="name" value="<?= $model->name; ?>" />
								</div>
							</div>
					   </div>

					   <div class="input-box-wrap">
							<div class="input-box">
								<label class="b-card-txt">绑定手机号</label>
								<div class="in-input-box">
									<input type="text" placeholder="请输入要绑定的手机号" id="mobile" />
								</div>
							</div>
						   <div class="valid-text" id="mobile_explain"></div>
					   </div>

					   <div class="input-box-wrap">
						   <div class="input-box">
							   <label class="b-card-txt">短信验证码</label>
							   <div class="in-input-box">
								   <input type="text" placeholder="请输入验证码" id="verification"/>
							   </div>
							   <button id="submit" class="dm-get-btn">获取验证码</button>
						   </div>
						   <div class="valid-text" id="verification_explain"></div>
					   </div>

					   <div class="input-box-wrap">
							<div class="input-box">
								<label class="b-card-txt">推荐人手机</label>
								<div class="in-input-box">
									<input type="text" class="b-phone-incl" placeholder="请输入推荐人手机号" id="recommend_mobile"/>
								</div>
							</div>
					   </div>

					   <div class="input-box-wrap">
						   <div class="input-box">
							   <label class="b-card-txt">推荐人</label>
							   <div class="in-input-box" id="recommendname"></div>
							   </div>
						   </div>
					   </div>

                       <div class="b-phone-check">
							<span class="dm-checkbox">
								<input type="checkbox" value="1" id="checkboxFourInput" name="" />
								<label for="checkboxFourInput"></label>
							</span>
						   <a href="#">我已阅读并同意《用户注册协议》</a>
					   </div>

					   <div class="b-card-btn">
						   <button id="submitButton" class="fr">确定</button>
					   </div>

                   </form>

               </div>
               <?php } ?>
		<!-- b-card-content 添加银行卡内容 E-->

<script type="text/javascript">

	//验证表单提交
	$(function(){
		$("#submitButton").click(function(){
			if (checkboxFourInput.checked == true) {
				if($("#verification").val() && $("#mobile").val())
				{
					if ($("#recommendname").html() == "无此推荐人") {
						$.MsgBox.Alert("","请输入正确的推荐人");
					}
					else {
						var id = $("#id").val();
						var name = $("#name").val();
						var mobile = $("#mobile").val();
						var verification = $("#verification").val();
						var recommend_mobile = $("#recommend_mobile").val();
						var url = "<?= Url::to(['determine'])?>";

						$.post(url, {
								id: id,
								name: name,
								mobile: mobile,
								verification: verification,
								recommend_mobile: recommend_mobile,
								_csrf: "<?= Yii::$app->request->csrfToken ?>"
							},
							function (data) {
								var res = eval('(' + data + ')');
								if (parseInt(res.code) == 200) {
									if(res.msg == "验证成功") {
										location.href = res.url;
										$.MsgBox.Alert("",res.msg);
									} else {
										location.href = "#";
										$.MsgBox.Alert("",res.msg);
									}
								} else {
									$.MsgBox.Alert("",res.msg);
									location.href = res.url;
								}
							}
						);
					}
				} else {
					if(!$("#mobile").val())
					{
						$("#mobile_explain").html("请输入手机号");
					}
					if(!$("#verification").val())
					{
						$("#verification_explain").html("您的验证码为空，请输入！");
					}
					$.MsgBox.Alert("",'您有未输入的数据');
				}
			}
			else {
				$.MsgBox.Alert("","您未同意");
			}
		});
	});

	//输入项 不为空判断
	$(function(){
		$("#mobile").blur(function(){
			if(!$("#mobile").val())
			{
				$("#mobile_explain").html("请输入手机号");
			} else {
				$("#mobile_explain").html("");
			}
		});

		$("#verification").blur(function(){
			if(!$("#verification").val())
			{
				$("#verification_explain").html("您的验证码为空，请输入！");
			} else {
				$("#verification_explain").html("");
			}
		});
	});

	//发送验证码短信
	$(function(){
		$("#submit").click(function(){
			var mobile = $("#mobile").val();
			var url = "<?= Url::to(['verification'])?>";
			$.post(url,{mobile:mobile,'_csrf':'<?= Yii::$app->request->csrfToken ?>'},
				function(data){
					var res = eval('(' + data + ')');
					if(parseInt(res.code) == 200){
						location.href = "#";
						$.MsgBox.Alert("",res.msg);
					} else {
						location.href = "#";
						$.MsgBox.Alert("",res.msg);
					}
				}
			);
		});
	});

	//推荐人名称 ajax显示
	$(function(){
		$("#recommend_mobile").blur(function(){
			var recomobile = $("#recommend_mobile").val();
			var url = "<?= Url::to(['searchmember'])?>";
			$.post(url,{recomobile:recomobile,'_csrf':'<?= Yii::$app->request->csrfToken ?>'},
				function(data){
					var res = eval('(' + data + ')');
					if(parseInt(res.code) == 200){
						$("#recommendname").html(res.username);
					} else {
						$.MsgBox.Alert("",res.msg);
					}
				}
			);
		});
	});

</script>


