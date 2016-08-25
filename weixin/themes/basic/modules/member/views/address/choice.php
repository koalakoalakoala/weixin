<?php 
use yii\helpers\Url;
$this->title = Yii::t('app_member', 'address_list');
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="wddz-wraper mt10 bt">
<?php foreach ($list as $key => $model) { ?>
	<a href="<?=$from_url.'&address_id='.$model['id'] ?>" class="wddz-content wddz-contentp">
	    <?php
			if($selected_address_id){
				if($model->id== $selected_address_id) { ?>
					<div class="wddzli-top">
						<span class="addr-sel"><i class="dm-icon select"></i></span>
					</div>
				<?php } 
			}else{ 
				if($model->is_default == 1){?>
					<div class="wddzli-top">
						<span class="addr-sel"><i class="dm-icon select"></i></span>
					</div>
				<?php }
			}
		?>
		<div class="f14 fw-b"><?=$model['name'] ?><span class="fw-b ml10"><?=$model['mobile']?$model['mobile']:$model['tel'] ?></span></div>
		<div class="f12 mt5 lh20">
		<span class="r-fc <?php if($model->is_default==0) echo 'hidden'; ?>" >
			<?="[".Yii::t('app_member', 'default')."]"?>
		</span>
	<?="{$model['province']}&nbsp;&nbsp;{$model['city']}&nbsp;&nbsp;{$model['area']}&nbsp;&nbsp;{$model['detail']}"?></div>
	</a>
	<?php }?>
</div>


<!--底端-->
<div class="tjdd-btn xzdz-btn">
	  <div class="btn-lie intjdd-btn inwddz-btn">
		<a href="<?=Url::toRoute(['index', 'sku_ids' => $sku_ids]) ?>" class="fr ">管理收货地址</a>
	 </div>
</div>