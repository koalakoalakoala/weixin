<?php
use yii\helpers\Url;
use yii\widgets\ListView;
use kop\y2sp\ScrollPager;
$this->title="已完成订单";
?>

<div class="mod_container">
	<?php
    if($dataProvider) {
        echo ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'itemView' => '_item_wait_comment',
            'layout' => '{items}{pager}',
            'emptyText' => '<b>您还没有相关订单</b><span>可以去看看有哪些想买的</span><a href="'.Url::to(["/home/home/index"]).'">随便逛逛</a>',
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