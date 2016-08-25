<?php 
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\service\ToolService;
?>

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
		<div class="input-box-wrap">

			<?= $form->field($model, 'money',['options'=>['class'=>'control-group span8']])->textInput([
				'maxlength' => true,'number'=>true,
			'required'=>true,'placeholder'=>yii::t('app_member','input_money_cash'),'data-url'=>Url::toRoute('getmoney')]) ?>
			<div class="my-txcard-tip">*提现金额为100的整数倍</div>
		</div>
		
		<div class="input-box-wrap">
			<?php if (!$model->bank_id) $model->bank_id = $default_bank;?>
			<?= $form->field($model, 'bank_id',['options'=>['class'=>'control-group span8']])->dropDownList($bank) ?>
			<div class="btn-lie in-input-box b-card-btn my-txcard-btn">
	          <a href="<?=Url::toRoute('bank/create') ?>"><?=yii::t('app_member','add_bank')?></a>
	        </div>
		</div>
		
		<div class="input-box-wrap">
			<div class="input-box">
				<label class="b-card-txt"><?=$memberModel->attributeLabels()['mobile']?></label>
				<div class="in-input-box r-fc">	
					<?=ToolService::setEncrypt($memberModel['mobile'],3,4,'*',4)?>
					<input name='MoneyCash[mobile]' type='hidden' value='<?=$memberModel['mobile']?>'/>
				</div>
			</div>
		</div>
	 
		 <div class="input-box-wrap input-box-getwrap">
			<div class="dm-get-input">	
	          <?= $form->field($model, 'code',['options'=>['class'=>'control-group span8']])->textInput([
					'maxlength' => true,'number'=>true,
				'required'=>true,'placeholder'=>yii::t('app_member','input_validate_code')]) ?>
	        </div>

			<button class="dm-get-btn" id='verify_btn' 
				data-url='<?=Url::toRoute(['verify','mobile'=>$memberModel['mobile']])?>'>
				<?=yii::t('app_member','get_validate_code')?>
			</button>
		</div>
		
		<div class="input-box-wrap mt10 bt">
			<div class="input-box">
				<label class="b-card-txt"><?=$model->attributeLabels()['money']?></label>
				<div class="in-input-box  r-fc">	
					￥<span class='money'><?=$model->money?></span>
				</div>
			</div>
		</div>
		
		<div class="input-box-wrap">
			<div class="input-box">
				<label class="b-card-txt"><?=$model->attributeLabels()['real_money']?></label>
				<div class="in-input-box  r-fc">	
					￥<span class='real_money'><?=$model->real_money?></span> <span class="gy-fc">（<?=yii::t('app_member','poundage')?> <?=$tx_rate?>%）</span>
				</div>
			</div>
			
		</div>
		<div class="b-card-btn">
	       <button href="orderpay.html" class="fr"><?=yii::t('app','Sure')?></button>
       </div>
   </form>
<script>

$('#moneycash-money').blur(function(){
	var $this=$(this);
	var url=$this.attr('data-url');
	var data={
		'money':$this.val()
	};
	$.getJSON(url,data,function(data){
		if(data.success==1){
			$('span.money').text(data.info['money']);
			$('span.real_money').text(data.info['real_money']);
		}else{

		}
	})
});




	$('#verify_btn').click(function(e){
		var $this=$(this);
		var url=$this.attr('data-url');
		var text=$this.text();
		$.getJSON(url,'', function(data){
			if(data.success==1){
				var textTmp=60;
				$this.attr('disabled','disabled');
				$this.text(textTmp);

				var int=self.setInterval(function(){
					textTmp=textTmp-1;
					$this.text(textTmp);
					if(textTmp==0){
						$this.text(text);
						$this.removeAttr('disabled');
						window.clearInterval(int);
					}
				},1000)
			}
		});
		e.preventDefault();
	});
</script>