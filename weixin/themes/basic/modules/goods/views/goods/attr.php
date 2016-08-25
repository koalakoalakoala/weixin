<?php
use yii\helpers\Url;
use common\service\SpecialCategoryService as SpcService;
$this->title="参数详情";
?>
		<div class="index-content">
			<!--首页背景控制-->
			<div class="index-se fotterborder">

				<!-- Commodity list 商品列表-->
				<div class="d-commodity-list">
					<!-- tab 切换-->
					<div class="d-tab-background stick-tittle">
						<div class="d-tab-title">
							<a class="d-mod-nav-item" href="<?=Url::to(['description?id='.$_GET['id']])?>">图文详情</a>
							<a class="d-mod-nav-item d-mod-nav-cur" href="<?=Url::to(['attr?id='.$_GET['id']])?>">商品参数</a>
							<!--<a class="d-mod-nav-item" href="<?/*=Url::to(['comments?id='.$_GET['id']])*/?>">商品评价</a>-->
						</div>
					</div>

					<!--隐藏域，存放当前选中sku-->
					<input type="hidden" value="" id="skuId" />
					<!--隐藏域，存放当前选中sku-->
					<input type="hidden" value="" id="stock"/>

					<a id="sku_attr" class="item" onclick="" href="#" style="display:none;">
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

					<!-- 产品参数-->
					<div class="d-parameter">
						<?php if($attr){ foreach($attr as $k => $v){ ?>
							<p><?=$k.":".implode(";", $v) ?></p>
						<?php } } ?>
					</div>




				</div>


				<!--加入购车 立即购买按钮 -->
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
			</div>

		</div>

		<!-- 加入购物车弹出框 begn-->
	<div class="d-bodybg" id="add_cart_success_box" style="display: none">
		<div class="d-bodyeject d-minheight">
			<div class="body_contr">
				<div class="chenker">
					<span class="correct"></span>
					<p class="wordker">添加成功！<br><span>商品已成功加入购物车</span></p>

				</div>
				<div class="btn-jion pkvoir">
					<div class="btn-zir"><a href="javascript:void(0);" onclick="closediv()">继续购物</a></div>
					<div class="btn-go"><a href="<?=Url::to(['/order/cart'])?>">去购物车结算</a></div>
				</div>
			</div>
		</div>
	</div>
	<!-- 加入购物车弹出框 end-->

	<!-- 规格弹出框 begin -->
<div class="wrapper">
<div class="d-tab-content sidebar" id="sku_box" style="display:none;">
	<div class="d-tab-pane active">
		<div class="screening-box">
			<div class="sidebar-content sidebar-contentw">
				<div class="detail-content">
					<p class="d-detpic">
						<img src="<?=(isset($detail['images']) && isset($detail['images'][0])) ? $detail['images'][0] : '' ?>">
					</p>
					<div class="detail-caption">
						<p class="d-captit"><?=$detail['goods']->name?></p>
						<p class="d-detailpri">￥<span id="price"><?=$detail['price']?></span></p>

					</div>
				</div>
				<?php if($detail['sku_attr']){ foreach($detail['sku_attr']['list'] as $k_sku => $v_sku){ ?>
				<div class="d-specone dm-specone d-spectwo">
					<h2 class="k_sku"><?=$k_sku ?></h2>
					<div class="d-fniert my-fniert">
						<?php foreach($v_sku['sku_id_value_group'] as $v_sku_k =>  $v_sku_v){ ?>
                        <button style="margin-top:10px;" class="sku titblock  <?php  ?>" attr_id="<?=$v_sku_k?>"><?php if($v_sku_v['ico']){ ?><img src="<?= Yii::$app->params['img_domain'].$v_sku_v['ico'] ?>"><?php } ?><span><?=$v_sku_v['name']?></span> </button>
						<?php } ?>
					</div>
				</div>
				<?php  } }?>
				<div class="d-specone d-spectwo dm-specone">
					<h2 class="numeier">数量<span></span></h2>
					<div class="d-fniert bortop">
						<ul class="Fix boxright">
							<a href="javascript:void(0);" id="decrease" class="number-jian numbertu">–</a>
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

			//检查选中状态
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
</script>