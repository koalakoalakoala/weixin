<?php
use yii\helpers\Url;
use common\enum\OrderEnum;
$this->title = Yii::t('app_member', 'setting');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="my-index-bottom">
	<a href="<?=Url::toRoute('password')?>" class="list">
		<span class="dm-icon my-index-icon set-icon1"></span>
		<span>修改<?=$model->attributeLabels()['password']?></span>
		<span class="jt dm-list-right"></span>
   </a>
   <a href="<?=Url::toRoute('zfpwd')?>" class="list">
		<span class="dm-icon my-index-icon set-icon2"></span>
		<span>修改<?=$model->attributeLabels()['zf_pwd']?></span>
		<span class="jt dm-list-right"></span>
   </a>
   <!-- <a href="#" class="list list-mg">
		<img src="/img/my-index_2.png">
		<span>帮助中心</span>
		<span class="jt dm-list-right"></span>
   </a> -->
</div>