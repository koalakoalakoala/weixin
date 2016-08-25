<?php
use common\enum\OrderEnum;
use common\service\MemberService;
use common\service\OrderService;
use common\service\SkuService;
use common\service\SpecialCategoryService as SpcService;
use yii\helpers\Url;

$this->title = "提交订单";
?>

<?php if ($sku) { ?>

    <?php
    $goods_id = $sku->goods->goods_id;
    $isIntegral = SpcService::isIntegral($goods_id);
    $isExchange = SpcService::isExchange($goods_id);
    ?>

    <div class="mod_container">
        <!--tjdd 顶部信息 S-->
        <a href="<?= Url::to(['/order/order/select-addr', 'sku_ids' => $_GET['sku_id']]); ?>">
            <div class="tjdd-top">
                <div class="intjdd-top">
                    <div class="dm-icon tjdd-top-icon"></div>
                    <div class="tjdd-top-info">
                        <span class="jt right"></span>
                        <?php $isSelected = false; ?>
                        <?php if (isset($_GET['address_id'])) {
                            $isSelected = true; ?>
                            <div class="f14"><?= $addr->name; ?><span><?= $addr->mobile; ?></span></div>
                            <div
                                class="f12"><?= $addr->province . " " . $addr->city . " " . $addr->area . " " . $addr->detail; ?></div>
                        <?php } else { ?>
                            <?php
                            if ($addr) {
                                if ($addr->is_del == 0) {
                                    if ($addr->is_default == 0) {
                                        ?>
                                        <div href="#" class="tjdd-top-add <?php //=$address_null
                                        ; ?>">请选择收货地址
                                        </div>
                                    <?php } else {
                                        $isSelected = true;
                                        ?>
                                        <div class="f14"><?= $addr->name; ?><span><?= $addr->mobile; ?></span></div>
                                        <div
                                            class="f12"><?= $addr->province . " " . $addr->city . " " . $addr->area . " " . $addr->detail; ?></div>
                                    <?php }
                                    ?>
                                <?php } else { ?>
                                    <div href="#" class="tjdd-top-add <?php //= $address_null
                                    ; ?>">请添加收货地址
                                    </div>
                                <?php }
                                ?>
                            <?php } else { ?>
                                <div href="#" class="tjdd-top-add <?= $address_null; ?>">请添加收货地址</div>
                            <?php }
                            ?>
                        <?php }
                        ?>

                    </div>
                </div>
            </div>
        </a>
        <input type="hidden" value="<?= $addr ? $addr->id : 0; ?>" id="address"/>
        <!--顶部信息 E-->
        <!-- tjdd-content 提交订单中部内容 S-->
        <div class=" tjdd-center">

            <!--  有运费的模块 S-->
            <div class="phone-shopbox tjdd-center mq-tjdd-center">
                <!--<div class="shop-title cleafix tjdd-center-title">
			   <?php if ($sku->goods->store && $sku->goods->store->store_logo) { ?><img src="<?= Yii::$app->params['img_domain'] . $sku->goods->store->store_logo; ?>" style="width:25px;height:25px;" /> <?php }
                ?> <?= $sku->goods->supplier ? '<span class="dm-icon my-index-icon dm-title-icon"></span>' : ''; ?><span><?= $sku->goods->supplier ? "中盾自营，[" . $sku->goods->supplier->name . "]供货" : ($sku->goods->store ? $sku->goods->store->store_name : ""); ?></span>
			<a href="<?= $sku->goods->store ? Url::to(['/store/store/view?id=' . $sku->goods->store->id]) : "#"; ?>" class="shop-jt"><span class="jt right"></span></a>
		   </div>-->
                <div class=" tjdd-center-content">
                    <div class="home-tuan-lists iobrv intjdd-center-content">
                        <div class="dm-item Fix tjdd-item">
                            <a href="#">
                                <div class="cnt shopcont shopcont_p">
                                    <a href="<?= Url::to(['/goods/goods/view?id=' . $sku->goods->goods_id]); ?>"
                                       class="shoppr"><img class="pic"
                                                           src="<?= $sku->goods->goodsgallery ? Yii::$app->params['img_domain'] . $sku->goods->goodsgallery->image : ''; ?>"
                                                           alt=""></a>
                                    <div class="content-wrap ">
                                        <div class="content-wrap2">
                                            <div class="shop-content ">
                                                <div class="title clearfix">
                                                    <a href="<?= Url::to(['/goods/goods/view?id=' . $sku->goods->goods_id]); ?>"
                                                       class="in-tit"><?= $sku->goods->name; ?></a>
                                                </div>
                                                <div
                                                    class="shop-des"><?= SkuService::searchSkuAttrNameValue($sku); ?></div>
                                                <div class="g-fc" href="#">数量 :×<?= $num; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <input type="hidden" id="can_use" value="<?= OrderService::getMiQuan(Yii::$app->user->id); ?>"/>
                        <!-- <div class="yf-list-line clearfix">
                           <div class="fl">运费</div>
                           <div class="fr">免运费</div>
                       </div> -->

                        <!--送米券 S-->
                        <?php if ($sku->cash_deduction > 0) { ?>
                            <div class="mq-list-line clearfix">
                                <div class="mq-list-line-pl">
                                    <div class="mq-list-line-left">我的米券：<span
                                            class="r-fc2 d-inb"><?= MemberService::getCoupon(Yii::$app->user->id); ?></span>
                                    </div>
                                    <div class="mq-btn mq-list-line-right"><span class="mb-14">可用<span
                                                class="r-fc2"><?= $sku->cash_deduction * $num; ?></span>米券抵扣<span
                                                class="r-fc2 d-inb">￥<?= $sku->cash_deduction * $num; ?></span></span><input
                                            class="mq_input" type="checkbox" id="checkbox-10-1 ?>"/><span
                                            class="slider-btn" onclick="isCheck(this)" for="checkbox-10-1"
                                            data="<?= $sku->cash_deduction * $num; ?>"></span></div>
                                    <!--<div class="fr mq-btn mq-list-line-right"><span class="mb-14">商品可使用<?= $sku->cash_deduction * $num; ?>米券</span><input class="mq_input"  type="checkbox" id="checkbox-10-1 ?>" /><span class="slider-btn" onclick="isCheck(this)" for="checkbox-10-1" data="<?= $sku->cash_deduction * $num; ?>"></span></div>-->
                                </div>
                            </div>
                        <?php }
                        ?>
                        <!--送米券 E-->

                        <?php if ($isIntegral) { ?>
                            <!--送积分 S-->
                            <div class="mq-list-line">
                                <div class="fon12">赠送价值<span class="r-fc2"><?= $sku->goods->egd * 100; ?>%</span>的积分
                                </div>
                            </div>
                            <!--送积分 E-->
                        <?php }
                        ?>

                        <?php if ($isExchange) { ?>
                            <!--兑换券 S-->
                            <div class="mq-list-line">
                                <div class="fon12">我的消费券：<span class="r-fc2"
                                                               id="myExchange"><?= MemberService::getExchange(Yii::$app->user->id); ?></span>
                                </div>
                            </div>
                            <!--兑换券 E-->
                        <?php }
                        ?>

                        <!--<div class="mq-list-line clearfix">
					<div class="fl">返利</div>
					<div class="fr mq-btn"><span>预计返利: <?= OrderService::getGolds($sku->market_price * $num, $sku->goods->egd); ?></span></div>
				</div>-->
                        <!-- <div class="input-box">
                            <input type="text" placeholder="给卖家留言" maxlength="70" />
                        </div> -->
                        <div class="count-list-line clearfix">
                            <?php if (!$isExchange) { ?>
                                共<?= $num; ?>件商品，合计  <span>¥<span class="fw-b"
                                                                  id="total"><?= ($sku->market_price + $sku->goods->freight) * $num; ?></span></span>
                            <?php } else { ?>
                                共<?= $num; ?>件商品，兑换需消费券 <span><span class="fw-b f16"
                                                                      id="total"><?= ($sku->market_price + $sku->goods->freight) * $num; ?></span></span>
                            <?php }
                            ?>
                        </div>
                        <input class="use_quan" type="hidden" id="use_quan" value="0"/>
                    </div>
                </div>
            </div>
        </div>
        <!-- tjdd-content 提交订单中部内容 E-->

        <!--底端-->
        <div style="height: 64px;"></div>
        <div class="bb bt pf-b0">
            <div class=" btn-jion btn-jionp">
                <div class="pro-price tjdd-price">
                    <?php if (!$isExchange) { ?>
                        共<span class="r-fc fw-b"><?= isset($_GET['num']) ? $_GET['num'] : 1; ?></span>件商品，<span
                            style="display:inline-block">合计：<span class="r-fc fw-b">￥<span
                                    id="total_bottom"><?= ($sku->market_price + $sku->goods->freight) * $num; ?></span></span></span>
                    <?php } else { ?>
                        共<span class="r-fc fw-b f16"><?= isset($_GET['num']) ? $_GET['num'] : 1; ?></span>件商品，<span
                            style="display:inline-block">兑换需消费券<span class="r-fc fw-b f16"
                                    id="total_bottom"><?= ($sku->market_price + $sku->goods->freight) * $num; ?></span></span></span>
                    <?php }
                    ?>
                </div>
                <div class="btn-lie mt10"><a href="javascript:void(0);" id="submit" class="fr mr14">结算</a></div>
            </div>
        </div>
        <!--<div class="tjdd-btn">
              <div class="btn-lie intjdd-btn">
                <a href="javascript:void(0);" id="submit" class="fr">提交订单</a>
             </div>
        </div>-->

    </div>
<?php }
?>


