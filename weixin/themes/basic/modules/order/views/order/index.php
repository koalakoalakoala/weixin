<?php
use yii\helpers\Url;
use common\service\SkuService;
use common\service\OrderService;
$this->title="提交订单";
?>

<div class="mod_container">

	<!--tjdd 顶部信息 S-->
    <a href="<?=Url::to(['/order/order/select-addr','sku_ids'=>$_GET['sku_ids']])?>">
		<div class="tjdd-top">
			<div class="intjdd-top">
				<div class="dm-icon tjdd-top-icon"></div>
				<div class="tjdd-top-info">
					<span class="jt right"></span>
					<?php $isSelected = false;?>
					<?php if(isset($_GET['address_id'])){
						$isSelected = true;
					?>
						<div class="clearfix f14"><?=$addr->name ?><p class="fr"><?=$addr->mobile ?></p></div>
						<div class="f12"><?=$addr->province." ".$addr->city." ".$addr->area." ".$addr->detail?></div>
					<?php }else{?>
						<?php
							if($addr){
								if($addr->is_del == 0){
									if($addr->is_default == 0){
						?>
										<div href="#" class="tjdd-top-add <?//=$address_null?>" >请选择收货地址</div>
						<?php		}else{  
							$isSelected = true;
						?>
								<div class="clearfix f14"><?=$addr->name ?><p class="fr"><?=$addr->mobile ?></p></div>
								<div class="f12"><?=$addr->province." ".$addr->city." ".$addr->area." ".$addr->detail?></div>
						<?php		} ?>
						<?php	}else{ ?>
									<div href="#" class="tjdd-top-add <?//= $address_null?>" >请添加收货地址</div>
						<?php	}    ?>
						<?php }else{ ?>
								<div href="#" class="tjdd-top-add <?= $address_null?>" >请添加收货地址</div>
						<?php } ?>
					<?php }?>

				</div>
			</div>
		</div>
    </a>
	<input type="hidden" value="<?=$addr?$addr->id:''?>" id="address" />
	<!--顶部信息 E-->

	<!-- tjdd-content 提交订单中部内容 S-->
	<div class=" tjdd-center">
	  <?php
	  foreach($positions as $k => $v){ ?>
	    <div class="phone-shopbox tjdd-center mq-tjdd-center">
	      <!-- <a href="<?= isset($v['store']) ? Url::to(['/store/store/view?id='.$v['store']->id]) : "#" ?>" class="shop-title cleafix tjdd-center-title">
			   <?php if(isset($v['store']) && $v['store']->store_logo){ ?> <img src="<?=Yii::$app->params['img_domain'].$v['store']->store_logo?>" style="width:25px;height:25px;" /> <?php } ?> <?=isset($v['supplier']) ? '<span class="dm-icon my-index-icon dm-title-icon"></span>' : ''?><span><?=isset($v['supplier']) ? "中盾自营，[".$v['supplier']->name."]供货" : (isset($v['store']) ? $v['store']->store_name : "")?></span>
			<span class="shop-jt"><span class="jt right"></span></span>
		   </a>-->
	       <div class=" tjdd-center-content">
			<div class="home-tuan-lists iobrv intjdd-center-content">
		    	<?php
		    	$itemCount = 0;
		    	$itemCost = 0;
		    	foreach($v['goods'] as $k1 => $v1){ ?>
		    	<div class="dm-item Fix tjdd-item tjdd-itemp">
			    	<a href="<?=Url::to(['/goods/goods/view?id='.$v1->goods->goods_id])?>">
			            <div class="cnt shopcont shopcont_p pdb-10">
			            	<span class="shoppr"><img class="pic" src="<?=$v1->goods->goodsgallery? Yii::$app->params['img_domain'].$v1->goods->goodsgallery->image : '' ?>" alt=""></span>
				            <div class="content-wrap ">
					             <div class="content-wrap2">
						            <div class="shop-content ">
						                <div class="title clearfix"><span class="in-tit fl zd-width" ><?=$v1->goods->name?></span><div class="sc-btn fr zdc-top" href="#"><span class="r-fc">¥<?=$v1->market_price + $v1->goods->freight?></span><br/><span>数量 :×<?=$v1->quantity	?></span></div></div>
						                <div class="shop-des" ><?=SkuService::searchSkuAttrNameValue($v1)?></div>
					               </div>
				               </div>
			               </div>
			            </div>
			        </a>
			        
			        <!-- <div class="yf-list-line clearfix">
						<div class="fl">运费</div>
						<div class="fr">免运费</div>
					</div> -->
			        <?php if($v1->cash_deduction > 0){ ?>
				        <div class="mq-list-line bt">
							<div class="mq-list-line-pl">
									<!--<div class="mq-list-line-left">我的米券</div>-->
								<div class="mq-list-line-left">我的米券：<span class="r-fc2 d-inb"><?=OrderService::getMiQuan(Yii::$app->user->id)?></span></div>
								<!--<div class="mq-btn mq-list-line-right">
									<span class="mb-14">商品可使用<span id="sku_use_quan-<?=$v1->sku_id?>"><?=$v1->cash_deduction*$v1->quantity?></span>米券</span>
									<input class="mq_input" type="checkbox" id="checkbox-10_<?=$v1->sku_id?>" />
									<span class="slider-btn" skuid="sku_<?=$v1->sku_id?>" storeid="<?=$k?>"  for="checkbox-10_<?=$v1->sku_id?>"></span>
								</div>-->
								<div class="mq-btn mq-list-line-right"><span class="mb-14">可用<span class="r-fc2" id="sku_use_quan-<?=$v1->sku_id?>"><?=$v1->cash_deduction*$v1->quantity?></span>米券抵扣<span class="r-fc2 d-inb">￥<?=$v1->cash_deduction*$v1->quantity?></span></span><input class="mq_input"  type="checkbox" id="checkbox-10_<?=$v1->sku_id?>" /><span class="slider-btn"  skuid="sku_<?=$v1->sku_id?>" storeid="<?=$k?>"  for="checkbox-10_<?=$v1->sku_id?>"></span></div>
							</div>
						</div>
					<?php } ?>
					<!--<div class="mq-list-line clearfix">
						<div class="fl">返利</div>
						<div class="fr mq-btn"><span>预计返利: <?/*=OrderService::getGolds($v1->market_price*$v1->quantity, $v1->goods->egd) */?> </span></div>
					</div>-->
					<!-- <div class="input-box">
						<input type="text" placeholder="给卖家留言" maxlength="70" />
					</div> -->
                </div>
                <?php
                	$itemCount += $v1->quantity;
                	$itemCost += ($v1->market_price + $v1->goods->freight) * $v1->quantity;
                } ?>
				<div class="count-list-line clearfix">
					共<?=$itemCount?>件商品，合计  <span>¥<span id="total_<?=$k?>"><?=$itemCost?></span></span>
				</div>
		    </div>

	        </div>
	    </div>
    </div>
    <?php } ?>
    <input type="hidden" id="can_use_quan" value="<?=OrderService::getMiQuan(Yii::$app->user->id)?>" /><!-- 用户总可用米券 -->
    <input type="hidden" id="quan_sku_id" /><!-- 记录使用米券的sku_id -->
	<!-- tjdd-content 提交订单中部内容 E-->

	<!--底端-->
	<!--<div class="tjdd-btn">
		  <div class="btn-lie intjdd-btn">
			<a href="javascript:void(0);" id="submit" class="fr">提交订单</a>
		 </div>
	</div>-->
	 <div style="height: 64px;"></div>
    <div class="bb bt pf-b0" >
        <div class=" btn-jion btn-jionp">
            <div class="pro-price tjdd-price">共<span class="r-fc fw-b"><?=$itemCount?></span>件商品，<span style="display:inline-block">合计：<span class="r-fc fw-b">￥<span id="total_bottom"><?=$itemCost?></span></span></span></div>
            <div class="btn-lie mt10"><a href="javascript:void(0);" id="submit" href="<?=Url::to(['order/index'])?>" class="fr mr14">结算</a></div>
        </div>
    </div>

