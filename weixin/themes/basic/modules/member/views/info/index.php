<?php
use yii\helpers\Url;
use common\enum\StoreEnum;
use common\enum\MemberEnum;
use common\enum\LevelEnum;
// use yii\grid\GridView;
// use common\service\AdminService;
// use common\enum\PermissionEnum;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\member\MemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app_member', 'my_info');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-wraper-bg">
	<!--data-top 头部信息 S-->
	<div class="my-data-top bb">
	     <div class="my-data-list clearfix"><span class="txt"><span class="dm-icon my-data-icon my-data-icon1" ></span><?=$model->member_info->attributeLabels()['avatar']?></span>
	     	<?php if(!empty($model->member_info->avatar)){?>
	     		<img class="fr" src="<?=$model->member_info->avatar?>"/>
	     	<?php }else{?>
	     		<img class="fr" src="/img/pic.png"/>
	     	<?php }?>
	     </div>
	</div>
	<!--头部信息 E-->
	<!-- grade-content 我的等级内容 S-->
	<div class="my-grade-content">
		<div class="my-grade-content-list">
			<a href="javascript::void(0)" class="my-grade-list-line my-data-list clearfix"><span class="dm-icon my-data-icon my-data-icon2" ></span><?=$model->attributeLabels()['username']?><span class="fr"><?=$model['username']?></span></a>
			<a href="javascript::void(0)" class="my-grade-list-line my-data-list clearfix"><span class="dm-icon my-data-icon my-data-icon3" ></span><?=$model->attributeLabels()['mobile']?><span class="fr"><?=$model['mobile']?></span></a>
			<a href="<?=Url::toRoute('level/index') ?>" class="my-grade-list-line my-data-list clearfix"><span class="dm-icon my-data-icon my-data-icon4" ></span><?=$model->attributeLabels()['level']?><span class="cout fr  mr17" ><?=$model->levels->name?></span><span class="jt"></span></a>
			<!--a href="<?=Url::toRoute('level/index') ?>" class="my-grade-list-line my-data-list clearfix"><span class="dm-icon my-data-icon my-data-icon5" ></span><?=yii::t('app_member','member_experience');?><span class="fr mr17"><?=$model->attributeLabels()['experience']?>：<?=$model['experience']?></span><span class="jt"></span></a-->
			<!-- <a href="#" class="my-grade-list-line my-data-list clearfix"><span class="dm-icon my-data-icon my-data-icon6" ></span><?=yii::t('app_member','my_qr_code');?><span class="jt"></span></a> -->
			<!--我的店铺 S-->
			<?php if($model->store_id){?>
					<?php if($store->ischeck==StoreEnum::STORE_OK){?>
				<a href="<?=Url::to(['/store/store/view?id='.$model->store_id])?>" class="my-grade-list-line my-data-list clearfix"><span class="dm-icon my-data-icon my-data-icon7" ></span><?=yii::t('app_member','my_store');?>
					<?php }else{?>
							<a href="javascript:void(0)" class="my-grade-list-line my-data-list clearfix"><span class="dm-icon my-data-icon my-data-icon7" ></span><?=yii::t('app_member','my_store');?>
					<?php }?>
				<?php }else{?>  
					<?php if($model->level<=LevelEnum::LEVEL_VIP6){?>				
							<a href="http://dmsh.v089.com/user/settled" class="my-grade-list-line my-data-list clearfix"><span class="dm-icon my-data-icon my-data-icon7" ></span><?=yii::t('app_member','my_store');?>
					<?php }else{?>
							<a href="javascript:void(0)" class="my-grade-list-line my-data-list clearfix"><span class="dm-icon my-data-icon my-data-icon7" ></span><?=yii::t('app_member','my_store');?>
				<?php }}?>
			
			<?php if($model->store_id>0){?>
			     <?php if($store->ischeck==StoreEnum::STORE_OK){?>
			         <span class="fr mr17 b-fc"><?=yii::t('app_member','has_store')?></span>
			     <?php }elseif($store->ischeck==1){?>
			         <span class="fr mr17 r-fc">审核通过</span>
			     <?php }elseif($store->ischeck==2){?>
			     	 <span class="fr mr17 r-fc">拒绝</span>
			     <?php }elseif($store->ischeck==4){?>
			     	 <span class="fr mr17 r-fc">已关闭</span>
			     <?php }?>
			<?php }else{?>
			     <?php if($model->level<=LevelEnum::LEVEL_VIP6){?>
			         <span class="fr mr17 r-fc">我要开店</span>
			     <?php }else{?>
			         <span class="fr mr17 r-fc">未开店</span>
			     <?php }?>
			     
			<?php }?>

			<span class="jt"></span></a>
			<!--我的店铺 E-->
			<a href="<?=Url::toRoute('address/index') ?>" class="my-grade-list-line my-data-list clearfix mt10 bt"><span class="dm-icon my-data-icon my-data-icon8" ></span><?=yii::t('app_member','my_address')?><span class="jt"></span></a>
			
		</div>
	</div>
    <!-- grade-content 我的等级内容 E--> 
</div>           