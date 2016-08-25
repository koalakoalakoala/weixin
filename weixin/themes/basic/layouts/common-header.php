<?php
use yii\helpers\Url;
?>

<?php
$isRoot = false;
$headerSpecial = false;
$headerCar = false;
$headerIntegral = false;
$headerMcoupon = false;
$headerExchange = false;
$carSearch = false;
$integralSearch = false;
$mcouponSearch = false;
$exchangeSearch = false;
if (isset($this->context->module)) {
	//Root pages.
	if (
		$this->context->module->id == 'home' &&
		$this->context->id == 'home' &&
		$this->context->action->id == 'index'
	) {
		$isRoot = true;
		$headerSpecial = true;
	} else if (
		$this->context->module->id == 'goods' &&
		$this->context->id == 'category' &&
		$this->context->action->id == 'index'
	) {
		$isRoot = true;
	} else if (
        $this->context->module->id == 'goods' &&
        $this->context->id == 'category' &&
        $this->context->action->id == 'integral'
    ) {
        $isRoot = true;
        $headerSpecial = true;
    } else if (
        $this->context->module->id == 'goods' &&
        $this->context->id == 'category' &&
        $this->context->action->id == 'exchange'
    ) {
        $isRoot = true;
        $headerSpecial = true;
    } else if (
		$this->context->module->id == 'goods' &&
		$this->context->id == 'activity' &&
		$this->context->action->id == 'm-coupon'
	) {
		$isRoot = true;
		$headerSpecial = true;
	} else if (
		$this->context->module->id == 'goods' &&
		$this->context->id == 'goods' &&
		$this->context->action->id == 'category-index'
	) {
		$isRoot = true;
		$headerSpecial = true;
	} else if (
		$this->context->module->id == 'order' &&
		$this->context->id == 'cart' &&
		$this->context->action->id == 'index'
	) {
		$isRoot = true;
	} else if (
		$this->context->module->id == 'member' &&
		$this->context->id == 'member' &&
		$this->context->action->id == 'index'
	) {
		$isRoot = true;
	}

	//Special pages.
	if ($this->context->module->id == 'goods' &&
		$this->context->id == 'car' &&
		$this->context->action->id == 'index') {
		$headerSpecial = true;
		$headerCar = true;
		$carSearch = true;
	} else if ($this->context->module->id == 'goods' &&
		$this->context->id == 'car' &&
		$this->context->action->id == 'search') {
		$headerSpecial = true;
		$headerCar = true;
		$carSearch = true;
	}

	//积分专区
	if ($this->context->module->id == 'goods' &&
		$this->context->id == 'category' &&
		$this->context->action->id == 'integral') {
		$headerSpecial = true;
		$headerIntegral = true;
        $integralSearch = true;
	}

	//米券专区
	if ($this->context->module->id == 'goods' &&
		$this->context->id == 'activity' &&
		$this->context->action->id == 'm-coupon') {
		$headerSpecial = true;
		$headerMcoupon = true;
        $mcouponSearch = true;
	}

    //兑换专区
    if ($this->context->module->id == 'goods' &&
        $this->context->id == 'category' &&
        $this->context->action->id == 'exchange') {
        $headerSpecial = true;
        $headerExchange = true;
        $exchangeSearch = true;
    }



}?>

