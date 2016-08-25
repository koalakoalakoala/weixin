<?php
use yii\helpers\Url;

$this->title = Yii::t('app_member', 'my_balance');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="balance-top">
	<div class=""><?=yii::t('app_member','my_all_money')?></div>
	<div class="price">￥<?=$money['money']?></div>
</div>
	<!--balance-top 顶部信息 E-->
	
	<!-- balance-center 我的余额中部内容 S-->
	<div class="balance-center">
		<!--<div class="balance-center-item">
        	<div href="#" class="img"><img class="pic" src="/img/my-balance2.png" alt=""></div>
            <div class="info">
                <div class="txt">
				    <div class="price"><?/*=$model->attributeLabels()['cz_money']*/?>：<span>￥<?/*=$money['cz_money']*/?></span></div>
				    <a href="#" class="tip"><?/*=yii::t('app_member','search_cz_money')*/?><span class="dm-icon balance-icon"></span></a>
		         </div>
		         <div class="balance-center-btnp"><a href="<?/*=Url::toRoute('recharge/index') */?>" class="balance-center-btn red"><?/*=yii::t('app_member','recharge')*/?></a></div>
            </div>
         </div> -->
         

      <!--   <div class="balance-center-item">
        	<div href="<?/*=Url::toRoute('moneycash/index') */?>" class="img"><img class="pic" src="/img/my-balance1.png" alt=""></div>
            <div class="info">
                <div class="txt">
				    <div class="price">余额<?php /*//=$model->attributeLabels()['money']*/?>：<span>￥<?/*=$money['money']*/?></span></div>
				    
		         </div>
		         <div class="balance-center-btnp"></div>
            </div>
         </div>-->

         <!--<div class="balance-center-item">
        	<div href="#" class="img"><img class="pic" src="/img/my-balance3.png" alt=""></div> 
            <div class="info">
                <div class="txt">
				    <div class="price"><?/*=$model->attributeLabels()['fronze_money']*/?>：<span>￥<?/*=$money['fronze_money']*/?></span></div>
				    <a class="tip gray"><?/*=yii::t('app_member','wait_money')*/?></a>
		         </div>
            </div>
         </div> 
	 </div>-->
		<!-- balance-center 我的余额中部内容 E--> 
		
		<!-- balance-buttom 我的余额底部内容 S-->
		<div class="balance-buttom">
			<!-- xzzf-title 我的余额标题 S-->
			<div class="xzzf-title balance-buttom-title">
				<div class="inxzzf-title inbalance-title">
					<div class="xzzf-title-box">
						<div class="inxzzf-title-box f18"><?=yii::t('app_member','balance_detail')?></div>
					</div>
				</div>
			</div>
			<!-- xzzf-title 我的余额标题 E-->
			<!-- balance-btm-content 我的余额收支明细内容 S-->
			<ul id='data_page'>
				<li class="stick-tittle">
					<ul class="balance-btm-tit">
						<li><?=$moneyLogModel->attributeLabels()['create_time']?></li>
						<li><?=yii::t('app_member','balance_detail')?></li>
						<li><?=$moneyLogModel->attributeLabels()['remark']?></li>
					</ul>
				</li>
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
			</ul>
			<!-- balance-btm-content 我的余额收支明细内容 E-->
			<div style="display: block;" class="click-loading">
	             <a href="javascript:;">继续向下加载更多</a>
            </div> 
	</div>

	<script type="text/javascript" >
		var page=2;
        $('.click-loading a').click(function(){
            $.getJSON(location.href, {page: page}, function(json) {
                if (typeof(json.list) != 'undefined') {
                    $("#data_page").append(json.list);
                    //修改翻页数量
                    page = parseInt(json.page, 10) + 1;
                }else{
                	$(".click-loading").html(json.info);
                }
            });
        });
        
        /*标题固定在窗口 S*/
       var topm = $('.stick-tittle').offset().top-50;
	$(window).scroll(function() {
		if ($(window).scrollTop() >= topm) {
			$(".stick-tittle").addClass("dm-fixedtop");
		} else {
			$(".stick-tittle").removeClass("dm-fixedtop");
		}
	});
	/*标题固定在窗口 E*/
    </script>