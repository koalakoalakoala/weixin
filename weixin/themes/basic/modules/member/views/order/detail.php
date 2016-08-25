<?php
use common\enum\OrderEnum;
use common\enum\OrderBackEnum;
use yii\helpers\Url;
use common\service\SkuService;
use common\service\OrderService;
$this->title = "订单详情";
?>
<div class="mod_container">
	<!--order-detail-top 顶部信息 S-->
	
	  <!--静态页面加的收货人信息 S-->
		<div class="order-detail-top mt10">
			<div class="clearfix fw-b">收货人：<?=$model->deliveryinfo->username?>（<?=$model->deliveryinfo->mobile?>）
				<?php
				if($model->orderstatus == OrderEnum::WAITING_PAYMENT){
					echo "<span class=\"fr r-fc\">待付款</span>";
				} else if($model->orderstatus == OrderEnum::ALREADY_PAYMENT){
					echo "<span class=\"fr b-fc\">已支付</span>";
				} else if($model->orderstatus == OrderEnum::WAITING_SHIP) {
					echo "<span class=\"fr r-fc\">待发货</span>";
				} else if($model->orderstatus == OrderEnum::WAITING_RECEVE){
					echo "<span class=\"fr b-fc\">已发货</span>";
				} else if($model->orderstatus == OrderEnum::FINISHED){
					echo "<span class=\"fr gr-fc\">已完成</span>";
				} else if($model->orderstatus == OrderEnum::CANCELD){
					echo "<span class=\"fr\">订单已取消</span>";
				} else if($model->orderstatus == OrderEnum::RETURN_MONEY){
					echo "<span class=\"fr gy-fc\">已退款</span>";
				}
				?>
			</div>
			<div class="g-fc f12 mt10"><?=$model->deliveryinfo->address?></div>
		</div>
	  <!--静态页面加的收货人信息 E-->
	
	<!--<div class="order-detail-top mt10">
		<div class="clearfix fw-b">收货人：<?=$model->sn?>
			<span class="fr r-fc">

			</span>
		</div>
		<div class="g-fc f12 mt10"><?=$model->deliveryinfo ? $model->deliveryinfo->address : ''?></div>
		<div class="g-fc fw-b mt10"><?=$model->deliveryinfo ? $model->deliveryinfo->mobile : ''?></div>
	</div>-->
	<!--顶部信息 E-->
