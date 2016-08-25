<?php if(count($list)>0){ foreach ($list as $key => $model) { ?>
	<li class="phone-shopbox show-box1">
		<ul class="balance-btm-cont">
			<li><img src="/img/man.png"></li>
			<li><?=$model['member_info']['realname']?></li>
			<li><?=$level[$model['member']['level']]?></li>
			<li><?=$model['money']?></li>
			<li><?=date('Y-m-d',$model['create_time'])?></li>
		</ul>
	</li>
<?php }}?>