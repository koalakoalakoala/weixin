<?php 
	use yii\helpers\Url;
?>
<body onload="setHeight();" onresize=" setHeight()">
		<div class="index-content">
			<!--首页背景控制-->
			<div class="index-set">

				<!-- Commodity list 商品列表-->
				<div class="d-commodity-list d-commodity-listp" id="primary">
					<!-- tab 切换-->
					<div class="d-tab-background stick-tittle">
						<div class="d-tab-title">
							<a class="d-mod-nav-item" href="<?=Url::to(['description?id='.$_GET['id']])?>">图文详情</a>
							<a class="d-mod-nav-item" href="<?=Url::to(['attr?id='.$_GET['id']])?>">商品参数</a>
							<!--<a class="d-mod-nav-item d-mod-nav-cur" href="<?/*=Url::to(['comments?id='.$_GET['id']])*/?>">商品评价</a>-->
						</div>
					</div>


					<!-- 产品评价-->
					<div class="estimate" >
						<div class="detail-evaluate verentcom">
							<div class="detailpj">
								<div class="detaierleft">
									<dl>
										<dt>好评度</dt>
										<dd>100<small>%</small></dd>
									</dl>
								</div>
							</div>
							<div class="appraise">
								<div class="detail-boxth">
									<p class="d-assess detairpadding">好评(99%)</p>
									<dl>
										<dd class="der-jindu detairmargin">
											<p style="width: 80%" class="detail-bgred"></p>
										</dd>
									</dl>
									<p class="d-assess">中评(75%)</p>
									<dl>
										<dd class="der-jindu">
											<p style="width:45%" class="detail-bgred"></p>
										</dd>
									</dl>
									<p class="d-assess">差评(0%)</p>
									<dl>
										<dd class="der-jindu">
											<p style="width:30%" class="detail-bgred"></p>
										</dd>
									</dl>

								</div>
							</div>
						</div>
						<div class="d-wrappert">
							<div class="detial-tab my-order-menu">
								<a class="d-deital-boxone cur all-btn" href="#">全部</a>
								<a class="d-deital-boxone click-btn1" href="#">好评<span class="pjsl">(152)</span></a>
								<a class="d-deital-boxone click-btn2" href="#">中评<span class="pjsl">(152)</span></a>
								<a class="d-deital-boxone click-btn3" href="#">差评<span class="pjsl">(152)</span></a>
							</div>
							<div class="d-deitairmain phone-shopbox show-box1">
									<p class="d-detail-pic">
										<img src="img/detimg.png">
									</p>
									<div class="d-detailpj">
										<div class="d-infont">
											<span>我叫韩梅梅</span>
											<span class="d-judge">好评</span>
										</div>
										<p class="detairlist">棒棒哒，小孩子很喜欢，非常愉快的一次购物，性价比很高，推荐！很满意很满意！</p>
										<p class="detail-times">2015-12-23&nbsp;&nbsp;&nbsp;&nbsp;12:05:13</p>
									</div>
							</div>
							<div class="d-deitairmain phone-shopbox show-box2">
								<p class="d-detail-pic">
									<img src="img/detimg.png">
								</p>
								<div class="d-detailpj">
									<div class="d-infont">
										<span>我叫韩梅梅</span>
										<span class="d-judge">中评</span>
									</div>
									<p class="detairlist">棒棒哒，小孩子很喜欢，非常愉快的一次购物，性价比很高，推荐！很满意很满意！</p>
									<p class="detail-times">2015-12-23&nbsp;&nbsp;&nbsp;&nbsp;12:05:13</p>
								</div>
							</div>
							<div class="d-deitairmain phone-shopbox show-box3">
								<p class="d-detail-pic">
									<img src="img/detimg.png">
								</p>
								<div class="d-detailpj">
									<div class="d-infont">
										<span>我叫韩梅梅</span>
										<span class="d-judge">差评</span>
									</div>
									<p class="detairlist">棒棒哒，小孩子很喜欢，非常愉快的一次购物，性价比很高，推荐！很满意很满意！</p>
									<p class="detail-times">2015-12-23&nbsp;&nbsp;&nbsp;&nbsp;12:05:13</p>
								</div>
							</div>
							<div style="display: block;" class="click-loading">
								<a href="javascript:void(0);">继续向下加载更多</a>
							</div>

						</div>

					</div>


				</div>


			</div>

		</div>
<script type="text/javascript" language="javascript">
    
    //获取分类左边的高度而得右边高度相同
    function setHeight()
			{   
				var max_height = document.documentElement.clientHeight;
				var primary = document.getElementById('primary');
				
				primary.style.minHeight = max_height+"px";
				primary.style.maxHeight = max_height+"px";
			}
			
	var topm = $('.stick-tittle').offset().top-30;
	$(window).scroll(function() {
		if ($(window).scrollTop() >= topm) {
			$(".stick-tittle").addClass("dm-fixedtop");
		} else {
			$(".stick-tittle").removeClass("dm-fixedtop");
		}
	});
			
</script>
</body>