<!-- Shop categoryinfo 店铺分类-->
<div class="shop-cate" >
    <div class="d-headert">
            <a onclick="" href="#" class="back"> </a>
            <div class="placeholder"></div>
            <div class="title">选择分类</div>
            <div class="arrowqxp" style="display: none;"><a class="arrowqx" href="#">取消</a></div>

    </div>
    <?php if($categories){?>
    <div class="d-sidebar-container d-sidebar-container_p shoop-detinfo">

        <ul  id="primary" style="">
            <?php foreach($categories as $k => $v){?>
            <?php if($k==0){ echo '<li class="opened">';}else{?>
            <?php echo '<li>';}?>
                <a href="#" class="swrap-title">
                    <i class="d-arrow"></i>
                    <span class="d-sidebar-title"><?php echo $v['name']?></span>
                </a>
                <?php

                if(count($v)>3){ ?>
                <div class="d-tab-con d-brand">
                    <ul>
                        <?php foreach($v['child'] as $k1 => $v1){?>
                        <li>
                            <span><a style='border:none' href="<?=\yii\helpers\Url::to(['../store/store/goods-list-category','diy_cid'=>$v1['id'],'store_id'=>$sid])?>"> <?php echo  $v1['name'];  ?></a></span>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                <?php }else{  ?>
                <div class="d-tab-con d-brand">
                    <ul>
                        <li>
                            <span>暂无子类</span>
                        </li>
                    </ul>
                </div>
                <?php } ?>
            </li>
            <?php } ?>
        </ul>
    </div>
    <?php } ?>
</div>
