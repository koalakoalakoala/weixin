<?php
use yii\helpers\Url;

$this->title = "我的返利";
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="balance-top my-jftx-top">
				<div class="">我的返利</div>
				<div class="price"><?=$money['gold_points']?></div>
			</div>
			<!--my-jf 顶部信息 E-->
			
			<!-- my-jf-center 我的积分中部内容 S-->
			<!-- <div class="menu jf-menu">
				<ul class="menu-list">
					<li></li>
					<li style="align:center;">
						<a href="<?=Url::toRoute('egd') ?>" class="menu-btn jfmenu-btn1">
							<span class="menu-icon"></span>
							<span class="menu-txt">兑换EGD</span>
						</a>
					</li>
					<li>
						<a href="<?=Url::toRoute('cash') ?>" class="menu-btn jfmenu-btn2">
							<span class="menu-icon"></span>
							<span class="menu-txt">积分提现</span>
						</a>
					</li> -->
					<!--<li>
						<a href="" class="menu-btn jfmenu-btn3">
							<span class="menu-icon"></span>
							<span class="menu-txt">兑换股票</span>
						</a>
					</li>
				</ul>
			
			</div>-->
			<!--<div class="my-jf-center">
				<ul class="dm-order-menu my-jf-menu">
				   	    <li>
				   	    	<a href="<?=Url::toRoute('egd') ?>" class="btn menu-btn1">
								<span class="dm-icon my-jf-icon my-jf-icon1"></span>
								<span class="txt">兑换EGD</span>
							</a>
				   	    </li>
				   	    <li>
				   	    	<a href="<?=Url::toRoute('cash') ?>" class="btn menu-btn1">
								<span class="dm-icon my-jf-icon my-jf-icon2"></span>
								<span class="txt">积分提现</span>
							</a>
				   	    </li>
				   	    <li>
				   	    	<a href="#" class="btn menu-btn1">
								<span class="dm-icon my-jf-icon my-jf-icon3"></span>
								<span class="txt">兑换股票</span>
							</a>
				   	    </li>
				   </ul>
			 </div>-->
		<!-- my-jf-center 我的积分中部内容 E--> 
		
		<!-- my-jf-buttom 我的积分底部内容 S-->
		<div class="balance-buttom my-jf-buttom">
			<!-- my-jf-title 我的积分标题 S-->
			<div class="xzzf-title balance-buttom-title">
				<div class="inxzzf-title inbalance-title">
					<div class="xzzf-title-box">
						<div class="inxzzf-title-box f18">返利明细</div>
					</div>
				</div>
			</div>
			<!-- my-jf-title 我的积分标题 E-->
			<ul id='data_page'>
				<li class="stick-tittle">
					<ul class="balance-btm-tit">
						<li>时间</li>
						<li>返利明细</li>
						<li>备注</li>
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

			    <!-- <li>
					<ul class="balance-btm-cont">
						<li>20150505</li>
						<li class="red">-20</li>
						<li>兑换EGD</li>
					</ul>
				</li>
				<li>
					<ul class="balance-btm-cont">
						<li>20150505</li>
						<li class="green">+20</li>
						<li>购物赠送</li>
					</ul>
				</li>
				<li>
					<ul class="balance-btm-cont">
						<li>20150505</li>
						<li class="red">-20</li>
						<li>积分提现</li>
					</ul>
				</li>
				<li>
					<ul class="balance-btm-cont">
						<li>20150505</li>
						<li class="red">-20</li>
						<li>退换股票</li>
					</ul>
				</li> -->
			</ul>
			<!-- my-jf-btm-content 我的余额收支明细内容 E-->
			<div style="display: block;" class="click-loading click-loading-mt">
	             <a href="javascript:void(0);">继续向下加载更多</a>
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
       var topm = $('.stick-tittle').offset().top;
	$(window).scroll(function() {
		if ($(window).scrollTop() >= topm) {
			$(".stick-tittle").addClass("dm-fixedtop");
		} else {
			$(".stick-tittle").removeClass("dm-fixedtop");
		}
	});
	/*标题固定在窗口 E*/
    </script>