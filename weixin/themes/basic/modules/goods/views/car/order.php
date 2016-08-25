<?php
use yii\bootstrap\ActiveForm;
use common\enum\SexEnum;
/**
 * @author xiaomalover <xiaomalover@gmail.com>
 * @created 2016/5/27 14:46
 */
$this->title = "确认订单";
?>

<div class="mod_container">
    <div class="my-comment-form mt10 zdc-color bt">
        <?php $form = ActiveForm::begin([
            'id' => 'car-order-form',
            'options' => ['class' => 'intjdd-center-content b-card-centent my-jftx-center order-detail-center'],
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
                'errorOptions' => ['style'=>'color:red;margin-bottom:5px;margin-left:100px;']
            ],
        ]); ?>
            <div class="home-tuan-lists  intjdd-center-content inmy-order-centent order-detail-ct">
                <div class="dm-item Fix my-order-item">
                    <a href="#">
                        <div class="cnt shopcont shopcont_p">
                            <div class="shoppr"><img class="pic" src="<?=$sku->goods->goodsgallery? Yii::$app->params['img_domain'].$sku->goods->goodsgallery->image : '' ?>" alt=""></div>
                            <div class="content-wrap ">
                                <div class="content-wrap2">
                                    <div class="shop-content ">
                                        <div class="title clearfix"><span class="in-tit zname fl"><?=$sku->goods->name?>[订金]</span></div>
                                        <div class="g-fc">规格：<?=$sku_attrs?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="order-detail-top mt10">
                <div class="clearfix">购买数量<span class="fr b-fc zd-textcolor2">x<?=isset($_GET['num']) ? $_GET['num'] : 1?></span></div>
            </div>

        <div class="z-dbox">
            <div class="z-flex">
                <?= $form->field($model, 'name', ['options' => ['class' => 'input-box-wrap']])
                    ->textInput(['class'=>'input-box-wrap','placeholder'=>'请输入您的真实姓名']) ?>
            </div>

            <input type="hidden" name="CarOrder[sex]" id="sex" />
            <div class="in-radio-box">
			   <span class="tag">男</span>&nbsp;
			   <input onclick="selectMan()" type="radio" id="radio-1-1" name="radio-1-set" class="regular-radio" checked /><label for="radio-1-1"></label>
		       <span class="tag ml10">女</span>&nbsp;
			   <input onclick="selectWoman()" type="radio" id="radio-2-1" name="radio-1-set" class="regular-radio big-radio" checked /><label for="radio-2-1"></label>
		   </div>
         </div>

                <?= $form->field($model, 'mobile', ['options' => ['class' => 'input-box-wrap']])
                    ->textInput(['class'=>'input-box-wrap','placeholder'=>'仅限大陆地区手机号']) ?>

            <div class="input-box-wrap">
                <div class="input-box">
                    <span>共<?=(isset($_GET['num']) ? $_GET['num'] : 1)?>件商品，合计：<b class="zd-textcolor">￥<?=$sku->market_price * (isset($_GET['num']) ? $_GET['num'] : 1)?></b></span>
                </div>
            </div>

    </div>
    <div class="zdo-content">
        <div class="my-sign-top bt bb">
            <div class="in-my-sign-top">
                <div class="my-sign-top-info">
                    <div class="txt">您本次购买的商品无需收货地址，请您仔细确认每个购买商品的详细信息，如手机号；</div>
                    <div class="img"><img src="/img/tip-bear.gif"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="zd-deposit">
        <span>关于订金</span>
    </div>
    <div class="zd-instructions">
               <p class="zd-instructions-input">关于订金关于订金关于订金关于订金关于订金关于订金关于订金关于订金关于订金关于订金关于订金关于订金关于订金关于订金关于订金关于订金关于订金关于订金关于订金关于订金关于订金关于订金关于订金关于订金</p>
    </div>
    <!--<div style="height: 50px;"></div>-->
    <div class="stjm-footerbox bt">
	    <div class="b-card-btn z-sure-order">
	        <button type="submit" class="fr">提交订单</button>
	    </div>
    </div>
    <?php ActiveForm::end(); ?>

    <!--底部物流信息 E-->
    <!-- order-detail-center 订单详情内容 E-->
