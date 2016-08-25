<?php
use yii\widgets\ListView;
use kop\y2sp\ScrollPager;
?>
<!-- banner S-->
<!--    <div class="zd-banners">-->
<!--        <div class="zd-banner-top">-->
<!--        <h1><投资换购专区></h1>-->
<!--        </div>-->
<!--        <div class="zd-banner-bottom">-->
<!--            <div class="zd-banner-content">-->
<!--                <h2 class="zd-banner-title">活动介绍</h2>-->
<!--                <p class="zd-banner-text">投资换购专题是中盾跨境免税商城联合“钱富宝”理财推出的投资消费活动，致力于为用户提供创新的消费体验的同时，实现用户资金增值。</p>-->
<!--                <h2 class="zd-banner-title">活动规则</h2>-->
<!--                <p class="zd-banner-text">-->
<!--                1、消费根据每款产品的投资说明进行投资。-->
<!--                </br>2、支付完成后，消费者确认收货后开始计息。-->
<!--                </br>3、中途用户申请赎回，则扣除商品单价，并按活动天数发放利息</p>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <!-- banner E-->

    <!--团购专区 S-->
    <div class="zd-mod-tit">
        <h2 class="d-pav-tit">更多产品</h2>
    </div>
    <div class="zd-compre-boxs">
        <div class="d-daming-fine d-index-dis zd-daming-fine">
            <section class="d-fine-prlist">
                <div class="d-fine-prbox">
                    <ul class="clearfix">
                        <?php
                            echo ListView::widget([
                                'dataProvider' => $dataProvider,
                                'itemOptions' => ['class' => 'item'],
                                'itemView' => '_item_list',
                                'layout' =>'{items}{pager}',
                                'emptyText' => '暂无活动数据',
                                'pager' => [
                                    'class' => ScrollPager::className(),
                                    'enabledExtensions' => [
                                        ScrollPager::EXTENSION_TRIGGER,
                                        ScrollPager::EXTENSION_SPINNER,
                                        ScrollPager::EXTENSION_NONE_LEFT,
                                        ScrollPager::EXTENSION_PAGING,
                                    ],
                                    'triggerText' => '<a href="javascript:void(0)" class="dm-homeld text-center">继续向下加载更多</a>',
                                    'triggerTemplate'=>'<div class="col-md-12" style="text-align: center; cursor: pointer;"><a class="btn-group-justified btn-xs button button-3d button-primary button-pill">{text}</a></div>',
                                    'noneLeftText'=>'<p class="text-center"></p>',
                                    'triggerOffset'=>2,
                                    'negativeMargin'=>10,
                                ]
                            ]);
                        ?>
                    </ul>
                </div>
            </section>
        </div>
</div>

 <script type="text/javascript">
  /*标题固定在窗口 S*/
       var topm = $('.stick-tittle').offset().top;
    $(window).scroll(function() {
        if ($(window).scrollTop() >= topm) {
            $(".stick-tittle").addClass("zd-fixedtop");
            $('.d-modp').hide();
        } else {
            $(".stick-tittle").removeClass("zd-fixedtop");
            $('.d-modp').show();
        }
    });
    /*标题固定在窗口 E*/

 </script>