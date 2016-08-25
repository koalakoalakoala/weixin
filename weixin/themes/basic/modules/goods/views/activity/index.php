<?php
use yii\widgets\ListView;
use kop\y2sp\ScrollPager;

$this->title = '活动';
?>


<div class="index-content">
	<!--首页背景控制-->
	<div class="index-set">

		<!-- Featured sale 精选特卖列表-->
		<div class="d-featured-sale">
			<div class="d-feau-sale-box">
				<?php
				echo ListView::widget([
					'dataProvider' => $dataProvider,
					'itemOptions' => ['class' => 'item'],
					'itemView' => '_item_index',
					'layout' =>'{items}{pager}',
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
	                    'triggerTemplate'=>'<div class="col-md-12" style="text-align: center; cursor: pointer;"><a class="btn-group-justified btn-xs button button-3d button-primary button-pill">{text}</a></div>',
	                    'noneLeftText'=>'<p class="text-center">没有更多数据了</p>',
	                    'triggerOffset'=>2,
	                    'negativeMargin'=>10,
                    ]
				]);
				?>
			</div>
		</div>


	</div>
</div>
<!--回到顶部--S-->
  <div style="display: none;" class="back-top" id="toolBackTop"> 
       <a title="返回顶部" onclick="window.scrollTo(0,0);return false;" href="#top" class="back-top backtop"> 
       </a> 
 </div>
 <!--回到顶部--E-->