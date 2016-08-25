<?php
	use common\enum\ActivityPageEnum;
	use yii\helpers\Url;
?>

<!-- 引入微信分享所用的Js文件 -->
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

<div class="zdf-content" >
	<!-- banner S-->
	<div class="zd-banner">
		<img src="/img/zd-banner4.jpg"/>
	</div>
    <!-- banner E-->

	<!--团购专区 S-->
	<div class="zd-mod-tit">
		<h2 class="d-pav-tit">团购专区</h2>
		<a class="zd-more" href="<?=Url::to(['list','activity_id'=>ActivityPageEnum::TUANGOU]) ?>">更多</a>
	</div>
	<div class="d-daming-fine d-index-dis zd-index-dis">
		<section class="d-fine-prlist">
			<div class="zd-one-prbox">
				<ul class="clearfix zd-item-box">
					<?php
						if ($tuan) {
					 	foreach ($tuan as $tv) { ?>
					<li>
						<a class="d-fine-jplist zd-fine-jplist" href="<?=Url::to(['/goods/goods/view', 'id' => $tv->goods_id])?>">
							<div class="d-fine-wrapp zd-find-wrapp">
								<img class="d-fine-timg" src="<?= Yii::$app->params['img_domain'].$tv->goodsgallery->image ?>">
								<!-- <span class="zd-pro-discount">7.77折</span> -->
							</div>
							<div class="d-fine-info">
								<div class="d-fine-name"><h3><?=$tv->name?></h3></div>
								<div class="d-fine-price"> 团购价:<br/>￥<?=$tv['defaultSku'] ? $tv['defaultSku']['market_price'] + $tv['freight'] : $tv->market_price + $tv['freight'] ?></div>
								<del class="zd-one-price">市场价:<br/>￥<?=$tv['defaultSku'] ? $tv['defaultSku']['price'] + $tv['freight'] : $tv->price + $tv['freight'] ?></del>
							</div>
						</a>
					</li>
					<?php } } ?>
				</ul>
			</div>
		</section>
	</div>
	<!--团购专区 E-->
	<!--购物返利 S-->
	<div class="zd-mod-tit">
		<h2 class="d-pav-tit">购物返利</h2>
		<a class="zd-more" href="<?=Url::to(['list','activity_id'=>ActivityPageEnum::FANLI]) ?>">更多</a>
	</div>
	<div class="d-daming-fine d-index-dis zd-index-dis">
		<section class="d-fine-prlist">
			<div class="zd-one-prbox">
				<ul class="clearfix zd-item-box">
					<?php
						if ($fan) {
					 	foreach ($fan as $fv) { ?>
					<li>
						<a class="d-fine-jplist zd-fine-jplist" href="<?=Url::to(['/goods/goods/view', 'id' => $fv->goods_id])?>">
							<div class="d-fine-wrapp zd-find-wrapp">
								<img class="d-fine-timg" src="<?= Yii::$app->params['img_domain'].$fv->goodsgallery->image ?>">
							</div>
							<div class="d-fine-info">
								<div class="d-fine-name"><h3><?=$fv->name?></h3></div>
								<div class="d-fine-price"> 包邮价:<br/>￥<?=$fv['defaultSku'] ? $fv['defaultSku']['market_price'] + $fv['freight'] : $fv->market_price + $fv['freight'] ?></div>
								<div class="zd-one-price">分期返利<?=$fv->egd*100?>%</div>
							</div>
						</a>
					</li>
					<?php } } ?>
				</ul>
			</div>
		</section>
	</div>
	<!--购物返利 E-->
	<!--综合区 S-->
	<div class="zd-compre-box">
		<!--分享赚佣金 S-->
		<div class="zd-share-com">
			<h4 class="zd-share-txt">分享赚佣金</h4>
			<div class="zd-share-list"  onselectstart="return false;"  unselectable="on">
				<ul class="clearfix">
					<li class="zd-share-item1"><span class="zd-share-icon"></span><span class="zd-share-name">微信朋友圈</span></li>
					<li class="zd-share-item2"><span class="zd-share-icon"></span><span class="zd-share-name">微信好友</span></li>
					<li class="zd-share-item3"><span class="zd-share-icon"></span><span class="zd-share-name"></span>qq好友</li>
					<li class="zd-share-item4"><span class="zd-share-icon"></span><span class="zd-share-name"></span>复制</li>
				</ul>
			</div>
		</div>
		<!--分享赚佣金 E-->
		<!--菜单 S-->
		<ul class="compre-menu stick-tittle">
			<?php
				$i = 1;
				if ($acList) {
					foreach ($acList as $v_category) {
						echo "<li><a ".($i==1 ? "class=\"cur\"" : "").">".$v_category['category']."</a></li>";
						$i ++;
					}
				}
			?>
		</ul>
		<!--菜单 E-->

		<div>
			<!--分类模块 S-->
			<?php
				if ($acList){
				foreach ($acList as $v_goods) { ?>
			<div class="d-daming-fine d-index-dis zd-daming-fine">
				<section class="d-fine-prlist">
					<div class="d-fine-prbox">
						<ul class="clearfix" id="item_<?=$v_goods['category_id']?>">
							<?php if ($v_goods['goods']) {
								foreach ($v_goods['goods'] as $item_goods) { ?>
								<li>
									<a class="d-fine-jplist" href="<?=Url::to(['/goods/goods/view', 'id' => $item_goods->goods_id])?>">
										<div class="d-fine-wrapp">
											<img class="d-fine-timg" src="<?= Yii::$app->params['img_domain'].$item_goods->goodsgallery->image ?>">
										</div>
										<div class="d-fine-info">
											<div class="d-fine-name"><h3><?=$item_goods->name?></h3></div>
											<div class="d-fine-price">包邮价:￥<?=$item_goods['defaultSku'] ? $item_goods['defaultSku']['market_price'] + $item_goods['freight'] : $item_goods->market_price + $item_goods['freight'] ?></div>
										</div>
									</a>
								</li>
							<?php } } ?>
						</ul>
					</div>
				</section>
				<!--综合区 E-->
				<div style="display: block;" class="click-loading">
					<a href="javascript:void(0);" offset="0" id="<?=$v_goods['category_id']?>" onclick="loadMore(this)">继续向下加载更多</a>
				</div>
			</div>
			<?php }  } ?>
			<!--分类模块 E-->
		</div>
	</div>
