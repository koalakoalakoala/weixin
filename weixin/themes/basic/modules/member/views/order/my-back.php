<?php
 use yii\helpers\Url;
 use yii\widgets\ListView;
 use kop\y2sp\ScrollPager;
 $this->title = "我的退货退款订单";
?>

<div class="mod_container">
	<?php
    if($dataProvider) {
        echo ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'itemView' => '_item_my_back',
            'layout' => '{items}{pager}',
            'emptyText' => '暂无此类订单',
            'pager' => [
                'class' => ScrollPager::className(),
                'enabledExtensions' => [
                    ScrollPager::EXTENSION_TRIGGER,
                    ScrollPager::EXTENSION_SPINNER,
                    ScrollPager::EXTENSION_NONE_LEFT,
                    ScrollPager::EXTENSION_PAGING,
                ],
                'triggerText' => '<a href="javascript:void(0)" class="dm-homeld text-center">继续向下加载更多</a>',
                'triggerTemplate' => '<div class="col-md-12" style="text-align: center; cursor: pointer;"><a class="btn-group-justified btn-xs button button-3d button-primary button-pill">{text}</a></div>',
                'noneLeftText' => '<p class="text-center"></p>',
                'triggerOffset' => 2,
                'negativeMargin' => 10,
            ]
        ]);
    }
    ?>
</div>