<?php 
use yii\helpers\Url;
?>
<!-- search start -->
<div class="d-modp"></div>
<div class="d-mod d-mod-menu-unfold d-modp">
    <a class="d-mod-back" href="javascript:history.go(-1);"></a>
    <div class="d-mod-input d-mod-input-wrapper">
        <a class="d-mod-search" href="<?= Url::to(['../../../home/home/search'])?>" style="width: 100%">
            <input type="text" placeholder="世界那么大，我想去看看11" style="line-height: normal;">
        </a>
    </div>
    <a class="d-mod-menu" href="javascript:;"></a>
    <div class="d-mod-menu-list" style="display: none;">
        <a class="d-mod-menu-list-item d-mod-menu-list-item1" href="index.html">首页</a>
        <a class="d-mod-menu-list-item d-mod-menu-list-item2" href="fl-sort.html">分类</a>
        <a class="d-mod-menu-list-item d-mod-menu-list-item3" href="shoppingcart.html">购物车</a>
        <a class="d-mod-menu-list-item d-mod-menu-list-item4" href="javascript:;">我的</a>
    </div>
</div>

<script type="text/javascript">
	$(function(){
		$(".d-mod-menu").click(function(){
	        $(".d-mod-menu-list").toggle(10);
	    });

    });
</script>
<!-- search end -->