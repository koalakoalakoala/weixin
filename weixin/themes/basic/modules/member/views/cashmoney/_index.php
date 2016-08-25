<?php if(count($list)>0){ foreach ($list as $key => $value) { ?>
	<li>
		<ul class="balance-btm-cont">
			<li><?=date('Ymd',$value['create_time'])?></li>
			<?php if($value['type']==1){
				echo "<li class=\"green\">+{$value['money']}</li>";
			}else{
				echo "<li class=\"red\">-{$value['money']}</li>";
			}?>
			<li><?=$value['remark']?></li>
		</ul>
	</li>
<?php }}?>