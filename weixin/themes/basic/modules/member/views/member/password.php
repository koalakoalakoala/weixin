<?php 
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\service\ToolService;
// use common\enum\MoneyEnum;
use common\service\CommonService;
$this->title = Yii::t('app_member', 'update_password');
$this->params['breadcrumbs'][] = $this->title;
?>
  

<div class=" tjdd-center-content my-jftx-content">
<?php $form = ActiveForm::begin([
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
	<div class="input-box">
		<label class="b-card-txt"><?=$model->attributeLabels()['mobile']?></label>
		<div class="in-input-box r-fc">	
			<?=ToolService::setEncrypt($model['mobile'],3,4,'*',4)?>
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
				data-url='<?=Url::toRoute(['verify','mobile'=>$model['mobile'],'type'=>CommonService::VERIFY_TYPE_PWD])?>'>
				<?=yii::t('app_member','get_validate_code')?>
			</button>
</div>
	
	<div class="input-box-wrap">
		<?= $form->field($model, 'password',['options'=>['class'=>'form-group span8']])->passwordInput(['maxlength' => true]) ?>
	</div>
	
	<div class="input-box-wrap">
		<?= $form->field($model, 'password_repeat',['options'=>['class'=>'form-group span8']])->passwordInput(['maxlength' => true]) ?>
		 <div class="my-txcard-tip">*密码长度至少6个字符，最多不超过32个字符</div>
	</div>
						
		 <div class="b-card-btn dm-popup-btn">
			<button class="">确定修改</button>
		 </div>
	 </form>
</div>
		<!-- b-card-content 添加银行卡内容 E--> 
  <!--弹框内容 S-->
<div class="d-bodybg dm-popup-box hidden">
	<div class="d-bodyeject d-minheight">
		<div class="body_contr">
			<div class="chenker">
				<span class="correct"></span>
				<p class="wordker">修改密码成功</p>

			</div>
			<div class="btn-jion pkvoir">
				<div class="btn-zir dm-bomb-btn"><a href="#">确定</a></div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	

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

	// $('form').ajaxSubmit({
	// 	success:function(data){

	// 	},
	// 	dataType:'json'
	// });

</script>