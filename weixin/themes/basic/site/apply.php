<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\enum\CreditProductEnum;

$this->title = Yii::t('app', '申请恒昌精英贷');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin([
        'id' => 'member-form',
        'options' => ['class' => 'form-horizontal bui-form-horizontal bui-form bui-form-field-container'],
        'fieldConfig' => [
        'template' => "{label}\n<div class=\"controls\">{input}<span class=\"valid-text\">{error}</span></div>",
        'labelOptions' => ['class' => 'lable-text control-label'],
        'errorOptions'=>['class'=>'valid-text']
        ],
]); ?>
 <!--xdcs-content  begin-->
<div class="xdcs-content">
    <h2>申请恒昌精英贷</h2>
       <!--xd-content-center  begin-->
    <div class="xd-content-center">
     <!--xdcc-list  begin-->
         <!--xdcc-inputbox  begin-->
            <div class="xdcc-inputbox">
                <label class="xdcc-card-txt">申请金额<i>*</i></label>
                <div class="xdcc-input ">
                    <?= $form->field($model, 'loan_money',['options'=>['class'=>'control-group span8']])->textInput(['placeholder'=>"请输入该产品额度范围内的金额"])->label(false)?>
                </div>
            </div>
            <div class="xdcc-valid-text">请输入1万-30万范围内的金额</div>
            <!--div class="xdcc-valid-text">您输入的金额有误，请重新输入！</div>
             <!--xdcc-inputbox  end-->
              <!--xdcc-inputbox  begin-->
            <div class="xdcc-inputbox">
                <label class="xdcc-card-txt">借款期限<i>*</i></label>
                <div class="xdcc-input">
                    <?= $form->field($model, 'loan_date',['options'=>['class'=>'control-group span8']])->dropDownList(CreditProductEnum::getList())->label(false)?>
                    <!--div class="xdcc-select">请选择
                    </div-->
                    <span class="xdcc-icon"></span> 
                 <!--xdcc-inputbox  end-->
                  <!--xdcc-inputbox  begin-->
                </div>
            </div>
            <!--div class="xdcc-valid-text">请选择相应选项！</div-->
             <!--xdcc-inputbox  end-->
              <!--xdcc-inputbox  begin-->
            <div class="xdcc-inputbox">
                <label class="xdcc-card-txt">联系电话<i>*</i></label>
                <div class="xdcc-input ">
                    <?= $form->field($model, 'borrower_mobile',['options'=>['class'=>'control-group span8']])->textInput(['placeholder'=>"请输入真实有效的手机号"])->label(false)?>
                </div>
            </div>

            <!--div class="xdcc-valid-text">您输入的格式不正确，请重新输入！</div-->
             <!--xdcc-inputbox  end-->
              <!--xdcc-inputbox  begin-->
            <div class="xdcc-inputbox">
                <label class="xdcc-card-txt">姓名<i>*</i></label>
                <div class="xdcc-input ">
                    <?= $form->field($model, 'borrower_name',['options'=>['class'=>'control-group span8']])->textInput(['placeholder'=>"请输入真实姓名"])->label(false)?>
                </div>
            </div>
            <!--div class="xdcc-valid-text">您输入的格式不正确，请重新输入！</div-->
             <!--xdcc-inputbox  end-->
              <!--xdcc-inputbox  begin-->
            <div class="xdcc-inputbox">
                <label class="xdcc-card-txt">身份证号<i>*</i></label>
                <div class="xdcc-input ">
                    <?= $form->field($model, 'borrower_num',['options'=>['class'=>'control-group span8']])->textInput(['placeholder'=>"请输入与姓名一致的身份证号"])->label(false)?>
                </div>
            </div>
            <!--div class="xdcc-valid-text">您输入的身份证号有误，请重新输入！</div-->
             <!--xdcc-inputbox  end-->
              <!--xdcc-inputbox  begin-->
            <div class="xdcc-inputbox">
                <label class="xdcc-card-txt">户口所在地<i>*</i></label>
                <div class="xdcc-input">
                    <?= $form->field($model, 'account_location',['options'=>['class'=>'control-group span8']])->textInput(['placeholder'=>"户口所在城市名称"])->label(false)?>
                </div>
            </div>
            <!--div class="xdcc-valid-text">您输入的有误，请重新输入！</div-->
             <!--xdcc-inputbox  bend-->
              <!--xdcc-inputbox  begin-->
            <div class="xdcc-inputbox">
                <label class="xdcc-card-txt">婚姻状态<i>*</i></label>
                <div class="xdcc-input ">
                    <?= $form->field($model, 'marriage_status',['options'=>['class'=>'control-group span8']])->dropDownList(CreditProductEnum::getWeddingList())->label(false)?>
                    <span class="xdcc-icon"></span> 
                </div>
            </div>
             <!--xdcc-inputbox  end-->
              <!--xdcc-inputbox  begin-->
            <div class="xdcc-inputbox">
                <label class="xdcc-card-txt">最高学历<i>*</i></label>
                <div class="xdcc-input ">
                    <!--div class="xdcc-select2">请选择
                    </div--> 
                    <?= $form->field($model, 'education_status',['options'=>['class'=>'control-group span8']])->dropDownList(CreditProductEnum::getRecordList())->label(false)?>
                    <span class="xdcc-icon"></span> 
                </div>
            </div>
             <!--xdcc-inputbox  end-->
              <!--xdcc-inputbox  begin-->
            <div class="xdcc-inputbox">
                <label class="xdcc-card-txt">现居住地<i>*</i></label>
                <div class="xdcc-input ">
                    <?= $form->field($model, 'account_location',['options'=>['class'=>'control-group span8']])->textInput(['placeholder'=>"填写当前居住地详细地址"])->label(false)?> 
                </div>
            </div>

            <!--div class="xdcc-valid-text">您输入的有误，请重新输入！</div-->
             <!--xdcc-inputbox  end-->
              <!--xdcc-inputbox  begin-->
            <div class="xdcc-inputbox">
                <label class="xdcc-card-txt">QQ号</label>
                <div class="xdcc-input">
                    <?= $form->field($model, 'qq',['options'=>['class'=>'control-group span8']])->textInput(['placeholder'=>"如无可不填"])->label(false)?> 
                </div>
            </div>
             <!--xdcc-inputbox  end-->
         <!--xdcc-list  end-->
    </div>
       <!--xd-content-center  end-->
          <!--xdcs-apply  begin-->
    <div class="xdcs-apply button">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', '立即申请') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'xdcs-apply-button' : 'btn btn-primary']) ?>
        <div class="xdcs-inputbox clearfix">
            <label class="checkbox fl">
                <input type="checkbox" name="ApplyForm[agreement]" checked="checked" id="CheckboxGroup1_0"> <i class="check"></i> </label>
            <div class="xdcs-agree">我已阅读并同意<a href="#">《贷款协议》</a></div>
            <div id="error_agreement"> </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js">
