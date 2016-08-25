<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>汽车专区</title>
        <link rel="stylesheet" href="css/comm.css">
        <link rel="stylesheet" href="css/css2.css">
        <link rel="stylesheet" href="css/wglobal.css">
        <link rel="stylesheet" href="css/swiper.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="apple-mobile-web-app-capable" content="yes"/><!--隐藏safari导航栏及工具栏-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <script type="text/javascript" src="js/websrcipt.js" ></script>
        <script type="text/javascript" src="js/hhSwipe.js" ></script>
        <script type="text/javascript" src="js/swiper.min.js" ></script>

    </head>
    <body>

        <div class="index-content">
            <!--首页背景控制-->
            <div class="index-set">
               
                <!-- banner begin-->
                <div class="addWrap">
                    <div class="swipe" id="mySwipe">
                        <div class="swipe-wrap">
                            <div><a href="javascript:;"><img class="img-responsive" src="/img/banner1.png"/></a></div>
                            <div><a href="javascript:;"><img class="img-responsive" src="/img/banner2.png" /></a></div>
                            <div><a href="javascript:;"><img class="img-responsive" src="/img/banner3.png"/></a></div>
                        </div>
                    </div>

                    <ul id="position">
                        <li class="cur"></li>
                        <li></li>
                        <li></li>
                    </ul>
                </div>
                <!-- banner end-->
                <!-- 排序 begin-->
                <div class="d-tab-background stick-tittle">
                    <ul class="d-product-main">
                        <li><a href="#" class="sort-btn">综合<span class="d-icon-down"></span></a></li>
                        <li><a href="#" class="sort-btn">销量<span class="d-icon-down"></span></a></li>
                        <li><a href="#" class="sort-btn">价格<span class="d-icon-down"></span></a></li>
                    </ul>
                </div>
                <!-- 排序 end-->
                <!-- 汽车专卖列表 begin-->
                <div class="d-featured-sale">
                    <div class="d-feau-sale-box">
                        <div class="d-featu-box">

                                <div class="d-pic-box">
                                    <a href="#"><img src="/img/jximg2.jpg"></a>
                                    <div class="d-pic-infor z-intitlers">
                                        <p>广汽三菱 精选ASX 2013款</p>
                                    </div>
                                </div>
                                <div class="d-article-disc">
                                    <div class="z-info-titles">
                                        <div class="z-title-prices">
                                            <p>经销指导价：9.50万-15.21万</p>
                                            <p>订金：<span class="r-fc">￥4500.00</span></p>
                                        </div>
                                        <div class="z-btn-buy z-buy-gobuyer"><a href="#">立即购买</a></div>
                                    </div>
                                </div>
                        </div>

                        <div class="d-featu-box">

                            <div class="d-pic-box">
                                <a href="#"><img src="/img/jximg2.jpg"></a>
                                <div class="d-pic-infor z-intitlers">
                                    <p>广汽三菱 精选ASX 2013款</p>
                                </div>
                            </div>
                            <div class="d-article-disc">
                                <div class="z-info-titles">
                                    <div class="z-title-prices">
                                        <p>经销指导价：9.50万-15.21万</p>
                                        <p>订金：<span class="r-fc">￥4500.00</span></p>
                                    </div>
                                    <div class="z-btn-buy z-buy-gobuyer"><a href="#">立即购买</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="d-featu-box">

                            <div class="d-pic-box">
                                <a href="#"><img src="/img/jximg2.jpg"></a>
                                <div class="d-pic-infor z-intitlers">
                                    <p>广汽三菱 精选ASX 2013款</p>
                                </div>
                            </div>
                            <div class="d-article-disc">
                                <div class="z-info-titles">
                                    <div class="z-title-prices">
                                        <p>经销指导价：9.50万-15.21万</p>
                                        <p>订金：<span class="r-fc">￥4500.00</span></p>
                                    </div>
                                    <div class="z-btn-buy z-buy-gobuyer"><a href="#">立即购买</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="display: block;" class="click-loading">
                        <a href="javascript:void(0);">继续向下加载更多</a>
                    </div>
                </div>
                <!-- 汽车专卖列表 end-->




            </div>
        </div>

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
            
         var topm = $('.stick-tittle').offset().top;
		    $(window).scroll(function() {
		        if ($(window).scrollTop() >= topm) {
		            $(".stick-tittle").addClass("dm-fixedtop");
		        } else {
		            $(".stick-tittle").removeClass("dm-fixedtop");
		        }
		    });
        </script>
        <!--JS end-->
    </body>
</html>




