<?php
use yii\widgets\ListView;
use yii\helpers\Url;
use common\enum\GoodsEnum;
use yii\helpers\Html;
use kop\y2sp\ScrollPager;
?>

<div class="index-content">
    <!--首页背景控制-->
    <div class="index-set">

        <!-- Commodity list 商品列表-->
        <div class="d-commodity-list">

            <!-- tab 切换-->
            <div class="d-tab-background">
                <div class="d-tab-title">
                    <a class="d-mod-nav-item" href="<?= Url::to(['/goods/goods/category-index?category_id='.$category_id]); ?>">商品</a>
                    <a class="d-mod-nav-item  d-mod-nav-cur" href="#">店铺</a>
                </div>
            </div>

            <!-- 排序选项-->
            <div class="d-tab-background stick-tittle">
                <ul class="d-product-main">
                    <!--li><a href="<?= Url::to(['index?sort='.((isset($_GET['sort']) && $_GET['sort'] == '-credit_value') ? 'credit_value' : '-credit_value')]); ?>" class="sort-btn <?= $font_color_credit_value?>">信誉<span class="d-icon-down <?= $sort_credit_value ?>"></span></a></li-->
                    <li><a href="<?= Url::to(['index?sort='.((isset($_GET['sort']) && $_GET['sort'] == '-sales') ? 'sales' : '-sales').'&category_id='.$category_id]); ?>" class="sort-btn <?= $font_color_sales?>">销量<span class="d-icon-down <?= $sort_sales ?>"></span></a></li>
                    <li><a href="#screening" class="d-icon-arrow choice toolbar" id="open-sb">筛选</a></li>
                </ul>
            </div>

            <!-- shop -->
            <div class="">
                <div class="d-shop-content">
                    <?php
                    if($dataProvider) {
                        echo ListView::widget([
                            'dataProvider' => $dataProvider,
                            'itemOptions' => ['class' => 'item'],
                            'itemView' => '_item_index',
                            'layout' => '{items}{pager}',
                            'emptyText' => '暂无店铺数据',
                            'pager' => [
                                'class' => ScrollPager::className(),
                                'enabledExtensions' => [
                                    ScrollPager::EXTENSION_TRIGGER,
                                    ScrollPager::EXTENSION_SPINNER,
                                    ScrollPager::EXTENSION_NONE_LEFT,
                                    ScrollPager::EXTENSION_PAGING,
                                ],
                                'triggerText' => '<a href="javascript:void(0)" class="dm-homeld text-center">继续向下加载更多</a>',
                                'triggerTemplate' => '<div class="col-md-12" style="text-align:
center; cursor: pointer;"><a class="btn-group-justified btn-xs button button-3d button-primary button-pill">{text}</a></div>',
                                'noneLeftText' => '<p class="text-center"></p>',
                                'triggerOffset' => 1,
                                'negativeMargin' => 10,
                            ]
                        ]);
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>
</div>
</div>
<div class="search-form">

    <!--  筛选滑动切入 S-->
    <div class="wrapper" >
        <section class="sidebar" style="">
            <nav>
                <div class="list" >
                    <div class="d-sidebar-container ">
                        <div class="d-sidebar-main">
                            <div class="sidebar-header">
                                <a class="d-btn d-btn-reset" href="/store/store/index" >重置</a>
                                <a class="d-btn d-btn-sure" id="determine_store" href="#" >确定</a>
                            </div>
                        </div>
                        <div class="dm-occupy-div" ></div>
                        <ul id="gd">
                        	   <li class="opened">
								  <a href="#" class="swrap-title">
									  <span class="d-sidebar-title">热门城市</span>
								  </a>
								  <div class="d-tab-con d-brand radio-click">
				 					  <ul>
                                          <div class="store-hot-city clearfix">
                                              <span class="city store-cur" >北京</span>
                                              <span class="city" >广州</span>
                                              <span class="city" >深圳</span>
                                              <span class="city" >上海</span>
                                              <span class="city" >天津</span>
                                              <span class="city" >成都</span>
                                              <span class="city" >大连</span>
                                              <span class="city" >青岛</span>
                                          </div>
									  </ul>
								  </div>
							  </li>
							  <li class="opened">
								  <a href="#" class="swrap-title">
									  <span class="d-sidebar-title">所在省区</span>
								  </a>
								  <div class="d-tab-con d-brand radio-click">
									  <ul>
                                          <?php
                                          if($models_province) {
                                              foreach ($models_province as $value)
                                              {
                                                  echo "<li>";
                                                  echo '<i class="d-tick" onclick="checked_province(this)"></i>';
                                                  echo '<span>';
                                                  echo $value->name;
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

</div>
 <!--回到顶部--S-->
  <div style="display: none;" class="back-top" id="toolBackTop"> 
       <a title="返回顶部" onclick="window.scrollTo(0,0);return false;" href="#top" class="back-top backtop"> 
       </a> 
 </div>
 <!--回到顶部--E-->
<!--  筛选滑动切入 E-->

<script type="text/javascript">
    /*单选  S*/

    //省份点击动作
    $(".radio-click>ul>li").click(function() {
        //在省份选择时，取消城市选中
        $(".city").removeClass('store-cur');

		$(this).children().addClass('d-checked');
		$(this).siblings().children().removeClass('d-checked');

        //在这儿进行搜索链接的省份赋值
        var val = $(this).children().text();
        $("#determine_store").attr("href", "/store/store/search-store?search_province="+val);
	});

    //城市点击动作
	$('.city').click(function(){
        //在城市选择时，取消省份选中
        $(".radio-click>ul>li").siblings().children().removeClass('d-checked');

		$('.city').removeClass('store-cur');
		$(this).addClass('store-cur');

        //在这儿进行搜索链接的城市赋值
        var val = $(".store-cur").text();

        if(val == '北京') {
            $("#determine_store").attr("href", "/store/store/search-store?search_city=52");
        } else if(val == '广州') {
            $("#determine_store").attr("href", "/store/store/search-store?search_city=76");
        } else if(val == '深圳') {
            $("#determine_store").attr("href", "/store/store/search-store?search_city=77");
        } else if(val == '上海') {
            $("#determine_store").attr("href", "/store/store/search-store?search_city=321");
        } else if(val == '天津') {
            $("#determine_store").attr("href", "/store/store/search-store?search_city=343");
        } else if(val == '成都') {
            $("#determine_store").attr("href", "/store/store/search-store?search_city=26");
        } else if(val == '大连') {
            $("#determine_store").attr("href", "/store/store/search-store?search_city=18");
        } else if(val == '青岛') {
            $("#determine_store").attr("href", "/store/store/search-store?search_city=22");
        }

	});
    /*单选  E*/
   
   var topm = $('.stick-tittle').offset().top-50;
	$(window).scroll(function() {
		if ($(window).scrollTop() >= topm) {
			$(".stick-tittle").addClass("dm-fixedtop");
		} else {
			$(".stick-tittle").removeClass("dm-fixedtop");
		}
	});
</script>




