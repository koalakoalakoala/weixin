<?php
use yii\widgets\ListView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\enum\GoodsEnum;
use common\models\Category;
use common\models\Brand;
use kop\y2sp\ScrollPager;

$this->title = '商品列表';
?>


<!--提示信息 begin-->
<div class="zq-tip bb">进口时尚汽车，尽显奢华尊贵</div>
<!--提示信息 end-->
<!-- 排序 begin-->
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
<div class="d-tab-background stick-tittle">
    <ul class="d-product-main">
        <li><a href="<?=Url::to(['search?search_input='.$_GET['search_input'].'&sort='.((isset($_GET['sort']) && $_GET['sort'] == '-zh') ?
                    'zh' : '-zh')])?>"
               class="sort-btn <?php if ($zhCur) echo 'cur';?>">综合
                <!--<span class="d-icon-down
                    <?php if($zhUp){ ?>d-icon-up<?php } ?>
                    <?php if($zhDown) { ?>d-icon-rdown<?php } ?>">
                </span>--></a></li>
        <li><a href="<?=Url::to(['search?search_input='.$_GET['search_input'].'&sort='.((isset($_GET['sort']) && $_GET['sort'] == '-sales') ?
                    'sales' : '-sales')])?>"
               class="sort-btn <?php if ($salesCur) echo 'cur';?>">销量
                <span class="d-icon-down
                    <?php if($salesUp){ ?>d-icon-up<?php } ?>
                    <?php if($salesDown) { ?>d-icon-rdown<?php } ?>">
                </span></a></li>
        <li><a href="<?=Url::to(['search?search_input='.$_GET['search_input'].'&sort='.((isset($_GET['sort']) && $_GET['sort'] == '-market_price') ?
                    'market_price' : '-market_price')])?>"
               class="sort-btn <?php if ($priceCur) echo 'cur';?>">价格
                <span class="d-icon-down
                    <?php if($priceUp){ ?>d-icon-up<?php } ?>
                    <?php if($priceDown) { ?>d-icon-rdown<?php } ?>">
                </span></a></li>
    </ul>
</div>
<!-- 排序 end-->
<!-- 汽车专卖列表 begin-->
<div class="d-featured-sale">
    <div class="d-feau-sale-box">
        <?php
        if($dataProvider) {
            echo ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'item'],
                'itemView' => '_item-search-index',
                'layout' => '{items}{pager}',
                'emptyText' => '没有找到商品',
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
                    'triggerOffset' => 1,
                    'negativeMargin' => 20,
                ]
            ]);
        }
        ?>
    </div>
</div>
<!-- 汽车专卖列表 end-->

<!--JS begin-->
<script type="text/javascript">

    //轮播
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

</script>
<!--JS end-->
