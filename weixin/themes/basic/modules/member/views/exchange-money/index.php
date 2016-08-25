<?php
use yii\helpers\Url;

$this->title = '我的消费券';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="balance-top mt10 bt clearfix">
    <div class="fl fon16">我的消费券</div>
    <div class="price fr">￥<?=$money['exchange']?></div>
</div>
<!--balance-top 顶部信息 E-->
<!-- balance-buttom 我的余额底部内容 S-->
<div class="balance-buttom my-jf-buttom">
    <!-- xzzf-title 我的余额标题 S-->
    <div class="xzzf-title balance-buttom-title">
        <div class="inxzzf-title inbalance-title">
            <div class="xzzf-title-box">
                <div class="inxzzf-title-box f18">消费券明细</div>
            </div>
        </div>
    </div>
    <!-- xzzf-title 我的余额标题 E-->
    <!-- balance-btm-content 我的余额收支明细内容 S-->
    <ul id='data_page'>
        <li class="stick-tittle">
            <ul class="balance-btm-tit">
                <li>时间</li>
                <li>明细</li>
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
    </ul>
    <!-- balance-btm-content 我的余额收支明细内容 E-->
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