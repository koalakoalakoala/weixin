<?php
use yii\helpers\Url;

$this->title = Yii::t('app_member', 'my_money_cash');
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="balance-buttom my-jf-buttom my-czmx">
	<!-- my-czmx-content 充值明细收支明细内容 S-->
	<ul id='data_page'>
		<li class="stick-tittle">
			<ul class="balance-btm-tit">
				<li><?=$model->attributeLabels()['create_time']?></li>
				<li><?=$model->attributeLabels()['money']?></li>
				<li><?=$model->attributeLabels()['status']?></li>
				<li><?=$model->attributeLabels()['remark']?></li>
			</ul>
		</li>

		<?php if(count($list)>0){
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
	</ul>
	<!-- my-czmx-content 充值明细内容 E-->
	<div style="display: block;" class="click-loading click-loading-mt">
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