</div>
<script type="text/javascript">
    $('.shop-icon').click(function(){
        if (!$(this).hasClass("select")){
            $(this).removeClass('no-select');
            $(this).addClass('select');
            $(this).parent().siblings().find('.dm-item-sel').removeClass('no-select');
            $(this).parent().siblings().find('.dm-item-sel').addClass('select');
            if(!$(this).parents('.mod_container').find('.shop-icon').hasClass("no-select"))	{
                if(!$(this).parents('.mod_container').find('.dm-item-sel').hasClass("no-select")){
                    $('.allitem-btn').removeClass('no-select');
                    $('.allitem-btn').addClass('select');
                }else{
                    $('.allitem-btn').removeClass('select');
                    $('.allitem-btn').addClass('no-select');
                }
            }
            else {
                $('.allitem-btn').removeClass('select');
                $('.allitem-btn').addClass('no-select');
            }
        }else{
            $(this).removeClass('select');
            $(this).addClass('no-select');
            $(this).parent().siblings().children().children('.dm-item-sel').removeClass('select');
            $(this).parent().siblings().children().children('.dm-item-sel').addClass('no-select');
            if(!$(this).parents('.mod_container').find('.shop-icon').hasClass("no-select"))	{
                if(!$(this).parents('.mod_container').find('.dm-item-sel').hasClass("no-select")){
                    $('.allitem-btn').removeClass('no-select');
                    $('.allitem-btn').addClass('select');
                }else{
                    $('.allitem-btn').removeClass('select');
                    $('.allitem-btn').addClass('no-select');
                }
            }
            else {

                $('.allitem-btn').removeClass('select');
                $('.allitem-btn').addClass('no-select');
            }
        }

    });

    $('.dm-item-sel').click(function(){
        if(!$(this).hasClass("select")){
            $(this).removeClass('no-select');
            $(this).addClass('select');
        }else{
            $(this).removeClass('select');
            $(this).addClass('no-select');
        }
        if(!$(this).parents('.phone-shopbox').find('.dm-item-sel').hasClass("select")){
        }else{

        }
        if(!$(this).parents('.mod_container').find('.dm-item-sel').hasClass("no-select")){
            $('.allitem-btn').removeClass('no-select');
            $('.allitem-btn').addClass('select');
        }else{
            $('.allitem-btn').removeClass('select');
            $('.allitem-btn').addClass('no-select');

        }
    });

    $('.allitem-btn').click(function(){
        if(!$(this).hasClass("select")){
            $(this).removeClass('no-select');
            $(this).addClass('select');
            $(this).parents('.phone-shopbox ').siblings().find('.dm-item-sel').removeClass('no-select');
            $(this).parents('.phone-shopbox ').siblings().find('.dm-item-sel').addClass('select');
            $(this).parents('.phone-shopbox ').siblings().find('.shop-icon').removeClass('no-select');
            $(this).parents('.phone-shopbox ').siblings().find('.shop-icon').addClass('select');
        }else{
            $(this).removeClass('select');
            $(this).addClass('no-select');
            $(this).parents('.phone-shopbox ').siblings().find('.dm-item-sel').removeClass('select');
            $(this).parents('.phone-shopbox ').siblings().find('.dm-item-sel').addClass('no-select');
            $(this).parents('.phone-shopbox ').siblings().find('.shop-icon').removeClass('select');
            $(this).parents('.phone-shopbox ').siblings().find('.shop-icon').addClass('no-select');
        }
    });


    $('.sc-btn').click(function(){
        var box=$(this).parents('div.phone-shopbox');
        $(this).parents('.dm-item').remove();
        if(box.children('.home-tuan-lists').find('.dm-item').length<1){
            box.remove();
        }
    });
    $(function() {
        $("#sex").val(<?=SexEnum::SEX_WOMAN?>);
        $('bujivrt').click(function () {
            var a = $('.product_num').val;
            $('.pay-allcont').text(a);
        });

    })

    function selectMan()
    {
        $("#sex").val(<?=SexEnum::SEX_MAN?>);
    }

    function selectWoman()
    {
        $("#sex").val(<?=SexEnum::SEX_WOMAN?>);
    }
</script>
