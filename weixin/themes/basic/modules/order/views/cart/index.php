<?php
use yii\helpers\Url;
use common\service\SkuService;
$this->title = Yii::t('app', '购物车');
$this->params['breadcrumbs'][] = $this->title;
?>

      <div class="mod_containersel">
        <?php if($list){
            foreach($list as $k => $v){ ?>
            <!-- 内页统一头部 E-->
            <div class="phone-shopbox" id="shop_box-<?=$k?>">
                <!--<div class="shop-title shop-title-bg cleafix">
                      <a href="javascript:;" class="dm-icon select shop-icon click-item"></a>
			          <a href="<?= isset($v['store']) && $v['store']->ischeck !=4 ? Url::to(['/store/store/view?id='.$v['store']->id]) : "javascript:void(0);" ?>" class="inshop-title">
                            <?php if(isset($v['store']) && $v['store']->store_logo){ ?> <img src="<?=Yii::$app->params['img_domain'].$v['store']->store_logo?>" style="width:25px;height:25px;" /> <?php } ?> <?=isset($v['supplier']) ? '<span class="dm-icon my-index-icon dm-title-icon"></span>' : ''?>
			                <span class="word"><?=isset($v['store']) ? ($v['store']->store_name.($v['store']->ischeck == 4 ? "&nbsp;&nbsp;&nbsp;&nbsp;<font color=\"gray\">店铺已关闭</font>" : "")) : (isset($v['supplier']) ? " 中盾自营，[".$v['supplier']->name."]供货" : '')?></span>
			                <a href="javascript:;" class="shop-jt"><span class="jt right"></span></a>
			          </a>
                </div>-->

                <div class="home-tuan-lists iobrv">
                    <?php foreach($v['goods'] as $v1){ ?>
                    <div class="dm-item Fix" id="item_main-<?=$v1->sku_id?>">
                        <div class="item-icon-pst"><span id="<?=$v1->sku_id?>" shelves_status="<?=$v1->is_shelves?>" class="dm-icon select  dm-item-sel cursorp click-item"></span><input type="hidden" value=<?=$v1->market_price + $v1->goods->freight?> /></div>
                        <div class="cnt  item-pst">
                            <a href="<?=$v1->is_shelves ? Url::to(['/goods/goods/view?id='.$v1->goods->goods_id]) : 'javascript:void(0);'?>" class="shoppr shopprp"><img class="pic" src="<?=$v1->goods->goodsgallery? Yii::$app->params['img_domain'].$v1->goods->goodsgallery->image : '' ?>" alt=""></a>
                            <div class="content-wrap ">
                                 <div class="content-wrap2">
                                    <div class="shop-content ">
                                        <div class="title clearfix"><a href="<?=$v1->is_shelves ? Url::to(['/goods/goods/view?id='.$v1->goods->goods_id]) : 'javascript:void(0);'?>" class="fl" style="width:80%;"><span class="in-tit in-titp"><?=$v1->goods->name ?><?=!$v1->is_shelves ? '&nbsp;&nbsp;&nbsp;&nbsp;<font color="gray">商品已下架</font>' : ''?></span></a><a id="del-<?=$v1->sku_id?>" class="sc-btn fr" href="javascript:void(0);" onclick="del(this);">删除</a></div>
                                        <div class="shop-des" ><?=SkuService::searchSkuAttrNameValue($v1)?></div>
                                        <div class="price" style="padding-bottom:0px;"><span>¥ <b id="item_cost-<?=$v1->sku_id?>"><?=$v1->quantity * ($v1->market_price + $v1->goods->freight) ?></b></span></div>
                                   </div>
                               </div>
                           </div>
                        </div>
                        <div class="distance shopivr shopivrt">
                            <ul class="Fix boxright">
                                <a id="decrease-<?=$v1->sku_id?>" ref="<?=$k?>" href="javascript:void(0);" onclick="decrease(this)" class="bujivrt biovirt number-jian">–</a>
                                <input onchange="change(this);" class="product_num" id="item_number-<?=$v1->sku_id?>" value="<?=$v1->quantity?>" oldValue="<?=$v1->quantity?>">
                                <a id="increase-<?=$v1->sku_id?>" href="javascript:void(0);" onclick="increase(this)" class="bujivrt jbiors number-jia">+</a>
                            </ul>
                        </div>

                    </div>
                    <input type="hidden" id="item_total-<?=$v1->sku_id?>" value="<?=$v1->quantity * ($v1->market_price + $v1->goods->freight) ?>" />
                    <input type="hidden" id="item_price-<?=$v1->sku_id?>" value="<?=$v1->market_price + $v1->goods->freight?>" />
                <?php } ?>
            </div>

         </div>
         <?php } ?>

        <!--底端-->
        <div class="phone-shopbox bb bt" id="action_box-<?=$k?>">
            <div class=" btn-jion btn-jionp bt">

                    <span  class="dm-icon select  click-item shop-iconp allitem-btn cursorp"></span>
                    <div class="pro-price "><span class="inprice"><span></span>  &nbsp;<span class="dm-wcl"> 总金额：<span id="totalCost" class="span1 r-fc">￥<b><?=Yii::$app->cart->cost?></b></span></span></span></div>
                    <div class="btn-lie btn-liep clearfix mt10"><a href="javascript:void(0);" id="submit" href="<?=Url::to(['order/index'])?>" class="fr mr14">结算（<span id="totalCount" class="pay-allcont"><?=Yii::$app->cart->count?></span>）</a></div>

            </div>
        </div>
        <?php } ?>