</script>
<script type="text/javascript">
    $(function(){
      //点击表单
        $(".xdcc-text,.xdcc-select").click(function(){
            $(".xdcc-input").removeClass('xdcc-border');
            $(this).parents(".xdcc-input").addClass('xdcc-border');
        });

        /*弹窗 S*/
         $('.xdcc-select').click(function(){
              $('.bomb-box,.bomb-main-ul').show();
                 $('.bomb-main-ul1,.bomb-main-ul2').hide();
         });
           $('.xdcc-select1').click(function(){
              $('.bomb-box,.bomb-main-ul1').show();
                 $('.bomb-main-ul,.bomb-main-ul2').hide();
                      });
          $('.xdcc-select2').click(function(){
                     $('.bomb-box,.bomb-main-ul2').show();
                        $('.bomb-main-ul1,.bomb-main-ul').hide();
                             });
         $('.bom-close').click(function(){
                $('.bomb-box ').hide();
           });
         $('.bomb-box li').click(function(){
                $('.bomb-box ').hide();
                $('.bomb-box li').find('i').removeClass('checkimg');
                $(this).find('i').addClass('checkimg');
                var text=$(this).text();
                if($(this).parent().hasClass('bomb-main-ul')){
                	$('.xdcc-select').text(text);
                }
                else if($(this).parent().hasClass('bomb-main-ul1')){
                	$('.xdcc-select1').text(text);
                }
                else if($(this).parent().hasClass('bomb-main-ul2')){
                	$('.xdcc-select2').text(text);
                }
           });
          $('.checkbox i').click(function(){
          	 $(this).toggleClass('check');
          });
    })
    /*弹窗 E*/
</script>

<style type="text/css">
    .valid-text {
        color: red;
    }
</style>