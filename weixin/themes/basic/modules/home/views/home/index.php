<?php
use common\enum\ActivityPageEnum;
use yii\helpers\Url;
use common\service\SpecialCategoryService as SpcService;

$this->title = Yii::t('app_member', '中盾商城');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php //var_dump($banner); ?>
<!-- banner-->
<div class="addWrap">
	<div class="swipe" id="mySwipe">
		<div class="swipe-wrap">
		      <?php foreach ($banner as $value): ?>
			     <div>
			         <a href="<?=$value['linkurl']?>">
			             <img class="img-responsive" src="<?=Yii::$app->params['img_domain'] . $value['imgurl']?>" title="<?=$value['name']?>"/>
			         </a>
			     </div>
			  <?php endforeach;?>
		</div>
	</div>

	<ul id="position" class="positionp">
		<?php
$number_banner = count($banner);
if ($number_banner) {
	echo '<li class="cur"></li>';
	for ($i = 2; $i <= $number_banner; $i++) {
		echo '<li></li>';
	}
}
?>
	</ul>
</div>

<!-- 菜单-->
<div class="menu">
 	<ul class="menu-list">
 		<li>
 			<a href="<?=Url::to(['/goods/activity/m-coupon?activity_id=' . ActivityPageEnum::MCOUPON])?>" class="menu-btn menu-btn3">
 				<span class="menu-icon"></span>
 				<span class="menu-txt">米券专区</span>
 			</a>
 		</li>
 		<li>
 			<a href="<?=Url::to(['/goods/category/integral?activity_id=' . ActivityPageEnum::INTEGRAL])?>" class="menu-btn menu-btn5">
 				<span class="menu-icon"></span>
 				<span class="menu-txt">积分专区</span>
 			</a>
 		</li>
  		<li>
   			<a href="<?=Url::to(['/goods/category/exchange?activity_id=' . ActivityPageEnum::EXCHANGE])?>" class="menu-btn menu-btn1">
   				<span class="menu-icon"></span>
   				<span class="menu-txt">兑换专区</span>
   			</a>
   		</li>
 		<li>
 			<a href="<?=Url::to(['/goods/car'])?>" class="menu-btn menu-btn4">
 				<span class="menu-icon"></span>
 				<span class="menu-txt">时尚汽车</span>
 			</a>
 		</li>

 	</ul>

 </div>

<!-- Theme pavilion 主题馆-->
<div class="d-mod-tit">
	<h2 class="d-pav-tit">主题馆
		<?php if ($themeCount > 6) {?>
			<a style="float:right;" href="/goods/activity/ztg-list">
            
            
            </a>
		<?php }?>
	</h2>
</div>
<div class="d-pavilion d-index-dis">
	<div class="d-pav-list">
		<ul>
		      <?php foreach ($themePavilion as $theme): ?>
        			<li>
        				<div class="d-pav-box d-pav-boxp">
        					<a href="/goods/activity/ztgxq?id=<?php echo $theme['id']; ?>">

        						<div class="d-pav-picp">

        							<img class="" src="<?=Yii::$app->params['img_domain'] . $theme['ico'];?>">
        						</div>
        						<div class="d-pav-theme1 d-pav-theme1p">
        							<!--<span class="d-pav-theme-tit">--><?php echo $theme['name']; ?><!--</span>-->
        							<!--<span class="d-pav-theme-des"><?php echo $theme['remark']; ?></span>-->
        						</div>
        					</a>
        				</div>
        			</li>
        	   <?php endforeach;?>

		</ul>
	</div>
</div>
<!--<div class="d-mod-tit">
	<h2 class="d-pav-tit">活动
		<?php if ($activityCount > 3) {?>
			<a style="float:right;" href="/goods/activity/index">更多>></a>
		<?php }?>
	</h2>
</div>-->
<!--<div class="d-pavilion d-index-dis">
	<div class="d-pav-lists">
		<ul>
		      <?php foreach ($activity as $act): ?>
        			<li>
        				<div class="d-featu-box">
							<a href="<?=Url::to(['/goods/activity/view?id=' . $act->id])?>">
								<div class="d-pic-box">
									<img src="<?=Yii::$app->params['img_domain'] . $act->ico?>">
									<div class="d-pic-infor">
										<p><?=$act->name?></p>
										<span><?=date("Y-m-d", $act->start_time)?></span>
									</div>
								</div>
								<div class="d-article-disc">
									<p><?=$act->remark?></p>
								</div>
							</a>
						</div>
        			</li>
        	   <?php endforeach;?>
		</ul>
	</div>
</div>
-->
<!-- Daming fine 中盾精品-->
<!--
<div class="d-mod-tit">
	<h2 class="d-pav-tit">中盾精品<a style="float:right;" href="<?=Url::to(['goods?type=new'])?>">更多>></a></h2>
