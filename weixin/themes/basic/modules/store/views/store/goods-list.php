<?php
use yii\widgets\ListView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\enum\GoodsEnum;
use common\models\Category;
use common\models\Brand;
use kop\y2sp\ScrollPager;
?>
<!-- Commodity list 商品列表-->
<div class="d-commodity-list">
	<!-- tab 切换-->
	<div class="d-tab-background">
		<div class="d-tab-title">
			<a class="d-mod-nav-item " href="<?= Url::to(['/store/store/store-view?id='.$store_id]); ?>">
				店铺首页
			</a>
			<a class="d-mod-nav-item" href="<?= Url::to(['/store/store/store-category?id='.$store_id]); ?>">
                商品分类
			</a>
		</div>
	</div>
	<!-- 排序选项-->
	<div class="d-tab-background stick-tittle">
		<ul class="d-product-main">
			<li>
				<a href="<?=Url::to(['goods-list?sort='.((isset($_GET['sort']) && $_GET['sort'] == '-sales') ? 'sales' : '-sales').'&store_id='.$store_id.'&price='.$price.'&brand_id='.$brand_id.'&category_id='.$category_id])?>" class="sort-btn <?= $font_color_sales ?>">
					<i>销量</i>
					<span class="d-icon-down <?= $sort_sales ?>">
					</span>
				</a>
			</li>
			<li>
				<a href="<?=Url::to(['goods-list?sort='.((isset($_GET['sort']) && $_GET['sort'] == '-market_price') ? 'market_price' : '-market_price').'&store_id='.$store_id.'&price='.$price.'&brand_id='.$brand_id.'&category_id='.$category_id])?>" class="sort-btn <?= $font_color_price ?>">
					价格
					<span class="d-icon-down <?= $sort_price ?>">
					</span>
				</a>
			</li>
			<li>
				<a href="<?=Url::to(['goods-list?sort='.((isset($_GET['sort']) && $_GET['sort'] == '-shelves_time') ? 'shelves_time' : '-shelves_time').'&store_id='.$store_id.'&price='.$price.'&brand_id='.$brand_id.'&category_id='.$category_id])?>" class="sort-btn <?= $font_color_shelves_time ?>">
					上架时间
					<span class="d-icon-down <?= $sort_shelves_time ?>" >
					</span>
				</a>
			</li>
			<li>
				<a href="#screening" class="d-icon-arrow choice toolbar" id="open-sb" onclick="cancel_val()">
					筛选
				</a>
			</li>
		</ul>
	</div>
	<!-- 产品-->
	<div class="d-daming-fine d-index-dis clearfix">
		<section class="d-fine-prlist">
			<div class="d-fine-prbox">
				<ul>
					<?php
					if($dataProvider) {
						echo ListView::widget([
							'dataProvider' => $dataProvider,
							'itemOptions' => ['class' => 'item'],
							'itemView' => '_item_goods_list',
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
				</ul>
			</div>
		</section>
	</div>
</div>
</div>
</div>
<!--回到顶部--S-->
<div style="display: none;" class="back-top" id="toolBackTop">
	<a title="返回顶部" onclick="window.scrollTo(0,0);return false;" href="#top" class="back-top backtop">
	</a>
</div>
<!--回到顶部--E-->
<!--  筛选滑动切入 S-->
<div class="wrapper" >
	<div class="body_bg">
	</div>
	<section class="sidebar" style="">
		<nav>
			<div class="list" >
				<div class="d-sidebar-container d-sidebar-container_p">
					<div class="d-sidebar-main">
						<?php $form = ActiveForm::begin([
						'method' => 'post',
						'id'=>'searchForm',
						'action'=>'goods-list'
						]); ?>

						<ul>
							<?= $form->field($searchModel, 'store_id',['options'=>['class'=>'control-group span8'] ])->label(false)->hiddenInput($options = []); ?>
						</ul>

						<ul>
							<?= $form->field($searchModel, 'price',['options'=>['class'=>'control-group span8'] ])->label(false)->hiddenInput($options = []); ?>
						</ul>

						<ul>
							<?= $form->field($searchModel, 'brand_id',['options'=>['class'=>'control-group span8'] ])->label(false)->hiddenInput($options = []); ?>
						</ul>

						<ul>
							<?= $form->field($searchModel, 'category_id',['options'=>['class'=>'control-group span8'] ])->label(false)->hiddenInput($options = []); ?>
						</ul>

						<div class="d-sidebar-main">
							<div class="sidebar-header">
								<a class="d-btn d-btn-reset" href="javascript:;">
									重置
								</a>
								<!--<div class="dm-stit">中盾自营<i class="d-tick dm-tick"></i></div>-->
								<a class="d-btn d-btn-sure" id="js_post_form" href="#" >
									确定
								</a>
							</div>
						</div>
						<?php ActiveForm::end(); ?>
					</div>
					<div class="dm-occupy-div" >
					</div>
					<ul id="gd">
						<!--价格筛选-->
						<li class="opened">
							<a href="#" class="swrap-title">
								<i class="d-arrow">
								</i>
								<span class="d-sidebar-title">价格</span>
							</a>
							<div class="d-tab-con d-brand" id="price">
								<ul>
									<?php
									$arr_goods_enum = GoodsEnum::getPriceDrop();
									if ($arr_goods_enum) {
										foreach ($arr_goods_enum as $key => $value) {
											echo "<li>";
											echo '<i class="d-tick" value="' . $key . '" onclick="checked(this)"></i>';
											echo "<span>";
											echo $value;
											echo "</span>";
											echo "</li>";
										}
									}
									?>
								</ul>
							</div>
						</li>
						<!--品牌筛选-->
						<li class="">
							<a href="#" class="swrap-title">
								<i class="d-arrow">
								</i>
								<span class="d-sidebar-title">品牌</span>
							</a>
							<div class="d-tab-con d-brand" id="brand">
								<ul>
									<?php
									$arr_brand = yii\helpers\ArrayHelper::map(Brand::findAll(['status'=>1]),'brand_id', 'name');
									if($arr_brand) {
									foreach ($arr_brand as $key => $value) {
									echo "<li>";
									echo '<i class="d-tick" value="' . $key . '" onclick="checked(this)"></i>';
									echo "<span>";
									echo $value;
									echo "</span>";
									echo "</li>";
									}
									}
									?>
								</ul>
							</div>
						</li>
						<!--商品筛选-->
						<li class="">
							<a href="#" class="swrap-title">
								<i class="d-arrow">
								</i>
								<span class="d-sidebar-title">商品分类</span>
							</a>
							<div class="d-tab-con d-brand" id="category">
								<ul>
									<?php
									$arr_category = yii\helpers\ArrayHelper::map(Category::getCategoryList(), 'category_id', 'name');
									if ($arr_category) {
										foreach ($arr_category as $key => $value) {
											echo "<li>";
											echo '<i class="d-tick" value="' . $key . '" onclick="checked(this)"></i>';
											echo "<span>";
											echo $value;
											echo "</span>";
											echo "</li>";
										}
									}
									?>
								</ul>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</nav>
	</section>
</div>
<!--  筛选滑动切入 E-->
<!-- 按钮选中js动作 -->
<script type="text/javascript">/*单选  S*/
$(".d-brand>ul>li").click(function() {
	$(this).children().addClass('d-checked');
	$(this).siblings().children().removeClass('d-checked');
	//筛选 选中 提交href赋值
	var type = $(this).parent().parent().attr('id');
	if (type == 'price') {
		$("#goodslistsearch-price").val($(this).children("i.d-tick").attr("value"));
	} else if (type == 'brand') {
		$("#goodslistsearch-brand_id").val($(this).children("i.d-tick").attr("value"));
	} else if (type == 'category') {
		$("#goodslistsearch-category_id").val($(this).children("i.d-tick").attr("value"));
	}
});
$('.dm-tick').click(function() {
	$(this).toggleClass('d-checked');
});
$('.d-btn-reset').click(function() {
	$('.d-tick').removeClass('d-checked');
});
//再次筛选，刷新筛选数据
function cancel_val() {
		$("#goodslistsearch-price").val("");
		$("#goodslistsearch-brand_id").val("");
		$("#goodslistsearch-category_id").val("");
	}
	//筛选表单提交
$(document).ready(function() {
	//form表单 js提交
	$("#js_post_form").click(function() {
		$("#searchForm").submit();
	});
});
$("#search_input").click(function() {
	window.location = '/home/home/search';
});
$(window).each(function() {
	if ($(this).width() > 640) {
		if ($(this).width() < 800) {
			$('.d-fine-jplist .d-fine-wrapp img').css('height', '3.5rem');
		}else{
			$('.d-fine-jplist .d-fine-wrapp img').css('height', '4.1rem');
		}
	} else {
		$('.d-fine-jplist .d-fine-wrapp img').css('height', '2.90rem');
	}
});

var topm = $('.stick-tittle').offset().top-50;
	$(window).scroll(function() {
		if ($(window).scrollTop() >= topm) {
			$(".stick-tittle").addClass("dm-fixedtop");
		} else {
			$(".stick-tittle").removeClass("dm-fixedtop");
		}
	});
</script>