</div>
<!--弹框S-->
	  <div class="bomb-box">
		  <div class="bomb-bg">
		  </div>
		  <div class="bomb-main">
		<img src="/img/share.png" />
		  </div>
	  </div>
	  <!--弹框E-->
<!--   <script type="text/javascript" src="/js/countdown.js"></script> -->
 <script type="text/javascript">
  /*标题固定在窗口 S*/
   /*    var topm = $('.stick-tittle').offset().top-50;
	$(window).scroll(function() {
		if ($(window).scrollTop() >= topm) {
			$(".stick-tittle").addClass("zd-fixedtop");
			$('.d-modp').hide();
		} else {
			$(".stick-tittle").removeClass("zd-fixedtop");
			$('.d-modp').show();
		}
	});*/
	/*标题固定在窗口 E*/

	/*倒计时 begin*/
	/*$(document).ready(function () {

		$("#countdown").countdown({
				date: "2016/4/3 00:00:00",
				format: "on"
			},
			function () {
				// callback function
			});

	});*/
	 /*倒计时 end*/

   /*弹窗 S*/
  $('.zd-share-list ul').click(function(){
       $('.bomb-box').show();
  });
   $('.bomb-box').click(function(){
         $('.bomb-box').hide();
    });
         var bt=$(".zd-share-com ").offset().top;
		 var  bh=$(".zd-share-com ").height();
		 var bc=bt-bh+20;
    $(window).scroll(function(){
		if($(".bomb-box").css("display")!="none"){//弹出窗口时不允许滚动条滚动
		     $(window).scrollTop(bc);
		    }
    })
    /*弹窗 E*/

    //微信分享
    var title = "<?=$shareData['title']?>";
    var imgUrl = "<?=$shareData['imgUrl']?>";
    var desc = "<?=$shareData['desc']?>"
    var link = "<?=$shareData['link']?>";

    wx.config({
        debug: false,//这里是开启测试，如果设置为true，则打开每个步骤，都会有提示，是否成功或者失败
        appId: "<?=isset($wxParam['appId']) ? $wxParam['appId'] : '' ?>",
        timestamp: "<?=isset($wxParam['timestamp']) ? $wxParam['timestamp'] : '' ?>",//这个一定要与上面的php代码里的一样。
        nonceStr: "<?=isset($wxParam['nonceStr']) ? $wxParam['nonceStr'] : '' ?>",//这个一定要与上面的php代码里的一样。
        signature: "<?=isset($wxParam['signature']) ? $wxParam['signature'] : '' ?>",
        jsApiList: [
          // 所有要调用的 API 都要加到这个列表中
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo'
        ]
    });

    wx.ready(function () {
        wx.onMenuShareTimeline({
            title: title, // 分享标题
            link: link, // 分享链接
            imgUrl: imgUrl, // 分享图标
            success: function () {
                // 用户确认分享后执行的回调函数
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
            }
        });
        wx.onMenuShareAppMessage({
            title: title, // 分享标题
            desc: desc, // 分享描述
            link: link, // 分享链接
            imgUrl: imgUrl, // 分享图标
            type: 'link', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function () {
                // 用户确认分享后执行的回调函数
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
            }
        });
        wx.onMenuShareQQ({
            title: title, // 分享标题
            desc: desc, // 分享描述
            link: link, // 分享链接
            imgUrl: imgUrl, // 分享图标
            success: function () {
               // 用户确认分享后执行的回调函数
            },
            cancel: function () {
               // 用户取消分享后执行的回调函数
            }
        });
        wx.onMenuShareWeibo({
            title: title, // 分享标题
            desc: desc, // 分享描述
            link: link, // 分享链接
            imgUrl: imgUrl, // 分享图标
            success: function () {
               // 用户确认分享后执行的回调函数
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
            }
        });
    });

    function loadMore(o)
    {
    	var id = o.id;
    	var url = "<?=Url::to(['more'])?>";
    	var offset = $(o).attr("offset");
    	var limit = 8;
    	var params = {
    		'activity_id' : id,
    		'_csrf' : '<?=Yii::$app->request->csrfToken?>',
    		'offset' : offset + limit,
    		'limit' : limit
    	};
        $.post(url, params,
        function(data){
                var res = eval('(' + data + ')');
                if(parseInt(res.code) == 200){
                    $(o).attr("offset", offset + limit);
                    $("#item_" + id) . append(res.html);
                }else if(parseInt(res.code) == 10000){
                    $("#" + id).html("已无更多数据");
                }
            }
        );
    }
 </script>