</div>
<div class="d-daming-fine d-index-dis d-index-disp">
	<section class="d-fine-prlist clearfix">
		<div class="d-fine-prbox ">
			<ul class="clearfix">

				<?php if (empty($fine)) {?>
				    <span>暂无数据</span>
				<?php } else {?>
				    <?php foreach ($fine as $value) {?>
	    				 <li>
	    				    <a class="d-fine-jplist" href="/goods/goods/view?id=<?=$value['goods_id']?>">
	                    		<div class="d-fine-wrapp">
	                    			<img class="d-fine-timg" src="<?=Yii::$app->params['img_domain'] . $value['goodsgallery']['image']?>">
	                    		</div>
	                    		<div class="d-fine-info">
	                    			<div class="d-fine-name"><h3><?=$value['name']?></h3></div>
	                    			<div class="d-fine-price">包邮价:￥<?=$value['defaultSku'] ? $value['defaultSku']['market_price'] + $value['freight'] : $value->market_price + $value['freight']?></div>
	                    		</div>
	                    	</a>
	                     </li>
                    <?php }?>
				<?php }?>

			</ul>
			<input type="hidden" id="page" value="1">
		</div>
	</section>
</div>
-->

<!-- Daming fine 中盾精品-->
<div class="d-mod-tit">
	<h2 class="d-pav-tit">热卖推荐<a style="float:right; padding-right:10px" href="javascript:void(0);" id="others">换一批&nbsp;&gt;</a></h2>
</div>
<div class="d-daming-fine d-index-dis d-index-disp">
	<section class="d-fine-prlist clearfix">
		<div class="d-fine-prbox ">
			<ul class="clearfix" id="hotData">

				<?php if (empty($hot)) {?>
				    <span>暂无数据</span>
				<?php } else {?>
				    <?php foreach ($hot as $value) {
							$is_car = $is_integral = $is_coupon = false;
							$goods_id = $value['goods_id'];
							$is_car = SpcService::isCar($goods_id);
							if (!$is_car) {
								$is_integral = SpcService::isIntegral($goods_id);
								if (!$is_integral) {
									$is_coupon = SpcService::isCoupon($goods_id);
								}
							}
						?>
	    				 <li>
	    				    <a class="d-fine-jplist" href="
	    				    <?php if ($is_car) { ?>
	    				    	/goods/car/view?id=<?=$value['goods_id']?>
	    				    <?php } else { ?>
	    				    	/goods/goods/view?id=<?=$value['goods_id']?>
	    				    <?php } ?>
	    				    ">
	                    		<div class="d-fine-wrapp">
	                    			<img class="d-fine-timg" src="<?=Yii::$app->params['img_domain'] . $value['goodsgallery']['image']?>">
	                    		</div>
	                    		<div class="d-fine-info">
	                    			<div class="d-fine-name"><h3><?= $value['name'] ?></h3></div>
	                    			<div class="d-fine-price">
										<?php if ($is_car) { ?>
											<!--订金:-->￥<?=$value['defaultSku'] ? round($value['defaultSku']['market_price'], 2) : round($value->market_price, 2) ?>
										<?php } else { ?>
											<!--包邮价:-->￥<?=$value['defaultSku'] ? $value['defaultSku']['market_price'] + $value['freight'] : $value->market_price + $value['freight'] ?>
										<?php } ?>
									</div>
	                    		</div>
								<?php if ($is_car) { ?>
									<span class="zd-prolabel zd-prolabel3"><img src="/img/deposit.png"></span>
								<?php } else if ($is_integral) { ?>
									<span class="zd-prolabel zd-prolabel1"><img src="/img/integral.png"></span>
								<?php } else if ($is_coupon) { ?>
									<span class="zd-prolabel zd-prolabel2"><img src="/img/deduction.png"></span>
								<?php } ?>

	                    	</a>
	                     </li>
                    <?php }?>
				<?php }?>

			</ul>
			<input type="hidden" id="page" value="1">
		</div>
	</section>
</div>


<!-- Daming fine 中盾精品-->
<!--<div class="d-mod-tit">
	<h2 class="d-pav-tit">最新上架
	<a style="float:right;" href="<?=Url::to(['goods?type=new'])?>">更多>></a>
	</h2>
</div>
<div class="d-daming-fine d-index-dis d-index-disp">
	<section class="d-fine-prlist clearfix">
		<div class="d-fine-prbox ">
			<ul class="clearfix">

				<?php if (empty($new)) {?>
				    <span>暂无数据</span>
				<?php } else {?>
				    <?php foreach ($new as $value) {?>
	    				 <li>
	    				    <a class="d-fine-jplist" href="/goods/goods/view?id=<?=$value['goods_id']?>">
	                    		<div class="d-fine-wrapp">
	                    			<img class="d-fine-timg" src="<?=Yii::$app->params['img_domain'] . $value['goodsgallery']['image']?>">
	                    		</div>
	                    		<div class="d-fine-info">
	                    			<div class="d-fine-name"><h3><?=$value['name']?></h3></div>
	                    			<div class="d-fine-price">包邮价:￥<?=$value['defaultSku'] ? $value['defaultSku']['market_price'] + $value['freight'] : $value->market_price + $value['freight']?></div>
	                    		</div>
	                    	</a>
	                     </li>
                    <?php }?>
				<?php }?>

			</ul>
			<input type="hidden" id="page" value="1">
		</div>
	</section>