<?php
	if ($headerSpecial) {
		if ($headerCar) {
?>
	<!-- 车类头部 -->
	<div class="d-mod d-mod-menu-unfold">
		<a class="d-mod-back" href="javascript:;" onclick="history.go(-1)"></a>
		<div class="d-mod-input d-mod-inputpp d-mod-input-wrapper">
			<a class="d-mod-search" href="<?=$carSearch ? Url::to(['/goods/car/search']) : Url::to(['/home/home/search'])?>" style="width: 100%">
				<input type="text" placeholder="世界那么大，我想去看看" style="line-height: normal;">
			</a>
		</div>
		<!--<a class="d-mod-menu" href="javascript:;"></a>
		<div class="d-mod-menu-list" style="display: none;">
			<a class="d-mod-menu-list-item d-mod-menu-list-item1" href="index.html">首页</a>
			<a class="d-mod-menu-list-item d-mod-menu-list-item2" href="fl-sort.html">分类</a>
			<a class="d-mod-menu-list-item d-mod-menu-list-item3" href="javascript:;">购物车</a>
			<a class="d-mod-menu-list-item d-mod-menu-list-item4" href="javascript:;">我的</a>
		</div>-->
	</div>
<?php } elseif ($headerMcoupon) { ?>
    <div class="d-mod d-mod-menu-unfold">
        <a class="d-mod-back" href="javascript:;" onclick="history.go(-1)"></a>
        <div class="d-mod-input d-mod-inputpp d-mod-input-wrapper">
            <a class="d-mod-search" href="<?=$mcouponSearch ? Url::to(['/goods/activity/search']) : Url::to(['/home/home/search'])?>" style="width: 100%">
                <input type="text" placeholder="世界那么大，我想去看看" style="line-height: normal;">
            </a>
        </div>
    </div>
<?php } elseif ($headerIntegral) { ?>
    <div class="d-mod d-mod-menu-unfold">
        <a class="d-mod-back" href="javascript:;" onclick="history.go(-1)"></a>
        <div class="d-mod-input d-mod-inputpp d-mod-input-wrapper">
            <a class="d-mod-search" href="<?=$integralSearch ? Url::to(['/goods/category/search']) : Url::to(['/home/home/search'])?>" style="width: 100%">
                <input type="text" placeholder="世界那么大，我想去看看" style="line-height: normal;">
            </a>
        </div>
    </div>
<?php } elseif ($headerExchange) { ?>
    <div class="d-mod d-mod-menu-unfold">
        <a class="d-mod-back" href="javascript:;" onclick="history.go(-1)"></a>
        <div class="d-mod-input d-mod-inputpp d-mod-input-wrapper">
            <a class="d-mod-search" href="<?=$exchangeSearch ? Url::to(['/goods/category/ex-search']) : Url::to(['/home/home/search'])?>" style="width: 100%">
                <input type="text" placeholder="世界那么大，我想去看看" style="line-height: normal;">
            </a>
        </div>
    </div>
<?php }else { ?>

<!-- 内页统一头部 -->
<div class="d-mod d-mod-menu-unfold">
    <!--<a class="d-mod-back" href="javascript:;"></a>-->
    <a class="d-mod-logo" href="/home/home"></a>
    <div class="d-mod-input d-mod-inputpp d-mod-input-wrapper">
        <a class="d-mod-search" href="<?=Url::to(['/home/home/search'])?>" style="width: 100%">
            <input type="text" placeholder="世界那么大，我想去看看" style="line-height: normal;">
        </a>
    </div>
	<?php if (!$isRoot) { ?>
		<a class="d-mod-menu" href="javascript:;"></a>
		<div class="d-mod-menu-list" style="display: none;">
			<a class="d-mod-menu-list-item d-mod-menu-list-item1" href="index.html">首页</a>
			<a class="d-mod-menu-list-item d-mod-menu-list-item2" href="fl-sort.html">分类</a>
			<a class="d-mod-menu-list-item d-mod-menu-list-item3" href="javascript:;">购物车</a>
			<a class="d-mod-menu-list-item d-mod-menu-list-item4" href="javascript:;">我的</a>
		</div>
	<?php } ?>
</div>
<?php } } else {
	?>

<div class="d-mod d-mod-menu-unfold clearfix">
    <a class="<?php if (!$isRoot) {?>d-mod-back <?php }?> zd-height" href="javascript:;" <?php if (!$isRoot) {?> onclick="history.go(-1)"<?php }?> ></a>
    <div class="zd-title"><span><?=$this->title?></span>
        <?php if (
		$this->context->id == 'order' &&
		$this->context->action->id != 'my-back' &&
		$this->context->action->id != 'detail' &&
		$this->context->action->id != 'return' &&
		isset($this->context->module) &&
		$this->context->module->id == 'member' &&
		!$isRoot
	) {?>
            <i></i>
            <ul>
                <li><a href="<?=Url::to(['index'])?>" >全部</a></li>
                <li><a href="<?=Url::to(['wait-pay'])?>" >待付款</a></li>
                <li><a href="<?=Url::to(['wait-receive'])?>" >待收货</a></li>
                <li><a href="<?=Url::to(['wait-comment'])?>" >已完成</a></li>
            </ul>
        <?php }?>
    </div>
</div>

<?php }?>


<?php if (
	$this->context->id == 'order' &&
	isset($this->context->module) &&
	$this->context->module->id == 'member'
) {?>
    <script type="text/javascript">
        $('.zd-title').click(function(){
            $('.zd-title ul').toggle();
            $(this).toggleClass('upred');
        });
    </script>
<?php }?>