<!-- order-detail-center 订单详情内容 S-->
	 <div class="phone-shopbox tjdd-center mq-tjdd-center show-box2">
	    <div class="my-order-contain">
	        <!-- 店铺关闭了点击店铺会弹出提示 ，未关闭会进入店铺页-->
        <!--	<a  <?php  if($model->store && $model->store->ischeck == 4){ ?> onclick="$.MsgBox.Alert('抱歉', '店铺已关闭！');" <?php } ?> href="<?= $model->store && $model->store->ischeck !=4 ? Url::to(['/store/store/view?id='.$model->store->id]) : "javascript:void(0);" ?>" class="shop-title cleafix tjdd-center-title">
	          <span class=" my-index-icon"><img src="<?=$model->store ? Yii::$app->params['img_domain'].$model->store->store_logo : '' ?>" style="width:25px;height:25px;margin-bottom: 30px;" /></span><span><?=$model->store ? $model->store->store_name : "未知店铺"?></span>
	            <span  class="shop-jt"><span class="jt right"></span></span>
	        </a>-->
	       <div class=" tjdd-center-content ">
				<div class="home-tuan-lists  intjdd-center-content inmy-order-centent order-detail-ct">
			    	<!--静态页面加的商品 S-->
			    	<?php
						$count = 0;
						$goodsCost = 0;
	                    if($model->ordergoods){
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
	                                                <div class="title clearfix">
														<a <?php  if($model->store && $model->store->ischeck == 4){ ?> onclick="$.MsgBox.Alert('抱歉', '店铺已关闭，商品已下架！');" <?php } ?>  href="<?=$model->store && $model->store->ischeck ==4 ? 'javascript:void(0)' : Url::to(['/goods/goods/view?id='.$v->goods_id])?>">
															<span class="in-tit zd-width fl">
																<?=$v->goodsSku->goods->name?></span>
														</a>
													<div class="sc-btn fr zdc-top"><span class="r-fc">¥<?=$v->goodsSku->market_price + $v->goodsSku->goods->freight?></span><br/><!--<span>数量 :×<?/*=$v->number*/?></span>--></div></div>
	                                                <div class="shop-des" ><?=SkuService::searchSkuAttrNameValue($v->goodsSku)?></div>
													<div class="shop-des"><span>数量 :×<?=$v->number?></span></div>
	                                           </div>
	                                       </div>
	                                   </div>
	                                </div>
	                             </a>

	                            <?php
	                            $return = OrderService::isReturn($model->id,$v->sku_id);

	                            if(!$return){
	                                if($model->orderstatus == OrderEnum::WAITING_RECEVE){
	                            ?>
	                            <div class=" clearfix">
	                                <div class="fr action_item_<?=$model->id?>"><a href="<?=Url::to(['/member/order/return?order_id='.$model->id.'&og_id='.$v->id])?>" class="my-order-btn">申请退货</a></div>
	                            </div>
	                            <?php } }else{ ?>
	                                <div class=" clearfix">
	                                    <?php
	                                        $type_str = OrderBackEnum::getHandleStatus(OrderBackEnum::BACK_TYPE,$return->back_type);
	                                    ?>
	                                    <p class="fr">已申请<?=$type_str?>:<?=OrderBackEnum::getHandleStatus(OrderBackEnum::HANDLE_STATUS,$return->handle_status)?></p>
	                                </div>
	                            <?php } ?>
						</div>
						<!--静态页面加的商品 E-->
	                 <?php $count += $v->number;
						$goodsCost += $v->number * ($v->goodsSku->market_price + $v->goodsSku->goods->freight);
						} } ?>
	                 <div class="yf-list-line clearfix">
						 <div class="fl">商品数量</div>
						<div class="fr "><?=$count?></div>
					</div>
		             <div class="yf-list-line clearfix">
						 <div class="fl">商品总价</div>
						<div class="fr ">￥<?=$goodsCost?></div>
					</div>
						<!--<div class="fl">+运费</div>
						<div class="fr">￥10.00</div>
					</div>-->
					<div class="yf-list-line clearfix">
						<div class="fl">米券抵扣</div>
						<div class="fr ">￥<?=$model->quan?></div>
					</div>
					<div class="yf-list-line clearfix">
						<div class="fl">订单总额</div>
						<div class="fr ">￥<?=$model->price?></div>
					</div>
					<div class="yf-list-line clearfix">
						<div class="fl">需实付</div>
						<div class="fr r-fc"><b>￥<?=$model->price?></b></div>
					</div>
					<?php if($model->express){ ?>
						<div class="yf-list-line clearfix">
							<div class="g-fc">订单编号：<?=$model->sn?></div>
							<div class="g-fc">创建时间：<?=date("Y-m-d H:i:s", $model->create_time)?></div>
							<div class="g-fc">物流公司：<?=$model->express->name?></div>
							<div class="g-fc">物流单号：<?=$model->ex_no?></div>
						</div>
					<?php } ?>

					<?php if($model->orderstatus == OrderEnum::WAITING_RECEVE){ ?>
						<div class="tjdd-btn clearfix">
							<div class="in-paysuc-btn clearfix">
								<div class="paysuc-btn-box paysuc-btn-boxp"><div class="in-paysuc-btn-box"><a href="javascript:void(0)" onclick="ensure()" class="fr ">确认收货</a></div></div>
							</div>
						</div>
					<?php } ?>

					<?php if($model->orderstatus == OrderEnum::FINISHED){ ?>
					<div class="tjdd-btn clearfix">
						<div class="in-paysuc-btn clearfix">
							<div class="paysuc-btn-box paysuc-btn-boxp"><div class="in-paysuc-btn-box"><a <?php  if($model->store && $model->store->ischeck == 4){ ?> onclick="$.MsgBox.Alert('抱歉', '店铺已关闭，商品已下架！');" <?php } ?>  href="<?=$model->store && $model->store->ischeck ==4 ? 'javascript:void(0)' : Url::to(['/goods/goods/view?id='.$v->goods_id])?>" class="fr ">再次购买</a></div></div>
						</div>
					</div>
					<?php } ?>
	             </div>
			   </div>
	       </div>

	 </div>
	<!--底部物流信息 E-->
	<!-- order-detail-center 订单详情内容 E-->
</div>

<script type="text/javascript">
	function ensure()
	{
		$.MsgBox.Confirm("","真的要确认收货吗？",function(){
			var order_id = <?=$model->id?>;
			var url = "<?=Url::to(['/member/order/ensure'])?>";
			$.post(url,{order_id:order_id,'_csrf':'<?=Yii::$app->request->csrfToken?>'},
				function(data){
					var res = eval('(' + data + ')');
					if(parseInt(res.code) == 200){
						location.reload();
					}else{
						$.MsgBox.Alert("",res.msg);
					}
				}
			);
		});
	}
</script>