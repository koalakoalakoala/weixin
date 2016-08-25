<?php
use yii\widgets\ListView;
use kop\y2sp\ScrollPager;
use yii\helpers\Url;
$this->title=$activity->name
?>

<div class="index-content">
	<!--首页背景控制-->
	<div class="index-set">

		<!-- Subject hall details 活动馆详情-->
		<!-- banner-->
		<div class="addWrap">
            <div class="swipe" id="mySwipe">
                <div class="swipe-wrap">
                    <?php if($banners){ foreach($banners as $k => $v){ ?>
                        <div><a href="<?=strstr($v->linkurl,"http") ? $v->linkurl : "http://".$v->linkurl ?>"><img class="img-responsive" src="<?=Yii::$app->params['img_domain'].$v->imgurl?>" /></a></div>
                    <?php } } ?>
                </div>
            </div>

            <ul id="position" class="positionp">
                <?php for($i=1;$i<=count($banners);$i++){ ?>
                    <li <?php if($i ==1){ ?> class="cur" <?php } ?> ></li>
                <?php } ?>
            </ul>
        </div>

		<!--         Theme pavilion 活动馆-->
		<!--         Recommended shop 推荐店铺-->
		<!--        <div class="d-mod-tit d-mod-shop-top"><h2 class="d-pav-tit">推荐店铺</h2></div>-->
		<!--        <div class="d-rec-shop d-index-dis d-index-lr">-->
		<!--            <div class="swiper-container">-->
		<!--                <div class="swiper-wrapper d-rec-box">-->
		<!--                    <div class="swiper-slide d-mod-slider-item">-->
		<!--                        <a href="#">-->
		<!--                            <div class="d-shop-info">-->
		<!--                                <img class="d-shop-logo" src="/img/shop1.jpg">-->
		<!--                                <div class="d-shop-name">苏泊尔厨具专营店</div>-->
		<!--                                <div class="d-rec-name-credit-box">-->
		<!--                                    <div class="d-shop-credit">店铺信誉值：<i>1200</i></div>-->
		<!--                                    <div class="d-shop-star">店铺等级：<i class="d-rec-star star1"></i></div>-->
		<!--                                </div>-->
		<!--                            </div>-->
		<!--                            <img class="d-shop-img2" src="/img/pr1.jpg">-->
		<!--                            <img class="d-shop-img2" src="/img/pr2.jpg">-->
		<!--                        </a>-->
		<!--                    </div>-->
		<!--                    <div class="swiper-slide d-mod-slider-item">-->
		<!--                        <a href="#">-->
		<!--                            <div class="d-shop-info">-->
		<!--                                <img class="d-shop-logo" src="img/shop1.jpg">-->
		<!--                                <div class="d-shop-name">苏泊尔厨具专营店</div>-->
		<!--                                <div class="d-rec-name-credit-box">-->
		<!--                                    <div class="d-shop-credit">店铺信誉值：<i>1200</i></div>-->
		<!--                                    <div class="d-shop-star">店铺等级：<i class="d-rec-star star1"></i></div>-->
		<!--                                </div>-->
		<!--                            </div>-->
		<!--                            <img class="d-shop-img2" src="/img/pr1.jpg">-->
		<!--                            <img class="d-shop-img2" src="/img/pr2.jpg">-->
		<!--                        </a>-->
		<!--                    </div>-->
		<!--                    <div class="swiper-slide d-mod-slider-item">-->
		<!--                        <a href="#">-->
		<!--                            <div class="d-shop-info">-->
		<!--                                <img class="d-shop-logo" src="img/shop1.jpg">-->
		<!--                                <div class="d-shop-name">苏泊尔厨具专营店</div>-->
		<!--                                <div class="d-rec-name-credit-box">-->
		<!--                                    <div class="d-shop-credit">店铺信誉值：<i>1200</i></div>-->
		<!--                                    <div class="d-shop-star">店铺等级：<i class="d-rec-star star1"></i></div>-->
		<!--                                </div>-->
		<!--                            </div>-->
		<!--                            <img class="d-shop-img2" src="/img/pr1.jpg">-->
		<!--                            <img class="d-shop-img2" src="/img/pr2.jpg">-->
		<!--                        </a>-->
		<!--                    </div>-->
		<!--                    <div class="swiper-slide d-mod-slider-item">-->
		<!--                        <a href="#">-->
		<!--                            <div class="d-shop-info">-->
		<!--                                <img class="d-shop-logo" src="img/shop1.jpg">-->
		<!--                                <div class="d-shop-name">苏泊尔厨具专营店</div>-->
		<!--                                <div class="d-rec-name-credit-box">-->
		<!--                                    <div class="d-shop-credit">店铺信誉值：<i>1200</i></div>-->
		<!--                                    <div class="d-shop-star">店铺等级：<i class="d-rec-star star1"></i></div>-->
		<!--                                </div>-->
		<!--                            </div>-->
		<!--                            <img class="d-shop-img2" src="/img/pr1.jpg">-->
		<!--                            <img class="d-shop-img2" src="/img/pr2.jpg">-->
		<!--                        </a>-->
		<!--                    </div>-->
		<!--                </div>-->
		<!--            </div>-->
		<!-- Add Pagination -->
		<!--            <div class="swiper-pagination"></div>-->
		<!--        </div>-->
		<div class="zd-tabler">
		<?php
		if ($activity_category) { ?>
			<a href="<?=Url::to(['view', 'id'=>$_GET['id']])?>" class="zdactiver
				<?php if (!isset($_GET['activity_category_id'])){?> zdactivers<?php } ?>">全部</a>
			<?php foreach($activity_category as $k => $v) { ?>
			<a href="<?=Url::to(['view', 'id'=>$_GET['id'], 'activity_category_id'=>$v['id']])?>" class="zdactiver <?php if (isset($_GET['activity_category_id']) && $_GET['activity_category_id'] == $v['id']){ ?>zdactivers<?php } ?>">
			<?=$v['name']?>
			</a>

		<?php } } ?>
		</div>

		<!-- Everyone is buying 大家都在买-->
		<div class="d-mod-tit">
			<h2 class="d-pav-tit">大家都在买</h2>
		</div>

			<!-- 滑动标题-->
