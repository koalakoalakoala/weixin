
    <!--  筛选滑动切入 S-->
			    	  <div class="d-sidebar-container  hydj-container">	
							<ul>

							<?php foreach ($list as $key => $model) {?>
								<li <?=$key==0?"class='opened'":'' ?> >
									<a href="#" class="swrap-title">
										<i class="d-arrow"></i>
										<span class="d-sidebar-title "><b><?=$model['name']?></b> 会员特权 <span class="sz">（<?=$model['experience']?>≤成长值＜<?=$model['top_experience']?>）</span></span>
									</a>
									<div class="d-tab-con d-brand hydj-content">
										<ul>

										<?php if(count($model['right_list'])){
											foreach ($model['right_list'] as $key => $value) {?>
											<li>
												<span class=" dm-icon dm-tick"></span>
												<span><?=$value?></span>
											</li>
										<?php }}?>
										</ul>
									</div>
								</li>
							<?php }?>
							</ul>
						</div>
						
<script language="javascript">
        $('.swrap-title').each(function(){
        	if($(this).height()>60){
        		$('.swrap-title').addClass('swrap-titlep');
        		$('.swrap-title').find('.sz').addClass('szp');
        	}
        });
</script>
<!--  筛选滑动切入 E-->


