<?php
	use yii\helpers\Url;
	use common\service\SkuService;
?>
<!--  待支付的模块 S-->
<div class="phone-shopbox tjdd-center show-box1" id="<?=$model->id;?>">
	<div class="my-order-contain">
		<!-- 店铺关闭了点击店铺会弹出提示 ，未关闭会进入店铺页-->
           <!--  <a  <?php  if($model->store && $model->store->ischeck == 4){ ?> onclick="$.MsgBox.Alert('抱歉', '店铺已关闭！');" <?php } ?> href="<?= $model->store && $model->store->ischeck !=4 ? Url::to(['/store/store/view?id='.$model->store->id]) : "javascript:void(0);" ?>" class="shop-title cleafix tjdd-center-title">
            <span class=" my-index-icon"><img src="<?=$model->store ? Yii::$app->params['img_domain'].$model->store->store_logo : '' ?>" style="width:25px;height:25px;margin-bottom: 30px;" /></span><span><?=$model->store ? $model->store->store_name : "未知店铺"?></span>
            <span  class="shop-jt"><span class="jt right"></span></span>
        </a>-->
		<div class=" tjdd-center-content ">
			<div class="home-tuan-lists iobrv intjdd-center-content inmy-order-centent">
					<div class="yf-list-line w400 clearfix r-fc">
					<!-- 	<div class="fl">收货人：<a href="<?=Url::to(['detail?id='.$model->id])?>" class="b-fc"><?=$model->sn?></a></div>-->
					<!-- 	<div class="fr"><?=date("Y-m-d H:i:s",$model->create_time)?></div>-->
                    <div class="fr r-fc">待支付</div>
					</div>
				<?php
                    if($model->ordergoods){
                    $count = 0;
                    foreach($model->ordergoods as $k => $v){
                ?>
			    	<div class="dm-item Fix my-order-item">
			    		<!-- 店铺关闭了点击店铺会弹出提示 ，未关闭会进入商品详情页-->
                        <a <?php  if($model->store && $model->store->ischeck == 4){ ?> onclick="$.MsgBox.Alert('抱歉', '店铺已关闭，商品已下架！');" <?php } ?>  href="<?=$model->store && $model->store->ischeck ==4 ? 'javascript:void(0)' : Url::to(['/goods/goods/view?id='.$v->goods_id])?>">
				            <div class="cnt shopcont shopcont_p">
				            	<div class="shoppr"><img class="pic" src="<?=$v->goodsSku->goods->goodsgallery? Yii::$app->params['img_domain'].$v->goodsSku->goods->goodsgallery->image : '' ?>" alt=""></div>
					            <div class="content-wrap ">
						             <div class="content-wrap2">
							            <div class="shop-content ">
							                <div class="title clearfix"><span class="in-tit fl zd-width"><?=$v->goodsSku->goods->name?></span><div class="sc-btn fr zdc-top"><span class="r-fc">¥<?=$v->goodsSku->market_price + $v->goodsSku->goods->freight?></span><br/><!--<span>数量 :×<?=$v->number?></span>--></div></div>
							                <div class="shop-des" ><?=SkuService::searchSkuAttrNameValue($v->goodsSku)?></div>
						               </div>
					               </div>
				               </div>
				            </div>
			          	</a>
	                 </div>
	            <?php $count += $v->number;} } ?>
	             <div class="yf-list-line clearfix">
					<!-- <div class="fl">共<b><?=$count?></b>件商品，运费10元</div> -->
				    <div class="fr">共<?=$count?>件商品，应实付 <span class="r-fc">¥ <b><?=$model->price?></b></span></div>
				</div>
				<div class="yf-list-line clearfix">
				
					<div class="fr"><a mid="<?=$model->id?>"  onclick="cancle(this);" href="javascript:void(0);" class="my-order-btn">取消订单</a><a href="<?=Url::to(['/order/payment/index?order_id='.$model->id])?>" class="my-order-btn zd-pay">付款</a></div>
				</div>
	       </div>
	    </div>
    </div>
</div>
<!--  待支付的模块  E-->

<script type="text/javascript">
	function cancle(o)
	{
		$.MsgBox.Confirm("","确定要取消订单吗？",function(){
			var order_id = o.getAttribute("mid");
			var url = "<?=Url::to(['/member/order/cancle'])?>";
			$.post(url,{order_id:order_id,'_csrf':'<?=Yii::$app->request->csrfToken?>'},
	            function(data){
	                var res = eval('(' + data + ')');
	                if(parseInt(res.code) == 200){
	                	$("#"+order_id).hide();
						if(res.wait_pay_count == 0){
							$(".click-btn1").children("span").children(".sup").remove();
						} else {
							$(".click-btn1").children("span").children(".sup").html(res.wait_pay_count);
						}
	                }else{
	                	alert(res.msg);
	                }
	            }
	        );
		});
	}

	$(function(){
 	$(window).each(function(){
 		if($(this).width()<400){
 			$('.w400').removeClass('clearfix');
 			$('.w400').children().removeClass();
 		}
 	});
 })
</script>