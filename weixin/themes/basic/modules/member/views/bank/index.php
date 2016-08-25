<?php
use yii\helpers\Url;
use common\enum\BankEnum;
use common\service\ToolService;
// use yii\grid\GridView;
// use common\service\AdminService;
// use common\enum\PermissionEnum;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\member\MemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app_member', 'bank_list');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-index-bottom my-bcard-top">
	<a href="<?=Url::toRoute('create') ?>" class="list">
		<img src="/img/my-bcard_1.png">
		<span class="ml">添加银行卡</span>
		<span class="jt dm-list-right my-bcard-right"></span>
	</a>
</div>
<!--my-index-top 个人中心头部 (背景)E-->

<!-- my-bcard-bottom 银行卡列表下部内容 S-->
<div class="my-bcard-bottom">


<?php if(count($list)>0){foreach ($list as $key => $model) {?>
<div class="my-bcard-list">
	<div class="my-bcard-info">
		<!-- <img src="/img/my-bcard_2.png"> -->
		<div class="txt ">
			<div><b><?=$model->name?></b><span class="r-fc <?php if($model->is_default==0) echo 'hidden'; ?>">[默认银行卡]</span></div>
			<div class="f16 mt10"><?= ToolService::setEncrypt($model->no) ; ?></div>
		</div>
		<span class=""><?=$model->username?></span>
	</div>
	<div class=" clearfix">
		<div class="fr"><a href="<?=Url::toRoute(['delete','id'=>$model->id]) ?>" class="my-order-btn delete"><?=yii::t('app_member','unBind')?></a></div>
		<div class="fr"><a href="<?=Url::toRoute(['setdefault','id'=>$model->id]) ?>" class="my-order-btn setDefault <?php if($model->is_default==1){echo 'hidden';} ?>"><?=yii::t('app_member','default')?></a></div>
	</div>		
</div>
<?php }}?>

</div>		
<script type="text/javascript">
	$(function(){
		$('.clearfix').on('click','.setDefault',function(event){
			var $this=$(this);
			var url=$this.attr('href');
			$.getJSON(url, '', function(data){
				if(data == true){
					var text="<?= Yii::t('app_member', 'default') ?>";

					$this.addClass('hidden')
					.parents('.clearfix').siblings('div').find('span.r-fc').removeClass('hidden')
					.parents('.my-bcard-list').siblings('.my-bcard-list').each(function(){
						var it=$(this);
						it.children('.my-bcard-info').find('span.r-fc').addClass('hidden');
						it.children('.clearfix').find('a.setDefault').removeClass('hidden');
					});
					// .parents('.wddz-content')
					// .siblings('.wddz-content').each(function(index, el) {
					// 	$(this).find('div.mt5').find('span').text('');
					// });
				}else{
					$.MsgBox.Alert("",data.msg);
				}
			});
			event.preventDefault();
		});



		$('.clearfix').on('click','.delete',function(event){
			var $this=$(this);
			var url=$this.attr('href');
			$.getJSON(url, '', function(data){
				if(data == true){
					$this.parents('div.my-bcard-list').hide();
				}else{
					$.MsgBox.Alert("",data.msg);
				}
			});
			event.preventDefault();
		});
	});
</script>