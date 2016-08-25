 <?php
$this->title = '主题馆列表';
?>

<div class="index-content">
    <!--首页背景控制-->
    <div class="index-set">

        <!-- Theme Pavilion list 主题馆列表-->
        <div class="d-theme-pav-list">
            <div class="d-pavilion d-index-dis">
                <div class="d-pav-list-s">
                    <ul>
                          <?php foreach ($models_data as $models): ?>
                                <li>
                                    <div class="d-pav-box">
                                        <a href="/goods/activity/ztgxq?id=<?php echo $models['id']; ?>">
                                            <div class="d-pav-theme1">
                                                <span class="d-pav-theme-tit"><?php echo $models['name']; ?></span>
                                                <span class="d-pav-theme-des"><?php echo $models['remark']; ?></span>
                                            </div>
                                            <div class="d-pav-pic">
                                            
                                                <img src="<?=Yii::$app->params['img_domain'].$models['ico']; ?>">
                                            </div>
                                        </a>
                                    </div>
                                </li>
                           <?php endforeach; ?>                       
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--回到顶部--S-->
<div style="display: none;" class="back-top" id="toolBackTop">
    <a title="返回顶部" onclick="window.scrollTo(0,0);return false;" href="#top" class="back-top backtop">
    </a>
</div>
<!--回到顶部--E-->




