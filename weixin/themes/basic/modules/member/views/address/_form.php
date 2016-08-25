<?php 
	use yii\widgets\ActiveForm;
	use yii\helpers\Url;
?>
<div class="mod_container">
	<!-- z-form S-->
	<div class=" tjdd-center-content mt10 bt">
		
		<?php $form = ActiveForm::begin([
			'id' => 'bc-form',
			'options' => ['class' => 'z-form b-card-centent'],
			'fieldConfig' => [
				'template' => "
							<div class=\"input-box\">
								<label class=\"b-card-txt\">{label}</label>
								<div class=\"in-input-box\">
									{input}
								</div>
							</div>
							<div class='help-block', style='margin-bottom:0;font-size:12px;'>{error}</div>
					   ",
				'labelOptions' => ['class' => 'b-card-txt'],
				'errorOptions' => ['class'=>'valid-text']
			],
		]); ?>

			<input type='hidden' name='DeliveryAddress[id]' value='<?=$model['id']?>' />

			<input type="hidden" name='DeliveryAddress[sku_id]' value='<?= $sku_id ?>' />

			<input type="hidden" name="DeliveryAddress[province_id]" id="province_id" value="<?=$model->province_id?>" />

			<input type="hidden" name="DeliveryAddress[province]" id="province" value="<?=$model->province?>" />

			<input type="hidden" name="DeliveryAddress[city_id]" id="city_id" value="<?=$model->city_id?>" />

			<input type="hidden" name="DeliveryAddress[city]" id="city" value="<?=$model->city?>" />

			<input type="hidden" name="DeliveryAddress[area_id]" id="area_id" value="<?=$model->area_id?>" />

			<input type="hidden" name="DeliveryAddress[area]" id="area" value="<?=$model->area?>" />

			<?= $form->field($model, 'name', ['options' => ['class' => 'input-box-wrap']])
				->textInput(['class'=>'input-box-wrap','placeholder'=>'请输入收货人姓名']) ?>

			<?= $form->field($model, 'mobile', ['options' => ['class' => 'input-box-wrap']])
				->textInput(['class'=>'input-box-wrap','placeholder'=>'请输入手机号码']) ?>

			<div class="input-box-wrap">
				<div class="input-box" id='setArea' class='setArea'>
					<label class="b-card-txt">选择地区</label>
					<div class="in-input-box">
						<input value="<?=$model->province.$model->city.$model->area?>" class="addr-input" type="text" onclick="getProvince()" readonly="readonly" placeholder="选择收货地址"/>
						<span class="jt"></span>
					</div>
				</div>
				<div class="aerr valid-text">
					<?php
						if(isset($model->errors['province'])) {
							echo $model->errors['province'][0];
						}
					?>
				</div>
				<div class="address-box">
					<div class="addr-tit">请选择所在地区<span class="addr-close">×</span></div>
				</div>
			</div>

			<?= $form->field($model, 'detail', ['options' => ['class' => 'input-box-wrap']])
				->textInput(['class'=>'input-box-wrap','placeholder'=>'请输入详细地址']) ?>


			<div class="clearfix b-card-list-line bb">
				<div class="mt8">
					设置为默认地址
					<div class="fr mq-btn mq-list-line-right b-card-checkbox"><input type="checkbox" name='DeliveryAddress[is_default]' value='1' <?php if($model['is_default']==1) echo "checked";?> id="checkbox-10-1" /><label for="checkbox-10-1"></label></div>
				</div>
			</div>


			<!--底端-->
			 <div class="b-card-btn">
				<button>确定</button>
			</div>
		<?php ActiveForm::end(); ?>
	</div>
</div>

<script type="text/javascript">
	//防止重复提交
	var flagProvince = flagCity = flagArea = true;

	function getProvince()
	{
		if (flagProvince) {
			flagProvince = false;
			//清空市区信息
			$("#city_id").val("0");
			$("#city").val("");
			$("#area_id").val("0");
			$("#area").val("");

			var url = "<?= Url::to(['get-province']) ?>";
			$.get(url, function(data) {
					$(".address-box").animate({bottom:"0"});
					$('.address-box').append(data);
				}
			);
		}
	}

	function getCity(code, name)
	{
		if (flagCity) {
			flagCity = false;
			//保存所选的省
			$("#province_id").val(code);
			$("#province").val(name);
			//清除区信息
			$("#area_id").val("0");
			$("#area").val("");
			if (name == '香港特别行政区' || name == '澳门特别行政区' || name == '澳门特别行政区') {
				$(".addr-input").val(name);
				$(".address-box .add-cont").remove();
			} else {
				var url = "<?= Url::to(['get-city']) ?>?code=" + code;
				$.get(url, function (data) {
						$(".address-box").animate({bottom: "0"});
						$('.add-cont').html(data);
					}
				);
			}
		}
	}

	function getArea(code, name)
	{
		if (flagArea) {
			flagArea = false;
			$("#city_id").val(code);
			$("#city").val(name);
			var url = "<?= Url::to(['get-area']) ?>?code="+code;
			$.get(url, function(data) {
					$(".address-box").animate({bottom:"0"});
					$('.add-cont').html(data);
				}
			);
		}
	}

	function setAddress(code, name)
	{
		flagProvince = flagCity = flagArea = true;
		$("#area_id").val(code);
		$("#area").val(name);
		var province = $("#province").val();
		var city = $("#province").val();
		var address = province + city + name;
		$(".addr-input").val(address);
		$(".address-box .add-cont").remove();
		$('.address-box').animate({bottom:'-800px'});
	}
		
	$(function(){
		$('.addr-input').click(function(){
			$(".address-box").animate({bottom:"0"});
		});
		$('.addr-close').click(function(){
			$(".address-box").animate({bottom:"-800px"});
		});
	})
	
</script>