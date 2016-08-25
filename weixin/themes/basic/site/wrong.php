<?php
  $this->title = Yii::t('app', '页面出错');
  $this->params['breadcrumbs'][] = $this->title;
?>

   <!--xdcs-content  begin-->
<div class="xdcs-content">
    <!--<h2> 出错了
                   </h2>-->
 <!--xdcs-centre  begin-->
    <div class="xdcs-centre">
     <!--xdcsc-top  begin-->
        <div class="xdcsc-top">
            <div class="success-main"> <img src="/img/error.png">
                <p class="tit">出错了！请点击重试</p>
            </div>
        </div>
         <!--xdcsc-top  end-->
          <!--xdcs-apply  begin-->
        <div class="xdcs-apply">
            <button type="submit" class="xdcs-apply-button">重试</button>
        </div>
         <!--xdcs-apply  end-->
    </div>
     <!--xdcs-centre  end-->
</div>
    <!--xdcs-content  end-->
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js">
</script>