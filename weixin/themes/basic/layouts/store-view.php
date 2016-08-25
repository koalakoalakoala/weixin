<?php
use weixin\assets\AppAsset;
use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta name="format-detection" content="telephone=no" /><!--禁止safari电话默认拨打-->
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
                <?php $isHome = $this->context->module->id == 'home' && $this->context->id == 'home' && $this->context->action->id == 'index' ? true : false;?>
                <?php if(!$isHome){ ?>
                <div class="d-mod"></div>
                <?php } ?>
                <div class="d-mod d-mod-menu-unfold <?php if(!$isHome){?> d-modp<?php } ?>">
                    <?php  if($isHome){ ?>
                        <a class="d-mod-logo" href="<?=Url::to(['/home/home'])?>"></a>
                    <?php }else{ ?>
                        <!-- <a class="d-mod-back" href="javascript:window.history.go(-1);"></a> -->
                    <?php } ?>
                    <!-- <div class="d-mod-input d-mod-input-wrapper">
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
                    </div> -->
                    <script type="text/javascript">
                        $(function(){
                            $(".d-mod-menu").click(function(){
                                $(".d-mod-menu-list").toggle(10);
                            });

                        });
                    </script>
                </div>
                <?= $content ?>
        </div>
    </div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
