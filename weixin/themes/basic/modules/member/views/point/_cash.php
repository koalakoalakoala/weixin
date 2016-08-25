<?php 
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\service\ToolService;
// use common\enum\MoneyEnum;
use common\service\CommonService;

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
			'required'=>true,'placeholder'=>yii::t('app_member','input_point'),'data-url'=>Url::toRoute('getmoney')]) ?>
		</div>
		
		<div class="input-box-wrap">
			<div class="input-box">
				<label class="b-card-txt"><?=$memberModel->attributeLabels()['mobile']?></label>
				<div class="in-input-box r-fc">	
					<?=ToolService::setEncrypt($memberModel['mobile'],3,4,'*',4)?>
				</div>
				<input name='mobile' type='hidden' value='<?=$memberModel['mobile']?>'/>
			</div>
		</div>
	 
		<div class="input-box-wrap input-box-getwrap">
			<div class="dm-get-input">
				<?= $form->field($model, 'code',['options'=>['class'=>'control-group span8']])->textInput([
					'maxlength' => true,'number'=>true,
				'required'=>true,'placeholder'=>yii::t('app_member','input_validate_code')]) ?>
	        </div>

			<button class="dm-get-btn" id='verify_btn' 
				data-url='<?=Url::toRoute(['verify','mobile'=>$memberModel['mobile'],'type'=>CommonService::VERIFY_TYPE_POINT])?>'>
				<?=yii::t('app_member','get_validate_code')?>
			</button>
		</div>
		
		<div class="input-box-wrap mt10 bt">
			<div class="input-box">
				<label class="b-card-txt"><?=$model->attributeLabels()['money']?></label>
				<div class="in-input-box  r-fc">	
					<span class='money'><?=$model->money?></span>
				</div>
			</div>
		</div>
		<div class="input-box-wrap mt10 bt">
			<div class="input-box">
				<label class="b-card-txt"><?=$model->attributeLabels()['member_money']?></label>
				<div class="in-input-box  r-fc">	
					<span class='member_money'>￥<?=$model->member_money?></span>
				</div>
			</div>
		</div>
		<div class="b-card-btn">
	       <button class="fr"><?=yii::t('app','Sure')?></button>
       </div>
      </form>
<script>

$('#pointcash-money').blur(function(){
	var $this=$(this);
	var url=$this.attr('data-url');
	var data={
		'money':$this.val()
	};
	$.getJSON(url,data,function(data){
		if(data.success==1){
			$('span.money').text(data.info['money']);
			$('span.member_money').text(data.info['money']);
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