<?php
use weixin\assets\AppAsset;
use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;
use common\service\OrderService;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="index-content">
            <!--首页背景控制-->
            <div class="index-set">
                <!-- top -->
                <div class="d-mod"></div>
                <div class="d-mod d-mod-menu-unfold d-modp">                   
                    <div class="d-mod-input d-mod-input-wrapper">

                        <a class="d-mod-search" href="<?= Url::to(['../../../home/home/search'])?>" style="width: 100%">
                            <input type="text" placeholder="世界那么大，我想去看看" style="line-height: normal;">
                        </a>
                    </div>
                    <a class="d-mod-menu" href="javascript:;"></a>
                    <div class="d-mod-menu-list" style="display: none;">
                        <a class="d-mod-menu-list-item d-mod-menu-list-item1" href="<?=Url::to(['/home/home'])?>">首页</a>
                        <a class="d-mod-menu-list-item d-mod-menu-list-item2" href="<?=Url::to(['/goods/category'])?>">分类</a>
                        <a class="d-mod-menu-list-item d-mod-menu-list-item3" href="<?=Url::to(['/order/cart'])?>">购物车</a>
                        <a class="d-mod-menu-list-item d-mod-menu-list-item4" href="<?=Url::to(['/member/member'])?>">我的</a>
                    </div>
                    <script type="text/javascript">
                        $(function(){
                            $(".d-mod-menu").click(function(){
                                $(".d-mod-menu-list").toggle(10);
                            });

                        });
                    </script>
                </div>
                <?php
                	$count = OrderService::getOrderCount(Yii::$app->user->id);
                ?>
				<div class="my-order-top">
					<ul class="my-order-menu my-order-menup">
						<li><a href="<?=Url::to(['index'])?>" class="<?php if($this->context->id == 'order' && $this->context->action->id == 'index'){ echo 'cur'; }?> all-btn"><span>全部订单</span></a></li>
						<li><a href="<?=Url::to(['wait-pay'])?>" class="<?php if($this->context->id == 'order' && $this->context->action->id == 'wait-pay'){ echo 'cur'; }?> click-btn1"><span>待付款<?=$count['wait_pay_count'] ? '<sup class="sup">'.$count['wait_pay_count'].'</sup>' : ''?></span></a></li>
						<li><a href="<?=Url::to(['wait-receive'])?>" class="<?php if($this->context->id == 'order' && $this->context->action->id == 'wait-receive'){ echo 'cur'; }?> click-btn2"><span >待收货<?=$count['wait_receive_count'] ? '<sup class="sup">'.$count['wait_receive_count'].'</sup>' : ''?></span></a></li>
						<li><a href="<?=Url::to(['wait-comment'])?>" class="<?php if($this->context->id == 'order' && $this->context->action->id == 'wait-comment'){ echo 'cur'; }?> click-btn3"><span >已完成<?=$count['wait_comment_count'] ? '<sup class="sup">'.$count['wait_comment_count'].'</sup>' : ''?></span></a></li>
					</ul>
				</div>

                <?= $content ?>
        </div>
    </div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
