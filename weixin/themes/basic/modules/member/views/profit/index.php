<div class="balance-top">
	<div class="">我的小伙伴：<span class="r-fc"><?=isset($childrenCount) ? $childrenCount : 0?>人</span></div>
	<div class="">贡献收益：<span class="price">￥<?=isset($money) ? $money : 0?></span></div>
</div>
<!--my-rbag-top 顶部信息 E-->

<!-- my-rbag-buttom 我的余额底部内容 S-->
<div class="balance-buttom my-partner-buttom" id='tabs'>
<!-- my-rbag-btm-content 我的余额收支明细内容 S-->
<!-- 	<div class="my-order-top stick-tittle"> -->
	<ul class="my-order-menu stick-tittle">
		<li><a href="?type=1" class="<?=$type==1?'cur':''?> click-btn1"><span>一代会员（<?=isset($one[0]['count']) ? $one[0]['count'] : 0?>）</span></a></li>
		<li><a href="?type=2" class="<?=$type==2?'cur':''?> click-btn2"><span>二代会员（<?=isset($two[0]['count']) ? $two[0]['count'] : 0?>）</span></a></li>
		<!-- <li><a href="?type=3" class="<?=$type==3?'cur':''?> click-btn3"><span >三代会员（<?=isset($three[0]['count']) ? $three[0]['count'] : 0 ?>）</span></a></li> -->
	</ul>
<!-- </div> -->
<ul id='data_page'>
	<li class="stick-tittle2">
		<ul class="balance-btm-tit">
			<!-- <li>头像</li> -->
			<li>手机</li>
			<li>会员等级</li>
			<li>贡献收益</li>
			<li>注册时间</li>
		</ul>
	</li>

	<?php if(count($list)){foreach ($list as $key => $model) { ?>
	<li class="show-box1">
		<ul class="balance-btm-cont balance-btm-contp">
           <!--<li class="balance-pic"><img src="<?=$model['avatar']?$model['avatar']:'/img/pic.png'; ?>"></li>-->
			
			<li><?php echo $model['mobile'].'<br />('.($model['realname']?mb_substr($model['realname'],0,1,'utf-8').'**':'--').')';?></li>
			<li><?=$model['name']?></li>
			<li><?=$model['money']?$model['money']:'0.00'?></li>
			<li><?=date('Y-m-d',$model['create_time'])?></li>
		</ul>
	</li>
	<?php }}else{
       echo '<span>没有查询到会员对当前用户的贡献数据</span>';
    }

    ?>
</ul>
<?php if(count($list)>0){?>
<div style="display: none;" class="click-loading">
     <a href="javascript:;">继续向下加载更多</a>
</div> 
<?php }?>
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
	
	var topm2 = $('.stick-tittle2').offset().top-50;
	$(window).scroll(function() {
		if ($(window).scrollTop() >= (topm2-46)) {
			$(".stick-tittle2").addClass("fixedtop2");
		} else {
			$(".stick-tittle2").removeClass("fixedtop2");
		}
	});
	/*标题固定在窗口 E*/
	

    </script>