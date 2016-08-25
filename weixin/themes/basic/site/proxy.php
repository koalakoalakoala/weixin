<html>
	<head>
		<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js">
		</script>
		<title>
		</title>
	</head>
	<body>
		<!--xdcs-content  begin-->
		<div class="xdcs-content">
			<!-- <h2> 提交资料  </h2>-->
			<!--xd-content-center  begin-->
			<div class="xd-content-center">
				<!--xdcc-list  begin-->
				<form class="xdcc-list" action="" method="post">
					<!--xdcc-inputbox  begin-->
					<div class="xdcc-inputbox">
						<label class="xdcc-card-txt">公司名称<i>*</i></label>
						<div class="xdcc-input ">
							<input type="text" class="xdcc-text" placeholder="请输入公司名称">
						</div>
					</div>
					<div class="xdcc-valid-text">
					</div>
					<!--xdcc-inputbox  begin-->
					<div class="xdcc-inputbox">
						<label class="xdcc-card-txt">行业或领域</label>
						<div class="xdcc-input">
							<input type="text" class="xdcc-text" placeholder="请输入行业或领域">
						</div>
					</div>
					<div class="xdcc-valid-text">
					</div>
					<!--xdcc-inputbox  end-->
					<!--xdcc-inputbox  begin-->
					<div class="xdcc-inputbox">
						<label class="xdcc-card-txt">您的姓名<i>*</i></label>
						<div class="xdcc-input ">
							<input type="text" class="xdcc-text" placeholder="请输入您的姓名">
						</div>
					</div>
					<div class="xdcc-valid-text">
					</div>
					<div class="xdcc-inputbox">
						<label class="xdcc-card-txt">职位或尊称</label>
						<div class="xdcc-input ">
							<input type="xdcc-text" class="xdcc-text" placeholder="请输入职位或尊称">
						</div>
					</div>
					<div class="xdcc-valid-text">
					</div>
					<!--xdcc-inputbox  end-->
					<!--xdcc-inputbox  begin-->
					<div class="xdcc-inputbox">
						<label class="xdcc-card-txt">电话号码<i>*</i></label>
						<div class="xdcc-input ">
							<input type="text" class="xdcc-text xdcc-phone" placeholder="请输入电话号码">
						</div>
					</div>
					<div class="xdcc-valid-text">
					</div>
					<!--xdcc-inputbox  end-->
					<!--xdcc-inputbox  begin-->
					<div class="xdcc-inputbox">
						<label class="xdcc-card-txt">E-mail<i>*</i></label>
						<div class="xdcc-input ">
							<input type="text" class="xdcc-text xdcc-mail" placeholder="请输入E-mail">
						</div>
					</div>
					<div class="xdcc-valid-text">
					</div>
					<!--xdcc-inputbox  end-->
					<div class="xdcc-inputbox">
						<label class="xdcc-card-txt">公司网址</label>
						<div class="xdcc-input ">
							<input type="text" class="xdcc-text" placeholder="请输入公司网址">
						</div>
					</div>
					<div class="xdcc-valid-text">
					</div>
					<!--xdcc-inputbox  end-->
					<div class="xdcc-inputbox">
						<label class="xdcc-card-txt1">需求及项目内容</label>
					</div>
					<div class="xdcc-input ">
						<textarea class="xdcc-input-input" placeholder="这里是内容"></textarea>
					</div>
					<!--xdcc-inputbox  end-->
				</form>
				<!--xdcc-list  end-->
				<div class="stjm-submitted">
					<p>
						已提交成功!
					</p>
				</div>
			</div>
			<div class="xdcs-apply button">
				<button type="submit" class="xdcs-apply-button">
					提交
				</button>
			</div>
			<!--xd-content-center end-->
		</div>
		<!--xdcs-content end-->
<script type="text/javascript">//点击表单
$(".xdcc-text,.xdcc-select").click(function() {
	$(".xdcc-input").removeClass('xdcc-border');
	$(this).parents(".xdcc-input").addClass('xdcc-border');
});

$(function() {
	var inputp = $('.xdcc-inputbox input'),
		box = $('.xdcc-inputbox'),
		btn = $('.xdcs-apply-button');
		
	/*获得焦点删除提示 S*/
	inputp.focus(function() {
		$(this).parents('.xdcc-inputbox').next('.xdcc-valid-text').hide();
	});
	/*获得焦点删除提示 E*/
	/*点提交按钮提示 S*/
	btn.click(function() {
		var bool_sub = true;
		inputp.each(function() {
			if ($(this).val() == "") {
				$(this).parents('.xdcc-inputbox').next('.xdcc-valid-text').text('请填写相关内容').show();
				bool_sub = false;
			}
		});
		return bool_sub;
	});
	/*点提交按钮提示 E*/
	/*验证手机号 S*/
	$('.xdcc-phone').blur(function() {
		checkMobile($(this).val()); //调用checkMobile
	});
	function checkMobile(str) {
		var re = /^1\d{10}$/;
		if (!re.test(str)) {
			$('.xdcc-phone').parents('.xdcc-inputbox').next('.xdcc-valid-text').text('请填写正确手机号').show();
		}
	}
	/*验证手机号 E*/
	/*验证邮箱 S*/
	$('.xdcc-mail').blur(function() {
		checkEmail($(this).val()); //调用
	});
	function checkEmail(str) {
		var re = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
		if (!re.test(str)) {
			$('.xdcc-mail').parents('.xdcc-inputbox').next('.xdcc-valid-text').text('请填写正确邮箱号').show();
		}
	}
	/*验证邮箱 E*/
	/*失去焦点提示 S*/
	inputp.blur(function() {
		if ($(this).val() == "") {
			$(this).parents('.xdcc-inputbox').next('.xdcc-valid-text').text("请填写相关信息").show();
		}
	});
	/*失去焦点提示 E*/
})
</script>
	</body>
</html>