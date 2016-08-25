<?php
    $this->title = Yii::t('app', '信贷超市');
    $this->params['breadcrumbs'][] = $this->title;
?>

<div class="xdcs-content">
    <!--  <h2>信贷超市</h2>-->
    <ul class="xdcs-jydbox">
        <?php if($data){?>
            <?php foreach($data as $k=>$v){?>
                <li class="xdcs-jydbox-list">
                    <div class="xdcs-jydbox-title">
                        <a class="xdcs-jydbox-pic" href="hcdetails?id=<?php echo $v->id?>"><img src="<?php echo $v->product_icon ? Yii::$app->params['img_domain'].$v->product_icon : ''?>"></a> <a href="#" class="xdcs-jydbox-name"><?php echo $v->product_name;?></a> </div>
                    <div class="xdcs-jydbox-details clearfix">
                        <p> 利率：月<?php echo $v->product_rate;?>% </p>
                        <p> 额度范围：<?php echo ($v->limit_min/10000)?>万-<?php echo ($v->limit_max/10000)?>万 </p>
                        <p> 期限范围：<?php echo $v->deadline_range;?> </p>
                        <p> 还款方式：<?php echo $v->back_money_type==1? '等额本金':'等额本息';?> </p>
                    </div>
                    <div class="xdcs-apply">
                        <button type="submit" class="xdcs-apply-button">立即申請</button>
                    </div>
                </li>
            <?php }?>
        <?php }else{?>
            <li class="xdcs-jydbox-list">
                <div>还没有产品提供，请耐心等待</div>
            </li>
        <?php }?>
    </ul>
    <div style="display: block;" class="click-loading"> <a href="javascript:void(0);">继续向下加载更多</a> </div>
</div>

<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js">
</script>