<script type="text/javascript">
    $(function () {
        var hasSub = false;
        $("#submit").click(function () {
            if (!hasSub) {
                //如果是兑换商品
                var isExchange = "<?=$isExchange;?>";
                if (isExchange) {
                    var total = parseFloat($("#total").text());
                    var myExchange = parseFloat($("#myExchange").text());
                    if (total > myExchange) {
                        $.MsgBox.Alert("", "兑换券余额不足！");
                        return false;
                    }
                }

                //判断是不是选择了收货地址
                var isSelected = <?=$isSelected ? 1 : 0;?>;
                if (!isSelected) {
                    $.MsgBox.Alert("", "请选择收货地址");
                    return;
                }

                hasSub = true;
                var address_id = $("#address").val();
                var sku_id = <?=$sku->sku_id;?>;
                var num = <?=$num;?>;
                var url = "<?=Url::to(['create-buy-now-order']);?>";
                //获取米券抵扣
                var quan = parseInt($("#use_quan").val());
                $.post(url, {
                        address_id: address_id,
                        sku_id: sku_id,
                        num: num,
                        quan: quan,
                        '_csrf': '<?=Yii::$app->request->csrfToken;?>'
                    },
                    function (data) {
                        var res = eval('(' + data + ')');
                        if (parseInt(res.code) == 200) {
                            if (!isExchange) {
                                location.href = "<?=Url::to(['payment/index']);?>" + "?order_id=" + res.order_id;
                            } else {
                                location.href = "<?=Url::to(['payment/exchange']);?>" + "?order_id=" + res.order_id;
                            }
                        } else {
                            $.MsgBox.Alert("", res.msg);
                        }
                    }
                );
            }
        })
    })

    $(".slider-btn").click(function () {
        $(this).toggleClass('slider-btncur');
    });

    function isCheck(o) {
        var quan = parseInt($(o).attr("data"));
        if (!$(o).hasClass("slider-btncur")) {
            //读取用户可用券数
            var can_use = $("#can_use").val();
            if (quan > can_use) {
                $(o).toggleClass('slider-btncur');
                $.MsgBox.Alert("", "米券余额不足");
            } else {
                //从总价中减除米券部分
                changeTotal(-quan);
                $("#use_quan").val(quan);
            }
        } else {
            //从总价中加上米券部分
            changeTotal(quan);
            $("#use_quan").val(0);
        }
    }

    //更改总价的方法
    function changeTotal(quan) {
        var total_e = $("#total");
        var total_old = parseFloat(total_e.text());
        var total_new = total_old + quan;
        total_e.text(total_new);
        $("#total_bottom").text(total_new);
    }
</script>