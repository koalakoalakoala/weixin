<?php
use yii\helpers\Url;
use common\service\OrderService;
use common\service\ZdApiService;
use common\service\SpecialCategoryService as SpcService;
$this->title="商品详情";
?>
<!-- product detail 商品详情-->
<!-- product banner-->
<?php if($detail){ ?>
<!--隐藏域，存放当前选中sku-->
<input type="hidden" value="" id="skuId" />
<!--隐藏域，存放当前选中sku-->
<input type="hidden" value="" id="stock" />
	<div class="addWrap">
		<div class="swipe" id="mySwipe">
			<div class="swipe-wrap">
				<?php if($detail['images']) {
					foreach($detail['images'] as $image){
					echo '<div><a href="javascript:;"><img class="img-responsive" src= "'.$image.'" /></a></div>';
					}
				}
				?>
			</div>
		</div>
		<ul id="position" class="positionp positionpp">
			<?php
			$number_images = count($detail['images']);
			if($number_images){
				echo '<li class="cur"></li>';
				for($i=2; $i<=$number_images; $i++){
					echo '<li></li>';
				}
			}
			?>
		</ul>
	</div>


<!-- product productinfo-->
<div class="d-prifno">
	<div class="fn-wrap">
		<div class="wrap-title wrap-titlep">
			<h2><?=$detail['goods']->name?></h2>
			<div class="wrap-xsprice"><?=$is_tuan ? '团购价' : '包邮价'?>：<span class="fn-wrapprice">￥<span id="priceMain"><?=$detail['price_range']['min'] == $detail['price_range']['max'] ? $detail['price_range']['max'] : $detail['price_range']['min']."--".$detail['price_range']['max']?></span></span></div>
			<!--<div class="wrap-yxprice"><span class="dm-icon xq-icon">可抵扣</span><img src="/img/deduction.png">最高可使用米券抵扣<span class="r-fc2">1000</span>元</div>-->
			<?php if (SpcService::isCoupon($detail['goods']['goods_id'])) { ?>
				<div class="wrap-yxprice"><!--<span class="dm-icon xq-icon">可抵扣</span>--><img src="/img/deduction.png">可使用米券抵扣<span class="r-fc2"><?=$detail['goods']['defaultSku']['cash_deduction']?></span>元</div>
			<?php } else if (SpcService::isIntegral($detail['goods']['goods_id'])) { ?>
					<br/>
					<div><span class="qcxq-jf-icon"><i></i>积分</span>购买即可得商品价值<span class="r-fc2"><?=$detail['goods']['egd'] * 100?>%</span>的积分</div>
					<?php $zd = new ZdApiService(); ?>
					<div class="mt8">当前积分价格<span class="r-fc2"><?=$zd->zdGetCorePrice()?></span>元</div>

			<?php } else if (SpcService::isExchange($detail['goods']['goods_id'])) { ?>
				<div class="wrap-yxprice"><img src="/img/xfqlabel.png">使用<span class="r-fc2">100000</span>消费券可兑换</div>
			<?php } ?>
			<!--<div class="wrap-sale"><span class="fn-wrapfont">优惠</span>：<span class="wrap-miquan">可用米券</span></div>-->
		</div>
		<a  href="#" class="make-wrap">
			<div class="make-wraptext">月销<span class="bl-fc"><?=$detail['goods']['goodscount']['sales']?></span>件</div>
		</a>
		<!--<a href="javascript:void(0);" id="collect-wrap" class="<?/*=$share_class;*/?>">
			<div class="make-wraptext"><?/*=$text_collect;*/?></div>
		</a>-->
	</div>
	<div class="d-linklist"  id="open-sb">
		<a id="sku_attr" class="item" onclick="" href="javascript:void(0);" >
			规格
			<span class="parameter" id="currentSku">
				<?php if($detail['defaultSkuAttr']){ ?>
					<?php foreach(array_values($detail['defaultSkuAttr']) as $v1){ ?>
					<i><?=$v1 ?></i>
					<?php } ?>
				<?php } ?>
			</span>
			<i class="arrowent"></i>
		</a>
	</div>
</div>

<div class="details-mode">
	<div class="qc-discount memberbortop">
		<div class="qcxq-jf">
			<a class="item" onclick="" href="<?=Url::to(['description?id='.$detail['goods']->goods_id])?>">
				参数详情
				<i class="arrowent"></i>
		    </a>
		</div>
		<div class="qcxq-ensure">
			<span><i class="dm-icon"></i>正品保障</span>
			<span><i class="dm-icon"></i>支持7天退货</span>
			<span><i class="dm-icon"></i>极速退款</span>
		</div>
	</div>
	<!--<div class="d-linklist noborder">
		<a class="item" onclick="" href="<?=Url::to(['attr?id='.$detail['goods']->goods_id])?>">
			商品参数
			<i class="arrowent"></i>
		</a>
	</div>-->
	<!--<div class="d-linklist">
		<a class="item" onclick="" href="<?/*=Url::to(['comments?id='.$detail['goods']->goods_id])*/?>">
			商品评价
			<i class="arrowent"></i>
		</a>
	</div>-->
</div>


<div class="qc-instruct">
	<?php if ($detail['goods']['buy_des']) { ?>
	<div class="tit">购置说明</div>
	<div class="cont">
		<?=$detail['goods']['buy_des']?>
   	</div>
	<?php } ?>
</div>


<!--<div class="details-mode pb-70">
	<div class="d-linklist">
		<a class="item" onclick="" href="<?= isset($detail['goods']->store) ? ('/store/store/view?id='.$detail['goods']->store->id):'' ?>">
			<?=isset($detail['goods']->store) ? $detail['goods']->store->store_name : (isset($detail['goods']->supplier) ? $detail['goods']->supplier->name : '') ?>-->
			<!--span class="d-shop-stars">
				<i class="d-rec-star star<?php
					if(isset($detail['goods']->store) && isset($detail['goods']->store->level)) {
						if ($detail['goods']->store->level->name == '普通会员')
							echo '0';
						else if ($detail['goods']->store->level->name == '一星店铺')
							echo '1';
						else if ($detail['goods']->store->level->name == '二星店铺')
							echo '2';
						else if ($detail['goods']->store->level->name == '三星店铺')
							echo '3';
						else if ($detail['goods']->store->level->name == '四星店铺')
							echo '4';
						else if ($detail['goods']->store->level->name == '五星店铺')
							echo '5';
						else if ($detail['goods']->store->level->name == '六星店铺')
							echo '6';
						else
							echo '0';
					} else {
						echo '0';
					}
				?>"></i>
			</span-->
			<!--<i class="arrowent"></i>
		</a>
	</div>
</div>-->

<div class="d-shopbuybtn">
	<div class="shop-cates"><a class="shop-sharecarts cart-num" href="<?=Url::to(['/order/cart/'])?>"><i><?=Yii::$app->cart->count?></i></a> </div>
	<div class="btn-cart">
		<!--积分专区商品不允许加入购物车-->
		<?php if (!SpcService::isIntegral($detail['goods']->goods_id) && !SpcService::isExchange($detail['goods']->goods_id)) { ?>
			<div class="btn-shopcarts"  id="open-sb-1">
				<a href="javascript:void(0);" id="mainAddToCart">加入购物车</a>
			</div>
			<div class="btn-conter" id="open-sb-2"><a id="mainBuyNow" href="javascript:void(0);">立即购买</a></div>
		<?php } else { ?>
			<div class="btn-conter btn-conterp" id="open-sb-2"><a id="mainBuyNow" href="javascript:void(0);">立即购买</a></div>
		<?php } ?>
	</div>
</div>

<!-- 加入购物车弹出框 begn-->
	<div class="d-bodybg" id="add_cart_success_box" style="display: none;">
		<div class="d-bodyeject d-minheight">
			<div class="body_contr">
				<div class="chenker">
					<span class="correct"></span>
					<p class="wordker">添加成功！<br><span>商品已成功加入购物车</span></p>

				</div>
				<div class="btn-jion pkvoir">
					<!--div class="btn-zir"><a href="<?=Url::to(['/home/home/index'])?>">继续购物</a></div-->
					<div class="btn-zir"><a onclick="closediv();" href="javascript::void(0);">继续购物</a></div>
					<div class="btn-go"><a href="<?=Url::to(['/order/cart'])?>">去购物车结算</a></div>
				</div>
			</div>
		</div>
	</div>
	<!-- 加入购物车弹出框 end-->

	<!-- 规格弹出框 begin -->
<div class="wrapper">
<div class="d-tab-content sidebar" id="sku_box" style="">
	<div class="d-tab-pane active">
		<div class="screening-box">
			<div class="sidebar-content sidebar-contentw">
				<div class="detail-content">
					<p class="d-detpic">
						<img src="<?=(isset($detail['images']) && isset($detail['images'][0])) ? $detail['images'][0] : '' ?>">
					</p>
					<div class="detail-caption">
						<p class="d-captit"><?=$detail['goods']->name?></p>
						<p class="d-detailpri">￥<span id="price"><?=$detail['price_range']['min'] == $detail['price_range']['max'] ? $detail['price_range']['max'] : $detail['price_range']['min']."--".$detail['price_range']['max']?></span></p>

					</div>
				</div>
				<?php if($detail['sku_attr']){ foreach($detail['sku_attr']['list'] as $k_sku => $v_sku){ ?>
				<div class="d-specone dm-specone d-spectwo">
					<h2 class="k_sku"><?=$k_sku ?></h2>
					<div class="d-fniert my-fniert">
						<?php foreach($v_sku['sku_id_value_group'] as $v_sku_k =>  $v_sku_v){ ?>
						<!-- <a href="#" id="" class="titblock activek"><?=$v_sku_v['name'] ?></a> -->
						<!--<input style="margin-top:10px;" type="button" class="sku titblock  <?php //if(in_array($v_sku_v,$detail['defaultSkuAttr'])){ echo "btn-danger";} ?>" attr_id="<?=$v_sku_k?>" value="<?=$v_sku_v['name']?>"/>-->
                        <button style="margin-top:10px;height:40px;" class="sku titblock  <?php  ?>" attr_id="<?=$v_sku_k?>"><?php if($v_sku_v['ico']){ ?><img src="<?= Yii::$app->params['img_domain'].$v_sku_v['ico'] ?>"><?php } ?><span><?=$v_sku_v['name']?></span> </button>
						<?php } ?>
					</div>
				</div>
				<?php  } }?>
				<div class="d-specone d-spectwo dm-specone">
					<h2 class="numeier">数量<span></span></h2>
					<div class="d-fniert bortop">
						<ul class="Fix boxright">
							<a href="javascript:void(0);" id="decrease" class="number-jian numbertu number-cur">–</a>
							<input name="product_num" id="goods_number"  value="1" class="numberinput">
							<a href="javascript:void(0);" id="increase" class="numbertu numbertip">+</a>

							<span class="onejian">件</span>
						</ul>
					</div>
				</div>

				<div class="btn-jion d-posrtr ">

					<?php if (!SpcService::isIntegral($detail['goods']->goods_id) && !SpcService::isExchange($detail['goods']->goods_id)) { ?>
						<div class="btn-zir d-specone-btn">
							<a id="addToCart" href="javascript:void(0);">
								加入购物车
							</a>
						</div>
						<div class="btn-go d-specone-btn"><a onclick="buyNow()" href="javascript:void(0);">立即购买</a></div>
					<?php } else { ?>
						<div class="btn-go btn-gop d-specone-btn"><a onclick="buyNow()" href="javascript:void(0);">立即购买</a></div>
					<?php } ?>
					
				</div>
			</div>
		</div>

	</div>
</div>
</div>
<!-- 弹出框 end -->





<style type="text/css">
	/*.btn-danger {color: red;}*/
</style>

<script type="text/javascript">
   //轮播S
    var bullets = document.getElementById('position').getElementsByTagName('li');
    var banner = Swipe(document.getElementById('mySwipe'), {
        auto: 4000,
        continuous: true,
        disableScroll:false,
        callback: function(pos) {
        	var iw= bullets.length;
            var i = bullets.length;
            while (i--) {
                bullets[i].className = ' ';
            }
            bullets[pos%iw].className = 'cur';
        }
    })
//轮播E
	$(function(){
		$("#sku_attr").click(function(){
			$("#sku_box").show();
		})
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

	//保存最后的组合结果信息
	var SKUResult = {};
	//获得对象的key
	function getObjKeys(obj) {
	    if (obj !== Object(obj)) throw new TypeError('Invalid object');
	    var keys = [];
	    for (var key in obj)
	        if (Object.prototype.hasOwnProperty.call(obj, key))
	            keys[keys.length] = key;
	    return keys;
	}

	//把组合的key放入结果集SKUResult
	function add2SKUResult(combArrItem, sku) {
		var key = combArrItem.join(";");
	    if(SKUResult[key]) {//SKU信息key属性·
	        SKUResult[key].count += sku.count;
	        SKUResult[key].prices.push(sku.price);
	        SKUResult[key].skuId.push(sku.skuId);
	    } else {
	        SKUResult[key] = {
	            count : sku.count,
	            prices : [sku.price],
	            skuId : [sku.skuId],
	            golds : [sku.golds]
	        };
	    }
	}

	//初始化得到结果集
	function initSKU() {
	    var i, j, skuKeys = getObjKeys(data);
	    for(i = 0; i < skuKeys.length; i++) {
	        var skuKey = skuKeys[i];//一条SKU信息key
	        var sku = data[skuKey];	//一条SKU信息value
	        var skuKeyAttrs = skuKey.split(";"); //SKU信息key属性值数组
			skuKeyAttrs.sort(function(value1, value2) {
				return parseInt(value1) - parseInt(value2);
			});

	        //对每个SKU信息key属性值进行拆分组合
			var combArr = combInArray(skuKeyAttrs);
			for(j = 0; j < combArr.length; j++) {
				add2SKUResult(combArr[j], sku);
			}

	        //结果集接放入SKUResult
	        SKUResult[skuKeyAttrs.join(";")] = {
	            count:sku.count,
	            prices:[sku.price],
	            skuId:[sku.skuId],
	            golds:[sku.golds]
	        }
	    }
	}

	/**
	 * 从数组中生成指定长度的组合
	 * 方法: 先生成[0,1...]形式的数组, 然后根据0,1从原数组取元素，得到组合数组
	 */
	function combInArray(aData) {
		if(!aData || !aData.length) {
			return [];
		}

		var len = aData.length;
		var aResult = [];

		for(var n = 1; n < len; n++) {
			var aaFlags = getCombFlags(len, n);
			while(aaFlags.length) {
				var aFlag = aaFlags.shift();
				var aComb = [];
				for(var i = 0; i < len; i++) {
					aFlag[i] && aComb.push(aData[i]);
				}
				aResult.push(aComb);
			}
		}
		return aResult;
	}


	/**
	 * 得到从 m 元素中取 n 元素的所有组合
	 * 结果为[0,1...]形式的数组, 1表示选中，0表示不选
	 */
	function getCombFlags(m, n) {
		if(!n || n < 1) {
			return [];
		}

		var aResult = [];
		var aFlag = [];
		var bNext = true;
		var i, j, iCnt1;

		for (i = 0; i < m; i++) {
			aFlag[i] = i < n ? 1 : 0;
		}

		aResult.push(aFlag.concat());

		while (bNext) {
			iCnt1 = 0;
			for (i = 0; i < m - 1; i++) {
				if (aFlag[i] == 1 && aFlag[i+1] == 0) {
					for(j = 0; j < i; j++) {
						aFlag[j] = j < iCnt1 ? 1 : 0;
					}
					aFlag[i] = 0;
					aFlag[i+1] = 1;
					var aTmp = aFlag.concat();
					aResult.push(aTmp);
					if(aTmp.slice(-n).join("").indexOf('0') == -1) {
						bNext = false;
					}
					break;
				}
				aFlag[i] == 1 && iCnt1++;
			}
		}
		return aResult;
	}


	/**
	 * 加入购物车的方法
	 */
	function addToCart(){
		var sku_id = $("#skuId").val();
		var goods_number = $("#goods_number").val();

		var tmp = $("#currentSku").html();
		if(tmp.indexOf("请选择")!= -1){
			//TODO提示详细的选择
			$.MsgBox.Alert("",tmp);
			return;
		}
		var goods_number = parseInt($("#goods_number").val());
		var stock = parseInt($("#stock").val());
		if(goods_number > stock){
			$.MsgBox.Alert("","库存不足");
			$(".numbertip").addClass("number-cur", true);
			return;
		}
        var url = "<?= Url::to(['/order/cart/add-to-cart']) ?>";
        $.post(url,{sku_id:sku_id,goods_number:goods_number,'_csrf':'<?=Yii::$app->request->csrfToken?>'},
            function(data){
                var res = eval('(' + data + ')');
                if(parseInt(res.code) == 200){
                	$("#sku_box").hide();
                	$("#add_cart_success_box").show();
                }else{
                	$.MsgBox.Alert("",res.msg);
					$(".numbertip").addClass("number-cur", true);
                }
            }
        );
	}


	/**
	 * 立即购买
	 */
	function buyNow(){
		var goods_number = parseInt($("#goods_number").val());
		var stock = parseInt($("#stock").val());
		if(goods_number > stock){
			$.MsgBox.Alert("","库存不足");
			$(".numbertip").addClass("number-cur", true);
			return;
		}
		var sku_id = $("#skuId").val();
		var goods_number = $("#goods_number").val();

		var tmp = $("#currentSku").html();
		if(tmp.indexOf("请选择")!= -1){
			//TODO提示详细的选择
			$.MsgBox.Alert("",tmp);
			return;
		}

        var url = "<?= Url::to(['/order/order/buy-now']) ?>"+"?sku_id="+sku_id+"&num="+goods_number;
        location.href = url;
	}



	//初始化用户选择事件
	$(function() {
		initSKU();
		var endTime = new Date().getTime();
		$('#init_time').text('init sku time: ' + (endTime - startTime) + " ms");
		// //获取默认的sku属性名，在下面好判断是不是要默认选中
		var defaultSku = new Array();
		$("#currentSku > i").each(function(index, o){
			defaultSku[index] = $(this).html();
		});
		//检查选中状态
		checkSelect();
		$('.sku').each(function() {
			var self = $(this);
			var attr_id = self.attr('attr_id');
			if(!SKUResult[attr_id]) {
				self.attr('disabled', 'disabled');
				$(this).addClass('dsbbg');
			}

			//对比属性是否在默认属性里，如果是，就选中
			// var skuName = self.children("span").text();
			// if(defaultSku.indexOf(skuName) != -1){
			// 	self.toggleClass('btn-dangerp').siblings().removeClass('btn-dangerp');
			// 	//已经选择的节点
			// 	var selectedObjs = $('.btn-dangerp');

			// 	if(selectedObjs.length) {
			// 		//获得组合key价格
			// 		var selectedIds = [];
			// 		selectedObjs.each(function() {
			// 			selectedIds.push($(this).attr('attr_id'));
			// 		});
			// 		selectedIds.sort(function(value1, value2) {
			// 			return parseInt(value1) - parseInt(value2);
			// 		});
			// 		var len = selectedIds.length;
			// 		var prices = SKUResult[selectedIds.join(';')].prices;
			// 		var maxPrice = Math.max.apply(Math, prices);
			// 		var minPrice = Math.min.apply(Math, prices);
			// 		//根据所选sku更改商品价格显示
			// 		$('#price').text(maxPrice > minPrice ? minPrice + "-" + maxPrice : maxPrice);
			// 		$('#priceMain').text(maxPrice > minPrice ? minPrice + "-" + maxPrice : maxPrice);
			// 		//更改skuId隐藏域
			// 		$('#skuId').val(SKUResult[selectedIds.join(';')].skuId);
			// 		//更改库存隐藏域
			// 		$('#stock').val(SKUResult[selectedIds.join(';')].count);

			// 		//更改商品规格处的文字
			// 		var str = "";
			// 		$('.sku').each(function() {
			// 			if($(this).hasClass('btn-dangerp')){
			// 				str = str + " " + " " + $(this).children("span").html();
			// 			}
			// 		})
			// 		$("#currentSku").text(str);


			// 		//用已选中的节点验证待测试节点 underTestObjs
			// 		$(".sku").not(selectedObjs).not(self).each(function() {
			// 			var siblingsSelectedObj = $(this).siblings('.btn-dangerp');
			// 			var testAttrIds = [];//从选中节点中去掉选中的兄弟节点
			// 			if(siblingsSelectedObj.length) {
			// 				var siblingsSelectedObjId = siblingsSelectedObj.attr('attr_id');
			// 				for(var i = 0; i < len; i++) {
			// 					(selectedIds[i] != siblingsSelectedObjId) && testAttrIds.push(selectedIds[i]);
			// 				}
			// 			} else {
			// 				testAttrIds = selectedIds.concat();
			// 			}
			// 			testAttrIds = testAttrIds.concat($(this).attr('attr_id'));
			// 			testAttrIds.sort(function(value1, value2) {
			// 				return parseInt(value1) - parseInt(value2);
			// 			});
			// 			if(!SKUResult[testAttrIds.join(';')]) {
			// 				$(this).attr('disabled', 'disabled').removeClass('btn-dangerp');
			// 				$(this).addClass('dsbbg');
			// 			} else {
			// 				$(this).removeAttr('disabled');
			// 				$(this).removeClass('dsbbg');
			// 			}
			// 		});
			// 	}
			// }
		}).click(function() {
			var self = $(this);

			//选中自己，兄弟节点取消选中
			self.toggleClass('btn-dangerp').siblings().removeClass('btn-dangerp');

			//已经选择的节点
			var selectedObjs = $('.btn-dangerp');

			if(selectedObjs.length) {
				//获得组合key价格
				var selectedIds = [];
				selectedObjs.each(function() {
					selectedIds.push($(this).attr('attr_id'));
				});
				selectedIds.sort(function(value1, value2) {
					return parseInt(value1) - parseInt(value2);
				});
				var len = selectedIds.length;
				var prices = SKUResult[selectedIds.join(';')].prices;
				var maxPrice = Math.max.apply(Math, prices);
				var minPrice = Math.min.apply(Math, prices);
				//根据所选sku更改商品价格显示
				$('#price').text(maxPrice > minPrice ? minPrice + "-" + maxPrice : maxPrice);
				$('#priceMain').text(maxPrice > minPrice ? minPrice + "-" + maxPrice : maxPrice);
				//更改skuId隐藏域
				$('#skuId').val(SKUResult[selectedIds.join(';')].skuId);
				//更改库存隐藏域
				$('#stock').val(SKUResult[selectedIds.join(';')].count);

				//更改商品规格处的文字
				var str = "";
				$('.sku').each(function() {
					if($(this).hasClass('btn-dangerp')){
						str = str + " " + " " + $(this).children("span").html();
					}
				})
				$("#currentSku").text(str);

				//修改返利数
				var golds = SKUResult[selectedIds.join(';')].golds;
				if(golds != "undefined"){
					$("#zsjf").html(golds);
				}


				//用已选中的节点验证待测试节点 underTestObjs
				$(".sku").not(selectedObjs).not(self).each(function() {
					var siblingsSelectedObj = $(this).siblings('.btn-dangerp');
					var testAttrIds = [];//从选中节点中去掉选中的兄弟节点
					if(siblingsSelectedObj.length) {
						var siblingsSelectedObjId = siblingsSelectedObj.attr('attr_id');
						for(var i = 0; i < len; i++) {
							(selectedIds[i] != siblingsSelectedObjId) && testAttrIds.push(selectedIds[i]);
						}
					} else {
						testAttrIds = selectedIds.concat();
					}
					testAttrIds = testAttrIds.concat($(this).attr('attr_id'));
					testAttrIds.sort(function(value1, value2) {
						return parseInt(value1) - parseInt(value2);
					});
					if(!SKUResult[testAttrIds.join(';')]) {
						$(this).attr('disabled', 'disabled').removeClass('btn-dangerp');
						$(this).addClass('dsbbg');
					} else {
						$(this).removeAttr('disabled');
						$(this).removeClass('dsbbg');
					}
				});
			} else {
				//设置属性状态
				$('.sku').each(function() {
					var self = $(this);
					var attr_id = self.attr('attr_id');
					if(!SKUResult[attr_id]) {
						self.attr('disabled', 'disabled');
						$(this).addClass('dsbbg');
					}else{
						$(this).removeAttr('disabled');
						$(this).removeClass('dsbbg');
					}
				});
				//设置默认价格
				var min = <?=$detail['price_range']['min'] ?>;
				var max = <?=$detail['price_range']['max'] ?>;
				$('#price').text(min < max ? min+"-"+max : min);
				$('#priceMain').text(min < max ? min+"-"+max : min);
				$("#currentSku").text("");
			}

			//调用验证是否选择sku属性的方法
			checkSelect();
		});


		//商品数量改变
		$("#decrease").click(function(){
			var goods_number = parseInt($("#goods_number").val());
			if(goods_number>1){
				$(".numbertip").removeClass("number-cur", true);
				$(".number-jian").removeClass("number-cur", true);
				goods_number --;
				$("#goods_number").val(goods_number);
			}else{
				$(".number-jian").addClass("number-cur", true);
			}
		})
        /*当减到1时减号变灰色 s*/
        $('.number-jian').click(function(){
        	if($('.numberinput').val()==1){
        		$(".number-jian").addClass("number-cur", true);
        	}
        });
        /*当减到1时减号变灰色 e*/
		$("#increase").click(function(){
			var goods_number = parseInt($("#goods_number").val());
			var stock = parseInt($("#stock").val());
			$(".number-jian").removeClass("number-cur", true);
			if(goods_number < stock){
				goods_number++;
				$("#goods_number").val(goods_number);
			}else{
				$.MsgBox.Alert("","数量超过了库存数");
				$(".numbertip").addClass("number-cur", true);
			}
		})

		$("#goods_number").change(function(){
			var stock = parseInt($("#stock").val());
			if(/^[1-9]*$/.test(this.value)){
				if(this.value>stock){
					$.MsgBox.Alert("","数量超过了库存数");
					$("#goods_number").val(1);
					$(".numbertip").addClass("number-cur", true);
				}else{
					if(isNaN(stock)){
						$.MsgBox.Alert("","请先选择款型");
						return;
					}
				}
			}else{
				$("#goods_number").val(1);
				$(".number-jia").removeClass("number-cur", true);
			}
		})


		//弹窗处加入购物车
		$("#addToCart").click(function(){
			addToCart();
		})

		/*//主界面加入购物车
		$("#mainAddToCart").click(function(){
			addToCart();
		})*/

	});


	/**
     * 格式化数字，小数保留2位，整数则原样返回
     */
    function format(str)
    {
        if(parseInt(str) == str){
            return str;
        }else{
            var tmp = str.toFixed(2);
            if(tmp.indexOf('.')!= "-1"){
                if(tmp[tmp.length-1] == 0){
                    return tmp.substring(0,tmp.length-1);
                }else{
                    return tmp;
                }
            }
        }
    }

    /**
	 *  判断是不是有选择属性
	 */
	 function checkSelect()
	 {
	 	var str = "";
	 	$(".k_sku").each(function(){
	 		var isSelected = false;
	 		$(this).next().children().each(
	 			function(){
	 				var cls = $(this).attr("class");
	 				if(cls.indexOf("btn-dangerp")!=-1){
	 					isSelected =true;
	 				}
	 			}
	 		);
	 		if(isSelected == false){
	 			str += " " + $(this).html();
	 		}
	 	})
	 	if(str != ""){
	 		var title = "请选择:" + str;
	 		$("#currentSku").html(title);
	 	}
	 }


    //点击收藏当前商品
//    $(function(){
//        $('.fn-wrap #collect-wrap').click(function(){
//            var _this = $(this);
//            var member_id = <?//=$member_id;?>// ;
//            var goods_id = <?//=json_encode($detail['goods']['goods_id']);?>//;
//            var url = "<?//= Url::to(['/goods/goods/collection']) ?>//";
//            var type = 1;
//            var _csrf = '<?//=Yii::$app->request->csrfToken?>//';
//            var data = {'member_id':member_id,'goods_id':goods_id,'url':url,'type':type,'_csrf':_csrf};
//            $.post(url,data,function(res){
//                var resutl = eval( '(' + res + ')');
//                if(parseInt(resutl.code) == 200){
//                    if(resutl.msg == 'collectok'){
//                       // console.log(_this);
//                        _this.removeClass().addClass('share-wrap');
//                        $('.make-wraptext').html('取消收藏');
//                    }else{
//                        _this.removeClass().addClass('noshare-wrap');
//                        $('.make-wraptext').html('收藏');
//                    }
//                }else{
//                    console.log('收藏出错，请重新收藏！');
//                }
//            });
//        });
//
//        $(window).each(function(){
//        	if($(this).width()<400){
//        		$('.jfblock').css('display','block');
//        		$('#collect-wrap').css('top','10px');
//        	}else{
//        		$('.jfblock').css('display','inline');
//        		$('#collect-wrap').css('top','0');
//        	}
//        });
//    });
//关闭弹出框
	function closediv(){
		$("#add_cart_success_box").hide();
		window.location.reload();
	}

</script>




<?php } ?>