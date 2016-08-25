<?php
use yii\helpers\Url;
// use yii\grid\GridView;
// use common\service\AdminService;
// use common\enum\PermissionEnum;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\member\MemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app_member', 'level');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-wraper-bg">
    <!--grade-top 头部信息 S-->
    <div class="my-grade-top">
        <div class="my-grade-top-menu">
            <div class="my-grade-top-menu-item">
                <span class="txt">我的等级</span>
                <br/><span class="cout" ><?php echo ($model['experience']>2000000)?$model['next_level_name']:$model['level_name'] ?></span>
            </div>
            <div class="my-grade-top-menu-item">
                <span class="txt">我的成长值</span>
                <br/><span class="record"><?=$model['experience'] ?></span>
            </div>
        </div>
        <div class="my-grade-top-content">
            <div class="my-grade-top-content-info">成长值：<?=$model['experience'] ?>，<?php if($model['experience']<2000000){ ?>
                升级还需：<span class="r-fc"><?= $model['next_level_experience']-$model['experience'] ?></span>成长值<?php }else{ ?><span class="r-fc">当前会员已满级</span><?php }?></div>
            <div class="votebox">
                <dl class="barbox">
                    <dd class="barline">
                        <div w="<?=$model['percent'] ?>" style="width:0px;" class="charts"></div>
                    </dd>
                </dl>
            </div>
            <div class="my-grade-top-content-vip clearfix"><div class="box fl  r-fc"><?=$model['level_name'] ?></div><div class="box fr"><?=$model['next_level_name'] ?></div></div>
        </div>
    </div>
    <!--头部信息 E-->
    <!-- grade-content 我的等级内容 S-->
    <div class="my-grade-content">
        <div class=" my-grade-content-list-title">
            <a href="<?=Url::toRoute('level/grade') ?>" class="my-grade-list-line"><span class="dm-icon my-grade-icon my-grade-icon1"></span>会员级别及权益<span class="jt"></span></a>
        </div>
        <div class="my-grade-content-list">
            <a href="<?=Url::to(['/home/home/index'])?>" class="my-grade-list-line"><span class="dm-icon my-grade-icon my-grade-icon2"></span>商城购物<span class="jt"></span></a>
            <!--<a href="<?/*=Url::toRoute('balance/index') */?>" class="my-grade-list-line"><span class="dm-icon my-grade-icon my-grade-icon3"></span>充值余额<span class="jt"></span></a>-->
            <a href="<?=Url::toRoute('sign') ?>" class="my-grade-list-line"><span class="dm-icon my-grade-icon my-grade-icon4"></span>签到<span class="jt"></span></a>
            <!-- <a href="<?=Url::toRoute('recommend/index') ?>" class="my-grade-list-line"><span class="dm-icon my-grade-icon my-grade-icon5"></span>推荐会员<span class="jt"></span></a> -->
        </div>
    </div>
    <!-- grade-content 我的等级内容 E--> 
</div>
<script language="javascript">
        function animate(){
            $(".charts").each(function(i,item){
                var a=parseInt($(item).attr("w"));
                $(item).animate({
                    width: a+"%"
                },1500);
            });
        }
        animate();
</script>