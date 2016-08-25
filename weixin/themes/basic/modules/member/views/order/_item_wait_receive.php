<?php
	use yii\helpers\Url;
	use common\service\SkuService;
	use common\service\OrderService;
	use common\enum\OrderBackEnum;
	use common\enum\OrderEnum;
?>
<!--  待支付的模块 S-->
<div class="phone-shopbox tjdd-center show-box1" id="<?=$model->id;?>">
	<div class="my-order-contain">
		<!-- 店铺关闭了点击店铺会弹出提示 ，未关闭会进入店铺页-->
        <a  <?php  if($model->store && $model->store->ischeck == 4){ ?> onclick="$.MsgBox.Alert('抱歉', '店铺已关闭！');" <?php } ?> href="<?= $model->store && $model->store->ischeck !=4 ? Url::to(['/store/store/view?id='.$model->store->id]) : "javascript:void(0);" ?>" class="shop-title cleafix tjdd-center-title">
            <?php if($model->store && $model->store->store_logo){?><span class=" my-index-icon"><img src="<?=Yii::$app->params['img_domain'].$model->store->store_logo ?>" style="width:25px;height:25px;margin-bottom: 30px;" /></span><?php } ?><span><?=$model->store ? $model->store->store_name : "未知店铺"?></span>
            <span  class="shop-jt"><span class="jt right"></span></span>
        </a>
		<div class=" tjdd-center-content ">
			<div class="home-tuan-lists iobrv intjdd-center-content inmy-order-centent">
					<div class="yf-list-line w400 clearfix">
						<!-- <div class="fl">收货人：<a href="<?=Url::to(['detail?id='.$model->id])?>" class="b-fc"><?=$model->sn?></a></div>-->
						<!-- <div class="fr"><?=date("Y-m-d H:i:s",$model->create_time)?></div>-->
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
			          	<?php
			          	$return = OrderService::isReturn($model->id,$v->sku_id);
			          	if(!$return){ ?>
							<?php if ($model->type != OrderEnum::TYPE_EXCHANGE) { ?>
								<div class=" clearfix">
									<div class="fr"><a href="<?=Url::to(['/member/order/return?order_id='.$model->id.'&og_id='.$v->id])?>" class="my-order-btn">申请退换货</a></div>
								</div>
							<?php } ?>
				        <?php }else{ ?>
			        	 	<?php
                        	    $type_str = OrderBackEnum::getHandleStatus(OrderBackEnum::BACK_TYPE,$return->back_type);
                            ?>
				        	<div class=" clearfix">
				        		<p class="fr">
				        			<?php if($return->back_type == OrderBackEnum::TYPE_CHANGE){ //换货商品确认收货?>
				        				<?php if($return->handle_status == OrderBackEnum::HANDLE_WAIT_RECEIVE){ ?>
				        					<a href="javascript:void(0);" goodsid="<?=$return->goods_id?>" backid="<?=$return->id?>" moregoods="<?=count($model->ordergoods) == 1 ? false : true ?>" onclick="changeEnsure(this)" orderid="<?=$model->id?>" class="my-order-btn">收货</a>
				        				<?php }else if($return->handle_status == OrderBackEnum::HANDLE_FINISH){ ?>
				        					<a href="<?=Url::to(['/member/order/return?order_id='.$model->id.'&og_id='.$v->id])?>" class="my-order-btn">申请退货</a>
				        				<?php }else{ ?>
				        					已申请<?=$type_str?>:<?=OrderBackEnum::getHandleStatus(OrderBackEnum::HANDLE_STATUS,$return->handle_status)?>
				        				<?php } ?>
				        			<?php }else{ //退货?>
				        				已申请<?=$type_str?>:<?=OrderBackEnum::getHandleStatus(OrderBackEnum::HANDLE_STATUS,$return->handle_status)?>
				        			<?php } ?>
				        		</p>
				        	</div>
				        <?php } ?>
	                 </div>
	            <?php $count += $v->number;} } ?>
	             <div class="yf-list-line clearfix">
					<!-- <div class="fl">共<b><?=$count?></b>件商品，运费10元</div> -->
					    <div class="fr">共<?=$count?>件商品，应实付 <span class="r-fc">¥ <b><?=$model->price?></b></span></div>
				</div>
				<div class="yf-list-line clearfix">
					<div class="yf-list-line clearfix">
						<div class="fl b-fc">待收货</div>
						<div class="fr"><a mid="<?=$model->id?>" onclick="ensure(this)" href="javascript:void(0);" class="my-order-btn">确认收货</a></div>
					</div>
				</div>
	       </div>
	    </div>
    </div>
</div>
<!--  待支付的模块  E-->

<script type="text/javascript">

	/**
	 * 整个订单确认收货
	 */
	function ensure(o)
	{
		$.MsgBox.Confirm("","真的要确认收货吗？",function(){
			var order_id = o.getAttribute("mid");
			var url = "<?=Url::to(['/member/order/ensure'])?>";
			$.post(url,{order_id:order_id,'_csrf':'<?=Yii::$app->request->csrfToken?>'},
	            function(data){
	                var res = eval('(' + data + ')');
	                if(parseInt(res.code) == 200){
	                	$("#"+order_id).hide();
	                }else{
	                	alert(res.msg);
	                }
	            }
	        );
		});
	}

	/**
	 * 换货商品确认收货
	 */
	function changeEnsure(o)
	{
		$.MsgBox.Confirm("","真的要确认收货吗？",function(){
			var back_id = o.getAttribute("backid");
			var goods_id = o.getAttribute("goodsid");
			var moregoods = o.getAttribute("moregoods");
			var orderid = o.getAttribute("orderid");
			var url = "<?=Url::to(['/member/order/change-ensure'])?>";
			$.post(url,{back_id:back_id,'_csrf':'<?=Yii::$app->request->csrfToken?>'},
	            function(data){
	                var res = eval('(' + data + ')');
	                if(parseInt(res.code) == 200){
	                	o.setAttribute('href',"<?=Url::to(['/member/order/return'])?>?order_id=<?=$model->id?>&og_id="+goods_id);
	                	o.removeAttribute("onclick");
	                	o.removeAttribute("goodsid");
	                	o.removeAttribute("backid");
	                	$(o).text("申请退换货");
	                	//没有更多商品，确认收到这个商品，会确认整个订单
	                	if(!moregoods){
	                		$("#"+orderid).hide();
	                	}
                        location.reload();
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