<!--		<div class="d-detail-title">-->
<!--			<div class="d-multipl-navigator">-->
<!--				<a class="d-multipl-main" href="#">手机<span class="d-red-line"><i></i></span></a>-->
<!--				<a class="d-multipl-main" href="#">手机<span class="d-red-line"><i></i></span></a>-->
<!--				<a class="d-multipl-main" href="#">手机<span class="d-red-line"><i></i></span></a>-->
<!--				<a class="d-multipl-main" href="#">手机<span class="d-red-line"><i></i></span></a>-->
<!--				<a class="d-multipl-main" href="#">手机<span class="d-red-line"><i></i></span></a>-->
<!--				<a class="d-multipl-main" href="#">手机<span class="d-red-line"><i></i></span></a>-->
<!--				<a class="d-multipl-main" href="#">手机<span class="d-red-line"><i></i></span></a>-->
<!--				<a class="d-multipl-main" href="#">手机<span class="d-red-line"><i></i></span></a>-->
<!--			</div>-->
<!--		</div>-->

		<div class="d-daming-fine d-index-dis clearfix">
			<section class="d-fine-prlist">
				<div class="d-fine-prbox">
					<ul>
						<?php
						echo ListView::widget([
							'dataProvider' => $dataProvider,
							'itemOptions' => ['class' => 'item'],
							'itemView' => '_item_view',
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
</div>
<!--回到顶部--S-->
<div style="display: none;" class="back-top" id="toolBackTop">
	<a title="返回顶部" onclick="window.scrollTo(0,0);return false;"
	   href="#top" class="back-top backtop">
	</a>
</div>

<!--回到顶部--E-->
<!--首页JS-->
<script type="text/javascript">
	//轮播
	var bullets = document.getElementById
	('position').getElementsByTagName('li');
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
//	//点击按钮
//	$(".zdactiver").click(function(){
//		var e=$(this)
//		e.parent().children('a').removeClass('zdactivers')
//		e.addClass('zdactivers')
//
//	});

</script>





