<?php
use kop\y2sp\ScrollPager;
use yii\widgets\ListView;
$this->title = '热卖';
?>

<div class="index-content">
    <!--首页背景控制-->
    <div class="index-set">
        <div class="d-daming-fine d-index-dis clearfix">
            <section class="d-fine-prlist">
                <div class="d-fine-prbox">
                    <ul>
                        <?php
echo ListView::widget([
	'dataProvider' => $dataProvider,
	'itemOptions' => ['class' => 'item'],
	'itemView' => '_item_goods',
	'layout' => '{items}{pager}',
	'emptyText' => '暂无活动数据',
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
	],
]);
?>
                    </ul>
                </div>
            </section>
        </div>

    </div>
</div>

<!--回到顶部--S-->
<div style="display: none;" class="back-top" id="toolBackTop">
    <a title="返回顶部" onclick="window.scrollTo(0,0);return false;"
       href="#top" class="back-top backtop">
    </a>
</div>