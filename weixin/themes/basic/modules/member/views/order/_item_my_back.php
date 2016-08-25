<?php
	use common\enum\OrderBackEnum;
	use common\service\SkuService;
?>

<div class=" tjdd-center bt bb mt10">
	<div class="my-order-contain">

		<div class=" tjdd-center-content ">
			<div class="home-tuan-lists iobrv intjdd-center-content inmy-order-centent">
				<div class="yf-list-line">
					<div >服务单号：<span><?=$model->order_sn?></span></div>
				</div>
		    	<div class=" my-order-item my-return-item">
			            <div class="cnt shopcont shopcont_p">
							<?php if ($model->back_type != OrderBackEnum::TYPE_RETURN_MONEY) { ?>
							<div class="shoppr"><img class="pic" src="<?=$model->goods->goodsgallery? Yii::$app->params['img_domain'].$model->goods->goodsgallery->image : '' ?>" alt=""></div>
							<?php } ?>
							<div class="content-wrap ">
					             <div class="content-wrap2">
						            <div class="shop-content return-shop-content">
										<?php if ($model->back_type != OrderBackEnum::TYPE_RETURN_MONEY) { ?>
											<div class="title "><span class="in-tit"><?=$model->goods->name.'--'.SkuService::searchSkuAttrNameValue($model->sku)?></span></div>
										<?php } ?>
										<div class="g-fc lh20 mt5" >服务类型 : <span class="rcf"><?=OrderBackEnum::getBackType($model->back_type)?></span></div>
										<div class="g-fc lh20" >服务状态 : <span class="bl-fc"><?=OrderBackEnum::getHandleStatus(OrderBackEnum::HANDLE_STATUS,$model->handle_status)?></span></div>
										<div class="g-fc lh20" >所属订单：<a href="#" class="b-fc"><?=$model->order->sn?></a></div>
					               </div>
				               </div>
			               </div>
			            </div>
	             </div>
				<div class="yf-list-line ">
					<div class=" "><span class="dm-icon my-return-icon"></span>申请时间：<?=date("Y-m-d H:i:s",$model->create_time)?></div>
				</div>
	       </div>
	    </div> 
	  </div>
</div>