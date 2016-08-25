<?php use yii\helpers\Url;?>
<div class="index-content">
    <!--首页背景控制-->
    <div class="index-set">

        <!-- Commodity list 商品列表-->

        <!-- tab 切换 S-->
        <div class="d-tab-background">
            <div class="d-tab-title">
                <a class="d-mod-nav-item cur" href="#">收藏商品</a>
                <a class="d-mod-nav-item " href="#">收藏店铺</a>
            </div>
        </div>
        <!-- tab 切换 E-->
        <div class="home-tuan-lists collecte-list collect_goods_list ">
            <?php if($collect_goods){foreach($collect_goods as $k1 => $v1){   ?>
            <div class="dm-item item_good">
                <div class="cnt">
                    <?php if(($v1['is_shelves'] == 0) || ($v1['status'] != 1)){ ?>
                        <a href="javascript:void(0);" class="shoppr"><img class="pic" src="<?=$v1['image'];?>" alt=""></a>
                        <div class="shop-content collecte-content">
                            <div class="title"><a href="javascript:void(0);" class="in-tit"><?=$v1['name'];?></a><span style="color: #ccc">(该商品已下架)</span></div>
                    <?php }else{ ?>
                        <a href="<?=\yii\helpers\Url::to(['/goods/goods/view?id='.$v1['goods_id']]);?>" class="shoppr"><img class="pic" src="<?=$v1['image'];?>" alt=""></a>
                        <div class="shop-content collecte-content">
                            <div class="title"><a href="<?=\yii\helpers\Url::to(['/goods/goods/view?id='.$v1['goods_id']]);?>" class="in-tit"><?=$v1['name'];?></a></div>
                    <?php } ?>

                        <div class="price" style="padding-bottom:0px;"><span>¥<?=$v1['market_price'];?></span><a class="sc-btn fr" collect_id="<?=$v1['collect_id'];?>"  current_gid="<?=$v1['goods_id'];?>" href="javascript:void(0);">删除</a></div>
                    </div>
                </div>
            </div>
           <?php }}else{ ?>
                <div class="goshop-content">
                    <div class="goshop-content-img">
                        <img src="/img/goshopping.png">
                    </div>
                    <div class="goshop-content-txt">
                        <p class="f18">还没找到喜欢的宝贝吗？</p>
                        <p class="f14">快去挑选你的商品吧！<a href="<?=Url::to(['/home/home/index'])?>" class="r-fc">去逛逛</a></p>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="home-tuan-lists collecte-list collect_store_list" style="display: none;">
            <?php if($collect_store){foreach($collect_store as $k2 => $v2){  ?>
            <div class="dm-item item_store">
                <div class="cnt">
                    <a href="<?=\yii\helpers\Url::to('/store/store/view?id='.$v2['store_id']);?>" class="shoppr"><img class="pic" src="<?=Yii::$app->params['img_domain'].$v2['store_logo'];?>" alt=""></a>
                    <div class="shop-content collecte-content">
                        <div class="title" style="margin-top:15px;"><a href="<?=\yii\helpers\Url::to('/store/store/view?id='.$v2['store_id']);?>" class="in-tit"><?=$v2['store_name'];?></a></div>
                        <!--div class="shop-des" >店铺级别：<?=$v2['level_name'];?><a class="sc-btn fr" collect_id="<?=$v2['collect_id'];?>" current_sid="<?=$v2['store_id'];?>"  href="javascript:void(0);">删除</a></div-->
                        <div class="shop-des" ><a class="sc-btn fr" collect_id="<?=$v2['collect_id'];?>" current_sid="<?=$v2['store_id'];?>"  href="javascript:void(0);">删除</a></div>
                    </div>
                </div>
            </div>
            <?php }}else{ ?>
                <div class="goshop-content">
                    <div class="goshop-content-img">
                        <img src="/img/goshopping.png">
                    </div>
                    <div class="goshop-content-txt">
                        <p class="f18">还没找到喜欢的店铺吗？</p>
                        <p class="f14">好店快到碗里来！<a href="<?=Url::to(['/store/store/index'])?>" class="r-fc">去逛逛</a></p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){

        //定义索引：tab页签li与内容div的索引一一对应
        var index;

        //定义定时器对象
        var timeId = null;

        //tab页签li与内容div的jQuery对象变量
        var $lis = $(".d-mod-nav-item");
        var $divs = $(".collecte-list");

        //为每个tab页签li绑定鼠标滑过事件
        $lis.on("click", function(){

            //保存当前li对象
            $that = $(this);

            //如果存在准备执行的定时器，立刻清除，只有当前停留时间大于500毫秒才执行
            if(timeId){
                clearTimeout(timeId);
                timeId = null;
            }

            //延迟半秒执行
            timeId = setTimeout(function(){

                //获得当前tab页签的索引
                index = $that.index();

                //设置当前tab页签高亮显示
                $that.addClass("cur").siblings().removeClass("cur");

                //设置对应的内容div显示
                $divs.eq(index).show().siblings('.collecte-list').hide();

            },500);

        });


        //个人中心里的删除收藏

        //点击删除商品
        $('.collect_goods_list .sc-btn').click(function(){
			var  _this = $(this);
            $.MsgBox.Confirm("",'确定要删除吗？',function(){
                var url = "<?=\yii\helpers\Url::to('/member/member/del-collect');?>";
                var collect_id = _this.attr('collect_id');
                var _csrf = '<?=Yii::$app->request->csrfToken?>';
                var type = 1;
                var data = {
                    'collect_id':collect_id,
                    'type':type,
                    '_csrf':_csrf
                };
                $.post(url, data, function (res) {
                    var resutl = eval('(' + res + ')');
                    if (parseInt(resutl.code) == 200) {
                        _this.parents('.dm-item').remove();
                        console.log(resutl.msg);
                    } else {
                        console.log(resutl.msg);
                    }
                });
            });
        });


        //点击删除收藏商店
        $('.collect_store_list .sc-btn').click(function(){
			var  _this = $(this);
            $.MsgBox.Confirm("",'确定要删除吗？',function(){
                var url = "<?=\yii\helpers\Url::to('/member/member/del-collect');?>";
                var collect_id = _this.attr('collect_id');
                var _csrf = '<?=Yii::$app->request->csrfToken?>';
                var type = 0;
                var data = {
                    'collect_id':collect_id,
                    'type':type,
                    '_csrf':_csrf
                };
                $.post(url, data, function (res) {
                    var result = eval('(' + res + ')');
                    if (parseInt(result.code) == 200) {
                        _this.parents('.item_store').remove();
                        console.log(result.msg);
                    } else {
                        console.log(result.msg);
                    }
                });
            });
        });
    });
</script>