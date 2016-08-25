<?php 
	use yii\helpers\Html;
	use yii\helpers\Url;
?>
		<div class="index-content">
			<!--首页背景控制-->
			<div class="index-set fotterborder">

				<!-- Commodity list 商品列表-->
				<div class="d-commodity-list">
					<!-- tab 切换-->
					<div class="d-tab-background stick-tittle">
						<div class="d-tab-title">
							<a class="d-mod-nav-item d-mod-nav-cur" href="<?=Url::to(['goods-description?id='.$_GET['id']])?>">图文详情</a>
							<a class="d-mod-nav-item" href="<?=Url::to(['goods-attr?id='.$_GET['id']])?>">商品参数</a>
							<!--<a class="d-mod-nav-item" href="<?/*=Url::to(['comments?id='.$_GET['id']])*/?>">商品评价</a>-->
						</div>
					</div>

					<!--隐藏域，存放当前选中sku-->
					<input type="hidden" value="<?=$detail['goods']->defaultSku->sku_id?>" id="skuId" />
					<!--隐藏域，存放当前选中sku-->
					<input type="hidden" value="<?=$detail['goods']->defaultSku->count->stock?>" id="stock"/>

					<a id="sku_attr" class="item" onclick="" href="#" style="display:none;">
						规格
						<span class="parameter" id="currentSku">
							<?php foreach(array_values($detail['defaultSkuAttr']) as $v1){ ?>
							<i><?=$v1 ?></i>
							<?php } ?>
						</span>
						<i class="arrowent"></i>
					</a>


					<!-- 产品详情-->
					<div class="d-tab-detailp"><?=html_entity_decode($description) ?></div>

				</div>


			</div>

		</div>


	

<script type="text/javascript">
	$(function(){
		/*$("#sku_attr").click(function(){
			$("#sku_box").show();
		})*/
		$("#close").click(function(){
			$("#sku_box").hide();
		})
		$("#mainAddToCart").click(function(){
			$("#sku_box").show();
		})
		$("#mainBuyNow").click(function(){
			$("#sku_box").show();
		})
	})


	var startTime = new Date().getTime();
	var keys = <?=json_encode($detail['sku_attr']['keys'])?>;
	var data = <?=$detail['sku_attr']['data']?>;


var topm = $('.stick-tittle').offset().top-30;
	$(window).scroll(function() {
		if ($(window).scrollTop() >= topm) {
			$(".stick-tittle").addClass("dm-fixedtop");
		} else {
			$(".stick-tittle").removeClass("dm-fixedtop");
		}
	});


//关闭弹出框
	function closediv(){
		$("#add_cart_success_box").hide();
		window.location.reload();
	}

</script>