</div>-->

<div class="zd-bah">
	<a href="http://www.miitbeian.gov.cn/state/outPortal/loginPortal.action;jsessionid=n3H7XV9YbJVW8rzlhvw6n9n4bj1V5LcHQGwZhZ4rln1TjDl2W9hd!-337628580">备案号 粤ICP备16029233号-1</a>
</div>

<input class="img_domain" type="hidden" value="<?php echo Yii::$app->params['img_domain']; ?>">
<!--回到顶部--S-->
  <div style="display: none;" class="back-top" id="toolBackTop">
       <a title="返回顶部" onclick="window.scrollTo(0,0);return false;" href="#top" class="back-top backtop">
       </a>
 </div>
 <!--回到顶部--E-->
<!--首页JS-->
		<script type="text/javascript">
		    $(function(){

				$('#others').click(function(){
					$.ajax({
						type:"get",
						url:"<?=Url::to(['others'])?>",
						success:function(data){
							$("#hotData").html(data);
						}
					});
				});

		    	$('#more_goods').click(function(){
			    	var page=$("#page").val();
			        var img_domain = $("input.img_domain").val();
		        	$.ajax({
		    	        type:"get",
		    	        url:"/home/home/get-goods",
		    	        data:{page:page},
		    	        success:function(data){

		    	        	var data = JSON.parse(data);

		    	            if(data.success==1){
		    	            	var html='';
			    	            for(var i=0;i<data['data'].length;i++){

			    	                html+='<li>';
	                    		    html+='	        <a class="d-fine-jplist" href="/goods/goods/view?id=' + data['data'][i]['goods_id'] + '">';
	                    		    html+='	    		<div class="d-fine-wrapp">';
	                    		    if(data['data'][i]['goodsgallery']==null){
	                    		    	html+='	    			<img class="d-fine-timg" src="#">';
	                    		    }else{
	                    		    	html+='	    			<img class="d-fine-timg" src="'+ img_domain +data['data'][i]['goodsgallery']['image']+'">';
	                    		    }

	                    		    html+='	    		</div>';
	                    		    html+='    	    		<div class="d-fine-info">';
	                    		    html+='    	    			<div class="d-fine-name"><h3>'+data['data'][i]['name']+'</h3></div>';
			    	        		html+='  	    			<div class="d-fine-price">包邮价:￥'+data['data'][i]['sku'][0]['market_price']+data['data'][i]['freight']+'</div>';
			    	        		html+='  	    		</div>';
			    	        		html+='   	    	</a>';
			    	        		html+='    	    </li>';
			    	            }


			    	            $("#page").val(parseInt(page)+1);
			    	            $('.d-fine-prbox ul').append(html);

			    	            if(data.more_goods==0){
			    	            	$(".div_more_goods").html('<a class="btn dm-homeld text-center">没有更多的商品了</a>');
			    	            }
		    	            }
		    	        }
		        	});
			    });

		        $('.d-mod-tit-refresh').click(function(){
			        var img_domain = $("input.img_domain").val();
		        	$.ajax({
		    	        type:"get",
		    	        url:"/home/home/rand-goods",
		    	        data:{},
		    	        success:function(data){

		    	            data=eval('('+data+')');
		    	            //$.MsgBox.Alert("",data.success);
		    	            if(data.success==1){
		    	            	var html='';

			    	            for(var i=0;i<data['data'].length;i++){
			    	                html+='<li>';
	                    		    html+='	        <a class="d-fine-jplist" href="/goods/goods/view?id=' + data['data'][i]['goods_id'] + '">';
	                    		    html+='	    		<div class="d-fine-wrapp">';
	                    		    html+='	    			<img class="d-fine-timg" src="'+ img_domain +data['data'][i]['goodsgallery']['image']+'">';
	                    		    html+='	    		</div>';
	                    		    html+='    	    		<div class="d-fine-info">';
	                    		    html+='    	    			<div class="d-fine-name"><h3>'+data['data'][i]['name']+'</h3></div>';
			    	        		html+='  	    			<div class="d-fine-price">包邮价:￥'+data['data'][i]['sku'][0]['market_price']+'</div>';
			    	        		html+='  	    		</div>';
			    	        		html+='   	    	</a>';
			    	        		html+='    	    </li>';
			    	            }

			    	            $('.d-fine-prbox ul').html(html);
			    	            $(".div_more_goods").html('');
		    	            }
		    	        }
		        	});
			    });
			});

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

             /*当滚到底部时火箭消失 S*/
            $(function(){
            	var settop=$('.zd-bottom').offset().top;
            	var wh=$(window).height();
        		var zh=$('.zd-bottom').height();
        		var between=settop+wh;

            	$(window).scroll(function(){
            		if($(window).scrollTop() >= between){
            			$('.backtop').css('bottom','200px');
            		}else{
            			$('.backtop').css('bottom','50px');
            		}
            	});
            })
            /*当滚到底部时火箭消失 E*/
		</script>




















