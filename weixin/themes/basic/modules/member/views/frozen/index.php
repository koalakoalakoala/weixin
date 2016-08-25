<?php
use yii\helpers\Url;
use yii\widgets\ListView;
use kop\y2sp\ScrollPager;

$this->title = "冻结金额";
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="balance-top my-jftx-top">
                <div class="">冻结金额</div>
                <div class="price"><?=$money->fronze_money?></div>
            </div>

        <!-- my-jf-buttom 我的积分底部内容 S-->
        <div class="balance-buttom my-jf-buttom">
            <!-- my-jf-title 我的积分标题 S-->
            <div class="xzzf-title balance-buttom-title">
                <div class="inxzzf-title inbalance-title">
                    <div class="xzzf-title-box">
                        <div class="inxzzf-title-box f18">冻结明细</div>
                    </div>
                </div>
            </div>
            <!-- my-jf-title 我的积分标题 E-->
            <ul id='data_page'>
                <li class="stick-tittle">
                    <ul class="balance-btm-tit">
                        <li>时间</li>
                        <li>明细</li>
                        <li>备注</li>
                    </ul>
                </li>
                <?php
                if ($dataProvider->getCount()) {
                    echo ListView::widget([
                        'dataProvider' => $dataProvider,
                        'itemOptions' => ['class' => 'item'],
                        'itemView' => '_item_index',
                        'layout' =>'{items}{pager}',
                        'emptyText' => '暂无数据',
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
                } else {
                    echo "<p style=\"text-align:center\">暂时无数据</p>";
                }
                ?>
            </ul>
    </div>
    <script type="text/javascript" >
     /*标题固定在窗口 S*/
       var topm = $('.stick-tittle').offset().top;
    $(window).scroll(function() {
        if ($(window).scrollTop() >= topm) {
            $(".stick-tittle").addClass("dm-fixedtop");
        } else {
            $(".stick-tittle").removeClass("dm-fixedtop");
        }
    });
    /*标题固定在窗口 E*/
    </script>