</div>


<script type="text/javascript">
	$(function(){
		//防止重复提交标识
		var hasSub = false;
		$("#submit").click(function(){
			if(!hasSub){
				hasSub = true;

				//判断是不是选择了收货地址
				var isSelected = <?=$isSelected ? 1 : 0 ?>;
				if(!isSelected){
					$.MsgBox.Alert("","请选择收货地址");
					return;
				}


				//用户地址id
				var address_id = $("#address").val();
				if(!address_id){
					$.MsgBox.Alert("","请选择收获地址");
					return;
				}
				//用户所选生成订单的商品sku的id串
				var sku_ids = "<?=$_GET['sku_ids']?>";
				//用户所选使用米券情况 购物车键为键,米券数量为值
				var quan_sku_ids = $("#quan_sku_id").val();
				//提交url地址
				var url = "<?= Url::to(['create-order']) ?>";
	            $.post(url,{address_id:address_id,sku_ids:sku_ids,quan_sku_ids:quan_sku_ids,'_csrf':'<?=Yii::$app->request->csrfToken?>'},
	                function(data){
	                	var res = eval('(' + data + ')');
            			if(parseInt(res.code) == 200){
            				location.href = "<?=Url::to(['payment/index'])?>"+"?order_id="+res.order_id;
	                    }else{
	                    	$.MsgBox.Alert("",res.msg);
	                    }
	                }
	            );
	        }
		})

		$(".slider-btn").click(function(){
	      	$(this).toggleClass('slider-btncur');
	      	if($(this).hasClass('slider-btncur')){
	      		useQuan($(this));
	      	}else{
	      		cancleUse($(this));
	      	}
	  	});
	})

	/**
	 * 使用米券
	 */
	function useQuan(o)
	{
		//获取所点的对应sku_id
		var tmp = o.attr("skuid").split("_");
		var sku_id = tmp[tmp.length-1];
		//获取所点项对应的店铺id
		var tmp1 = o.attr("storeid").split("_");
		var store_id = tmp1[tmp1.length-1];
		//获取当前所点商品使用的券数
		var sku_use_quan = parseFloat($("#sku_use_quan-"+sku_id).html());
		//获取用户可使用总券数
		var use_e = $("#can_use_quan");
		var can_use_quan = parseFloat(use_e.val());

		if(sku_use_quan <= can_use_quan){
			//修改可用券总数
			use_e.val(format(can_use_quan - sku_use_quan));
			//修改订单总金额
			var total_e = $("#total_store_"+store_id);
			var total = parseFloat(total_e.html());
			total_e.html(total - sku_use_quan);
			$("#total_bottom").html(total - sku_use_quan);
			//将sku_id加入到使用米券sku_id的域
			var quan_sku_id_e = $("#quan_sku_id");
			var quan_sku_id = quan_sku_id_e.val();
			if(quan_sku_id == null || quan_sku_id == ""){
				quan_sku_id_e.val(sku_id);
			}else{
				quan_sku_id_e.val(quan_sku_id+","+sku_id);
			}
		}else{
			$.MsgBox.Alert("","米券不足");
			//改成未选中状态
			o.toggleClass('slider-btncur');
		}
	}

	/**
	 * 取消使用米券
	 */
	function cancleUse(o)
	{
		//获取所点的对应sku_id
		var tmp = o.attr("skuid").split("_");
		var sku_id = tmp[tmp.length-1];
		//获取所点项对应的店铺id
		var tmp1 = o.attr("storeid").split("_");
		var store_id = tmp1[tmp1.length-1];
		//获取当前所点商品使用的券数
		var sku_use_quan = parseFloat($("#sku_use_quan-"+sku_id).html());
		//获取用户可使用总券数
		var use_e = $("#can_use_quan");
		var can_use_quan = parseFloat(use_e.val());

		//修改可用券总数
		use_e.val(format(can_use_quan + sku_use_quan));
		//修改订单总金额
		var total_e = $("#total_store_"+store_id);
		var total = parseFloat(total_e.html());
		total_e.html(total + sku_use_quan);
		$("#total_bottom").html(total + sku_use_quan);
		//把sku_id从使得米券的sku_id域名移除
		var quan_sku_id_e = $("#quan_sku_id");
		var quan_sku_id = quan_sku_id_e.val();
		var tmp_arr = quan_sku_id.split(",");
		var index = tmp_arr.indexOf(sku_id);
		if(index > -1){
			tmp_arr.splice(index, 1);
		}
		var new_quan_sku_id = tmp_arr.join(",");
		quan_sku_id_e.val(new_quan_sku_id);
	}

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
</script>