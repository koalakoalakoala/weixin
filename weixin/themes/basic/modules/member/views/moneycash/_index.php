<?php
use yii\helpers\Url;
 
if(count($list)>0){
	foreach ($list as $key => $value) { ?>
	<li>
		<ul class="balance-btm-cont">
			<li><?=$value['create_time']?></li>
			<li><?=$value['money']?></li>
			<li><?=$value['status_name'] ?></li>
			<li><?php if($value['status'] == 2){echo '<a href="'.Url::toRoute('create').'">'.yii::t('app_member','restart_apply')."</a>";}?></li>
		</ul>
	</li>
<?php }}?>