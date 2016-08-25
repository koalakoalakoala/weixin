<?php 
	use yii\widgets\ActiveForm;
	use yii\helpers\Url;
?>

<div class="my-sign-container-wraper">
	<!--sign 顶部信息 S-->
	<div class="my-sign-top">
		<div class="in-my-sign-top">
			<div class="my-sign-top-info">
				<div class="txt">每天签到可1成长值，连续7天签到，额外奖励5成长值</div><div class="img"><img src="/img/tip-bear.gif"/></div>
			</div>
		</div>
	</div>
	<!--顶部信息 E-->
	<!-- sign-content 提交订单中部内容 S-->
	<div class="my-sign-content">
		<div class="in-my-sign-content">
			<div class="week-item-wraper clearfix">
			<?php for($i=1;$i<=7;$i++){ ?>
			<div class="week-item <?php if($info['info']['layer']>=$i){echo 'cur';} ?>">第<span><?=$i?></span>天</div>
			<?php }?>
			</div>
		</div>
	</div>
    <!-- sign-content 提交订单中部内容 E--> 
	<!--底端-->
	<div class="tjdd-btn">
		  <div class="btn-lie intjdd-btn b-card-btn">
		  	<?php if($info['success']==0){?>
			     <button class="fr submit"><?=yii::t('app_member','sign')?></button>
			<?php }else{ ?>
			     <button disabled class="cur-tip"><?=yii::t('app_member','has_sign')?></button>
			<?php }?>
		 </div>
	</div>
</form>
</div>

<script type="text/javascript">
    $(function(){
        $(".submit").click(function(){
        	var url =" <?php echo Url::to (['level/sign' ])?> ";
            $.post(url,{sign:1,'_csrf' :' <?=Yii:: $app->request ->csrfToken ?>'},
                function(rs){
                    if(rs['code' ] == 200){
                        var html = '';
                        for(var i=1;i<=7;i++){
                            if(rs['layer']>=i){
                         	    html += '<div class="week-item cur">第<span>'+i+'</span>天</div>';
                            }else{
                            	html += '<div class="week-item">第<span>'+i+'</span>天</div>';
                            }
                        }
                        $(".week-item-wraper").html(html);

                        if(rs['success']==0){
                            $(".b-card-btn").html('<button class="fr submit">签到</button>');
                        }else{
                        	$(".b-card-btn").html('<button disabled class="cur-tip">今日已签到</button>');
                        }
                    }
                }, "json"
            );
        });
    });
</script>
    