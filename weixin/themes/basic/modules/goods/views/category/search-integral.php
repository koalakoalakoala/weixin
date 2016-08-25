<?php
use kop\y2sp\ScrollPager;
use yii\widgets\ListView;
use yii\helpers\Url;

$this->title = '积分专区';
?>
<!--轮播S-->
<div class="addWrap">
    <div class="swipe" id="mySwipe">
        <div class="swipe-wrap">
            <?php if ($banners) {?>
                <?php foreach($banners as $banner):?>
                    <div>
                        <a href="javascript:;"><img class="img-responsive" src="<?= Yii::$app->params['img_domain'].$banner->imgurl ?>"/>
                        </a>
                    </div>
                <?php endforeach;?>
            <?php }?>
        </div>
    </div>

    <ul id="position">
        <li class="cur"></li>
        <li></li>
        <li></li>
    </ul>
</div>
<!--轮播E-->
<!--zq_index_tit-list S-->
<div class="zq-tip">
    购物就赠<span class="r-fc3">C积分</span>，尊享实惠又增值，当前积分价<span class="r-fc3">1.05</span>元
</div>
<?php
    $priceCur=$priceDown=$priceUp=$zhCur=$zhUp=$zhDown=$salesCur=$salesUp=$salesDown = false;
    if (isset($_GET['sort']) && $_GET['sort']) {
        $sort = $_GET['sort'];
        if ($sort == 'market_price' || $sort == '-market_price') {
            $priceCur = true;
            $sort == 'market_price' ? ($priceUp = true) : ($priceDown = true);
        } else if ($sort == 'sales' || $sort == '-sales') {
            $salesCur = true;
            $sort == 'sales' ? ($salesUp = true) : ($salesDown = true);
        } else if ($sort == 'zh' || $sort == '-zh') {
            $zhCur = true;
            $sort == 'zh' ? ($zhUp = true) : ($zhDown = true);
        }
    }
?>
<!-- 排序选项-->
<div class="d-tab-background">
    <ul class="d-product-main">
        <li>
            <a href="<?=Url::to(['search?sort='.((isset($_GET['sort']) && $_GET['sort'] == '-zh') ?
                    'zh' : '-zh')])?>"
               class="sort-btn <?php if ($zhCur) echo 'cur';?>">综合
                <span class="d-icon-down
                    <?php if($zhUp){ ?>d-icon-up<?php } ?>
                    <?php if($zhDown) { ?>d-icon-rdown<?php } ?>">
                </span>
            </a>
        </li>
        <li>
            <a href="<?=Url::to(['search?sort='.((isset($_GET['sort']) && $_GET['sort'] == '-sales') ?
                    'sales' : '-sales')])?>"
               class="sort-btn <?php if ($salesCur) echo 'cur';?>">销量
                <span class="d-icon-down
                    <?php if($salesUp){ ?>d-icon-up<?php } ?>
                    <?php if($salesDown) { ?>d-icon-rdown<?php } ?>">
                </span>
            </a>
        </li>
        <li>
            <a href="<?=Url::to(['search?sort='.((isset($_GET['sort']) && $_GET['sort'] == '-market_price') ?
                    'market_price' : '-market_price')])?>"
               class="sort-btn <?php if ($priceCur) echo 'cur';?>">价格
                <span class="d-icon-down
                    <?php if($priceUp){ ?>d-icon-up<?php } ?>
                    <?php if($priceDown) { ?>d-icon-rdown<?php } ?>">
                </span>
            </a>
        </li>
    </ul>
</div>
<!--zq_index_tit-list E-->

<!--product 商品展示  S -->
<div class="d-daming-fine d-index-dis clearfix">
    <section class="d-fine-prlist">
        <div class="d-fine-prbox">
            <ul>
                <?php
                    echo ListView::widget([
                        'dataProvider' => $dataProvider,
                        'itemOptions' => ['class' => 'item'],
                        'itemView' => '_item-search-integral',
                        'layout' => '{items}{pager}',
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
                            'triggerTemplate' => '<div class="col-md-12" style="text-align: center; cursor: pointer;"><a class="btn-group-justified btn-xs button button-3d button-primary button-pill">{text}</a></div>',
                            'noneLeftText' => '<p class="text-center"></p>',
                            'triggerOffset' => 2,
                            'negativeMargin' => 10,
                        ],
                    ]);
                    ?>
            </ul>
        </div>
    </section>
</div>

   <!--回到顶部--S-->
<div style="display: none;" class="back-top" id="toolBackTop">
   <a title="返回顶部" onclick="window.scrollTo(0,0);return false;" href="#top" class="back-top backtop">
   </a>
</div>
 <!--回到顶部--E-->

<script type="text/javascript">
/*banner 轮播图S*/
var bullets = document.getElementById('position').getElementsByTagName('li');

var banner = Swipe(document.getElementById('mySwipe'), {
    auto: 4000,
    continuous: true,
    disableScroll:false,
    callback: function(pos) {
        var i = bullets.length;
        while (i--) {
            bullets[i].className = ' ';
        }
        bullets[pos].className = 'cur';
    }
})
/*banner 轮播图 E*/
</script>