</div>
        <div class="goshop-content" <?php if($list){ ?>style="display: none"<?php } ?>>
            <div class="goshop-content-img">
                <img src="/img/goshopping.png">
            </div>
            <div class="goshop-content-txt">
                <p class="f18">购物车还是空的！</p>
                <p class="f14">快去挑选你的商品吧！<a href="<?=Url::to(['/home/home/index'])?>" class="r-fc">去逛逛</a></p>
            </div>
        </div>


<script type="text/javascript">
           /*选择商品 S*/
           	$('.shop-icon').click(function(){
				if (!$(this).hasClass("select")){
					$(this).removeClass('no-select').addClass('select');
					$(this).parent().siblings().find('.dm-item-sel').removeClass('no-select').addClass('select');
					if(!$(this).parents('.mod_containersel').find('.shop-icon').hasClass("no-select"))	{
						if(!$(this).parents('.mod_containersel').find('.dm-item-sel').hasClass("no-select")){
							$('.allitem-btn').removeClass('no-select').addClass('select');
						}else{
							$('.allitem-btn').removeClass('select').addClass('no-select');
						}
					}
					else {
						$('.allitem-btn').removeClass('select').addClass('no-select');
					}
				}else{
					$(this).removeClass('select').addClass('no-select');
					$(this).parent().siblings().find('.dm-item-sel').removeClass('select').addClass('no-select');
					if(!$(this).parents('.mod_containersel').find('.shop-icon').hasClass("no-select"))	{
						if(!$(this).parents('.mod_containersel').find('.dm-item-sel').hasClass("no-select")){
							$('.allitem-btn').removeClass('no-select').addClass('select');
						}else{
							$('.allitem-btn').removeClass('select').addClass('no-select');
						}
					}
					else {

						$('.allitem-btn').removeClass('select').addClass('no-select');
					}
				}

			});

			$('.dm-item-sel').click(function(){
				if(!$(this).hasClass("select")){
					$(this).removeClass('no-select').addClass('select');
				}else{
					$(this).removeClass('select').addClass('no-select');
				}
				
				if(!$(this).parents('.phone-shopbox').find('.dm-item-sel').hasClass("select")){
					$(this).parents('.home-tuan-lists').siblings().children('.shop-icon').removeClass('select').addClass('no-select');
				}else{
					$(this).parents('.home-tuan-lists').siblings().children('.shop-icon').removeClass('no-select').addClass('select');
				}
				if(!$(this).parents('.mod_containersel').find('.dm-item-sel').hasClass("no-select")){
					
					$('.allitem-btn').removeClass('no-select').addClass('select');
				}else{
					$('.allitem-btn').removeClass('select').addClass('no-select');

				}
			});

			$('.allitem-btn').click(function(){
				if(!$(this).hasClass("select")){
					$(this).removeClass('no-select').addClass('select');
					$(this).parents('.phone-shopbox ').siblings().find('.dm-item-sel').removeClass('no-select').addClass('select');
					$(this).parents('.phone-shopbox ').siblings().find('.shop-icon').removeClass('no-select').addClass('select');
				}else{
					$(this).removeClass('select').addClass('no-select');
					$(this).parents('.phone-shopbox ').siblings().find('.dm-item-sel').removeClass('select').addClass('no-select');
					$(this).parents('.phone-shopbox ').siblings().find('.shop-icon').removeClass('select').addClass('no-select');
				}
			});
           /*选择商品 E*/

          /*$('.sc-btn').click(function(){
                var box=$(this).parents('div.phone-shopbox');
                $(this).parents('.dm-item').remove();
                if(box.children('.home-tuan-lists').find('.dm-item').length<1){
                    box.remove();
                }
            });*/
            
           /*计算屏幕width后执行相应操作 S*/
          $(window).each(function(){
                    if($(this).width()<430){
            		$('.dm-wcl').css('display','block');
            	}else{
            		
            		$('.dm-wcl').css('display','inline');
            	}
              }); 
           /*计算屏幕width后执行相应操作 E*/

            /*购物车数量的变化 S*/
            $(function(){
                    $('.click-item').click(function(){
                        var count = 0;
                        var cost = 0;
                        $(".click-item").each(function(){
                            if($(this).hasClass("dm-item-sel") && $(this).hasClass("select")){
                                //获取当前项的数量
                                var num = parseInt($(this).parent().next().next().find('input').val());
                                //获取当前的价格
                                var price = $(this).next().val();
                                count += num;
                                cost += num*price;
                            }
                        })
                        $("#totalCount").html(count);
                        $("#totalCost > b").html(format(cost));
                    })

                    $("#submit").click(function(){
                        var url = "<?=Url::to(['order/index'])?>";
                        var sku_ids = "";
                        var has_unshelves = false;  //标记有无下架的商品
                        $(".dm-item-sel").each(function(){
                            if($(this).hasClass("select")){
                                if(sku_ids.length>0){
                                    sku_ids += ","+this.id;
                                }else{
                                    sku_ids = this.id;
                                }
                                //判断用户有没有选择下架的商品
                                if($(this).attr("shelves_status")==0){
                                    has_unshelves = true;
                                }
                            }
                        })
                        if(sku_ids.length>0){
                            if(has_unshelves){
                                $.MsgBox.Alert("","不能选择已下架商品");
                            }else{
                                location.href = url + "?sku_ids=" + sku_ids;
                            }
                        }else{
                            $.MsgBox.Alert("","请选择要结算的商品");
                        }
                    })
            })
            /*购物车数量的变化  E*/


            /**
             * 删除购物车项
             */
            function del(o)
            {
                var tmp = o.id.split("-");
                var sku_id = parseInt(tmp[tmp.length -1]);
                $.MsgBox.Confirm("","确认删除？" ,function(){
                    var url = "<?=Url::to(['remove-one'])?>";
                    $.post(url,{sku_id:sku_id,'_csrf':'<?=Yii::$app->request->csrfToken?>'},
                    function(data){
                            var res = eval('(' + data + ')');
                            if(parseInt(res.code) == 200){
                                var box=$(o).parents('div.phone-shopbox');
                                $(o).parents('.dm-item').remove();
                                var item_total = parseFloat($("#item_total-"+sku_id).val());
                                var totalCost = parseFloat($("#totalCost > b").html());
                                var totalCostNew = totalCost - item_total;
                                $("#totalCost > b").html(format(totalCostNew));
                                if(box.children('.home-tuan-lists').find('.dm-item').length<1){
                                    box.remove();
                                }
                                if(totalCostNew == 0){
                                    $(".phone-shopbox").remove();
                                    $(".goshop-content").show();
                                }
                                setNumber();
                            }else{
                                $.MsgBox.Alert(res.msg);
                            }
                        }
                    );
                });
            }


            /**
             * 增加购物车项
             */
            function increase(o)
            {
                var tmp = o.id.split("-");
                var sku_id = parseInt(tmp[tmp.length -1]);
                var url = "<?=Url::to(['increase'])?>";
                $.post(url,{sku_id:sku_id,'_csrf':'<?=Yii::$app->request->csrfToken?>'},
                function(data){
                        var res = eval('(' + data + ')');
                        if(parseInt(res.code) == 200){
                            var item_total = parseFloat($("#item_total-"+sku_id).val());
                            var item_price = parseFloat($("#item_price-"+sku_id).val());
                            var item_total_new = item_total + item_price;
                            //更改数量显示
                            var number = parseInt($("#item_number-"+sku_id).val()) + 1;
                            $("#item_number-"+sku_id).val(number);
                            $("#item_number-"+sku_id).attr("oldValue",number);
                            //更改单个商品合计
                            $("#item_cost-"+sku_id).html(format(item_total_new));
                            $("#item_total-"+sku_id).val(format(item_total_new));
                            //更改总价显示
                            if($("#"+sku_id).hasClass("select")){
                                var totalCost = parseFloat($("#totalCost > b").html());
                                var totalCostNew = totalCost + item_price;
                                $("#totalCost > b").html(format(totalCostNew));
                            }
                            setNumber();
                        }else{
                            $.MsgBox.Alert("",res.msg);
                            if(res.msg == "库存不足"){
                                $(".number-jia").addClass("number-cur", true);
                            }
                        }
                    }
                );
            }

            /**
             * 减少购物车项
             */
            function decrease(o)
            {
                var tmp = o.id.split("-");
                var sku_id = parseInt(tmp[tmp.length -1]);
                var product_num = $(o).next(".product_num").val();

                //购买商品数量为1时，不能再减
                if(product_num == 1){
                	$(".number-jian").attr("disabled", true);
                	$(".number-jian").addClass("number-cur", true);
                	$.MsgBox.Alert("","购买的商品数量不能小于1");
                
                	return false; 
                }

                var url = "<?=Url::to(['decrease'])?>";
                $('.number-jia').removeClass('number-cur');
                $.post(url,{sku_id:sku_id,'_csrf':'<?=Yii::$app->request->csrfToken?>'},
                function(data){
                        var res = eval('(' + data + ')');
                        if(parseInt(res.code) == 200){
                            var item_total = parseFloat($("#item_total-"+sku_id).val());
                            var item_price = parseFloat($("#item_price-"+sku_id).val());
                            var item_total_new = item_total - item_price;
                            //更改单个商品合计
                            $("#item_cost-"+sku_id).html(format(item_total_new));
                            $("#item_total-"+sku_id).val(format(item_total_new));
                            //更改总价显示
                            if($("#"+sku_id).hasClass("select")){
                                var totalCost = parseFloat($("#totalCost > b").html());
                                var totalCostNew = totalCost - item_price;
                                $("#totalCost > b").html(format(totalCostNew));
                            }
                            
                            //更改单商品数量显示
                            var number = parseInt($("#item_number-"+sku_id).val()) - 1;
                            $("#item_number-"+sku_id).val(number);
                            $("#item_number-"+sku_id).attr("oldValue",number);
                            //设置总数
                            setNumber();

                            var box=$(o).parents('div.phone-shopbox');

                            //如果减少到0删除该商品
                            if(number == 0){
                                $("#item_main-"+sku_id).remove();
                            }
                            
                            //店铺下所有商品没有了，删除店铺
                            if(box.children('.home-tuan-lists').find('.dm-item').length<1){
                                box.remove();
                            }

                            //如果所有店铺商品都没有了，则去掉底部的结算，弹出去购物页面
                            if($(".dm-item").length == 0){
                                $(".phone-shopbox").remove();
                                $(".goshop-content").show();
                            }
                        }else{
                            $.MsgBox.Alert("",res.msg);
                            $(".number-jia").addClass("number-cur", true);
                        }
                    }
                );
            }

            /**
             * 更改购物车数目
             */
            function change(o)
            {
                var tmp = o.id.split("-");
                var sku_id = parseInt(tmp[tmp.length -1]);
                var oldNum = parseInt($(o).attr("oldValue"));
                var num = $(o).val();
                var url = "<?=Url::to(['change'])?>";
                if(isNaN(num)){
                    $(o).val(oldNum);
                    $("#item_number-"+sku_id).attr("oldValue",num);
                    return;
                }
                num = parseInt(num);
                if(num < 1){
                    $(o).val(oldNum);
                    $("#item_number-"+sku_id).attr("oldValue",num);
                    return;
                }

                $.post(url,{sku_id:sku_id,number:num,'_csrf':'<?=Yii::$app->request->csrfToken?>'},
                function(data){
                        var res = eval('(' + data + ')');
                        if(parseInt(res.code) == 200){
                            var item_total = parseFloat($("#item_total-"+sku_id).val());
                            var item_price = parseFloat($("#item_price-"+sku_id).val());
                            var item_total_new = item_total + (num - oldNum)*item_price;
                            //更改单个商品合计
                            $("#item_cost-"+sku_id).html(format(item_total_new));
                            $("#item_total-"+sku_id).val(format(item_total_new));
                            //更改总价显示
                            if($("#"+sku_id).hasClass("select")){
                                var totalCost = parseFloat($("#totalCost > b").html());
                                var totalCostNew = totalCost + (num - oldNum)*item_price;
                                $("#totalCost > b").html(format(totalCostNew));
                            }
                            //更改单商品数量显示
                            $("#item_number-"+sku_id).val(num);
                            $("#item_number-"+sku_id).attr("oldValue",num);
                            //设置总数
                            setNumber();
                        }else{
                            $(o).val(oldNum);
                            $.MsgBox.Alert("",res.msg);
                            $('.number-jia').addClass('number-cur');
                        }
                    }
                );
            }

            /**
             * 设置总数量
             */
            function setNumber()
            {
                var number = 0;
                $(".product_num").each(function(){
                    //选中的商品才参与计算总价格
                    var tmp = this.id.split("-");
                    var id = tmp[tmp.length-1];
                    if($("#"+id).hasClass("select")){
                        number += parseInt($(this).val());
                    }
                });
                $("#totalCount").html(number);
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
            
            $('.product_num').each(function(){
            	  if($('.product_num').val()==1){
            	  	$(this).siblings('.number-jian').addClass('number-cur');
            	  }
            	      
            });
            $('.number-jia').click(function(){
            	  	$(this).siblings('.number-jian').removeClass('number-cur');      
            });
        </script>
        






