<?php
use yii\helpers\Url;
$this->title="分类";
?>
<body onload="setHeight();" onresize=" setHeight()">
<div class="index-content">
    <!--首页背景控制-->
    <div class="index-set">

        <!-- Classification 分类默认界面-->
        <?php if($categorys){ ?>
        <div id="verticalTab" class="d-classification">
            <div class="d-category-tab" id="primary" style="">
                <ul class="resp-tabs-list" id="resp-tabs-listp">
                    <?php foreach($categorys as $k => $v){ ?>
                        <?php if($v['data']['name'] == "特惠专区"){continue;} ?>
                        <li><a href="#"><?=$v['data']['name']?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="resp-tabs-container">
                <?php foreach($categorys as $k1 => $v1){ ?>
                    <!-- 特惠区显示不一样 -->
                    <?php if($v1['type'] == 'tehuino'){ ?>  <!-- 如果将来还要显示特惠分类，将tehuino改成tehui -->
                        <div id="resp-tabs-containerp" class="resp-tabs-containerpp">
                            <?php if(is_array($v1['child']) && count($v1['child'])){
                                foreach($v1['child'] as $k2 => $v2){ ?>
                                <div class="d-tabs-sort">
                                    <a href="<?=Url::to(['activity/view?id='.$v2['id']])?>">
                                        <img class="d-tabs-conimg" src="<?=Yii::$app->params['img_domain'].$v2['ico']?>">
                                        <h2><?=$v2['name']?></h2>
                                    </a>
                                </div>
                            <?php } } ?>
                        </div>
                    <?php } ?>
                    <!-- 普通区展示 -->
                    <?php if($v1['type'] == 'common'){ ?>
                        <div class="d-sort-main">
                        <?php if(isset($v1['child'])){?>
                        <?php if(is_array($v1['child']) && count($v1['child'])){
                            foreach($v1['child'] as $k2 => $v2){ ?>
                                <div class="d-sort-wrapper">
                                    <h3><?=$v2['data']['name']?></h3>
                                    <ul class="d-sort-style">
                                        <?php if(isset($v2['child']) && is_array($v2['child']) && count($v2['child'])){
                                            foreach($v2['child'] as $k3 => $v3){ ?>
                                            <li>
                                                <a href="<?=Url::to(['/goods/goods/category-index?category_id='.$v3['data']['category_id'] ])?>">
                                                    <img src="<?=Yii::$app->params['img_domain'].$v3['data']['ico']?>">
                                                    <span><?=$v3['data']['name']?></span>
                                                </a>
                                            </li>
                                        <?php } } ?>
                                    </ul>
                                </div>

                        <?php } } ?>
                        <?php }?>
                        </div>

                    <?php } ?>

                <?php } ?>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<!--首页JS-->
<script type="text/javascript" language="javascript">

    //分类tab切换
    $(document).ready(function () {
        $('#horizontalTab').easyResponsiveTabs({
            type: 'default', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true   // 100% fit in a container
        });

        $('#verticalTab').easyResponsiveTabs({
            type: 'vertical',
            width: 'auto',
            fit: true
        });
    });
    
    //获取分类左边的高度而得右边高度相同
    function setHeight()
			{   
				var max_height = document.documentElement.clientHeight;
				var primary = document.getElementById('primary');
				var leftsc = document.getElementById('resp-tabs-listp');
				var rightsc = document.getElementById('resp-tabs-containerp');
				primary.style.minHeight = max_height+"px";
				/*primary.style.maxHeight = max_height+"px";
				leftsc.style.minHeight = max_height+"px";
				leftsc.style.maxHeight = max_height+"px";
				
				rightsc.style.minHeight = max_height+"px";
				rightsc.style.maxHeight = max_height+"px";*/
			}
			
</script>
</body>