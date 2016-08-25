<?php
use yii\widgets\ListView;
use yii\helpers\Url;
use kop\y2sp\ScrollPager;
?>

<?php $this->title = '店铺首页'; ?>

<div class="index-content">
    <!--首页背景控制-->
    <div class="index-set">

        <!-- Subject hall details 主题馆详情-->
        <!-- banner-->
        <div class="addWrap">
            <div class="swipe" id="mySwipe">
                <div class="swipe-wrap">
                    <?php
                    foreach($store_banners as $store_banner) {
                         echo '<div><a href="javascript:;"><img class="img-responsive" src= " '.Yii::$app->params['img_domain'].$store_banner['imgurl'].'" /></a></div>';
                     }
                    ?>
                </div>
            </div>
            <ul id="position" class="positionp">
                <?php
                $number_banner = count($store_banners);
                if($number_banner){
                    echo '<li class="cur"></li>';
                    for($i=2; $i<=$number_banner; $i++){
                        echo '<li></li>';
                    }
                }
                ?>
            </ul>
        </div>

        <!-- Store information shop-->
        <div>
            <div class="d-prifno">
                <div class="fn-wrap d-shopborder">
                    <div class="wrap-title">
                        <div class="d-shop-unit-inner d-shopwrapper">
                            <p class="d-shop-cover d-shopstore">
                                <img src="<?= Yii::$app->params['img_domain'].$model->store_logo; ?>"/>
                            </p>
                            <div class="d-shop-detail">
                                <p class="d-shop-title"><?php echo $model->store_name; ?></p>
                                <div class="d-shop-rate">
                                    <!--span>店铺信誉值：<?php echo $model->credit_value;?></span-->
                                    <!--span class="d-shop-stars">
                                        店铺等级：
                                        <i class="d-rec-star star<?php
                                        if($model->level){
                                            if($model->level->name == '普通会员')
                                                echo '0';
                                            else if($model->level->name == '一星店铺')
                                                echo '1';
                                            else if($model->level->name == '二星店铺')
                                                echo '2';
                                            else if($model->level->name == '三星店铺')
                                                echo '3';
                                            else if($model->level->name == '四星店铺')
                                                echo '4';
                                            else if($model->level->name == '五星店铺')
                                                echo '5';
                                            else if($model->level->name == '六星店铺')
                                                echo '6';
                                            else
                                                echo '0';
                                        }
                                        ?>"></i>
                                    </span-->
                                </div>
                                <div class="d-shop-rate">
                                    <span>联系电话：<?php echo $model->p_phone;?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-tab-background">
                    <div class="d-tab-title">
                        <a class="d-mod-nav-item" href="<?=Url::to(['goods-list?store_id='.$model->id]);?>">全部商品<span class="d-deatalinfo">(<?= $store_goods_count ?>)</span></a>
                        <a class="d-mod-nav-item" href="<?= Url::to(['store-category?id='.$model->id]); ?>"><i class="d-btnshop"></i>商品分类</a>
                    </div>
                </div>

            </div>
        </div>

        <!-- Selling goods 热销商品-->
        <div class="d-mod-tit d-mod-shop-top">
            <h2 class="d-pav-tit">热销商品</h2>
        </div>

        <div class="d-daming-fine d-index-dis clearfix">
            <section class="d-fine-prlist">
                <div class="d-fine-prbox">
                    <ul>
                        <?php
                        echo ListView::widget([
                            'dataProvider' => $dataProvider2,
                            'itemOptions' => ['class' => 'item'],
                            'itemView' => '_item_store_view',
                            'layout' =>'{items}{pager}',
                            'emptyText' => '暂无商品',
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

        <!-- Latest shelves 最新上架-->
        <div class="d-mod-tit">
            <h2 class="d-pav-tit">最新上架</h2>
        </div>
        <div class="d-daming-fine d-index-dis clearfix">
            <section class="d-fine-prlist">
                <div class="d-fine-prbox">
                    <ul>
                        <?php
                            echo ListView::widget([
                                'dataProvider' => $dataProvider1,
                                'itemOptions' => ['class' => 'item'],
                                'itemView' => '_item_store_view',
                                'layout' => '{items}{pager}',
                                'emptyText' => '暂无商品',
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
                                ]
                            ]);
                        ?>
                    </ul>
                </div>
            </section>
        </div>

        <!-- Latest shelves 本店精品-->
        <div class="d-mod-tit">
            <h2 class="d-pav-tit">本店精品</h2>
        </div>
        <div class="d-daming-fine d-index-dis clearfix">
            <section class="d-fine-prlist">
                <div class="d-fine-prbox">
                    <ul>
                        <?php
                            echo ListView::widget([
                                'dataProvider' => $dataProvider3,
                                'itemOptions' => ['class' => 'item'],
                                'itemView' => '_item_view',
                                'layout' => '{items}{pager}',
                                'emptyText' => '暂无商品',
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
                                ]
                            ]);
                        ?>
                    </ul>
                </div>
            </section>
        </div>

    </div>
</div>


<!--首页JS-->
<script type="text/javascript">

    //轮播
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

    //推荐店铺
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        slidesPerView: 1,
        paginationClickable: true,
        spaceBetween: 30,
        loop: true
    });

</script>




