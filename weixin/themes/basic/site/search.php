<?php
use yii\helpers\Html;
use yii\grid\GridView;
use common\service\AdminService;
use common\enum\PermissionEnum;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\member\MemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app_member', 'Level');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('searchHeader');?>
<div class="mr_search" >
	<!--头部搜索框 S-->
	<div class="top clearfix">
		<div class="insearch fl" >
			<input  type="text"/>
			       <a href="javascript:;" class=" hd_search mr_sc"></a>
			       <!--<a href="javascript:;" class="hd_search xx"></a>-->
		</div>
		<a href="#" class="cancel sou " >搜索</a>
	 </div>
	 <!--头部搜索框 E-->
	 
	 <!--热门搜索 S-->
	 <div class="hot_ct">
		 	<div class="title">
		 		热门搜索
		 	</div>
		 	<div class="tit">
		 	    <a href="#">凉风衣</a>
		 	    <a href="#">充电宝</a>
		 	    <a href="#">春装外套女装</a>
		 	    <a href="#">凉风衣</a>
		 	    <a href="#">春装外套女装</a>
		 	    <a href="#">凉风衣</a>
		 	    <a href="#">春装外套女装</a>
		 	    <a href="#">春装外套女装</a>
		 	    
		 	</div>

	 </div>
	 <!--热门搜索 E-->
	 <!--最近搜索 S-->
	 <div class="hot_ct rec_ct">
		 	<div class="title clearfix">
		 		最近搜索
		 		<a href="#" class="fr blue">清除</a>

		 	</div>
		 	<div class="tit">
		 	    <a href="#">特斯拉车载套件</a>
		 	    <a href="#">充电宝</a>
		 	    <a href="#">春装外套女装</a>
		 	    
		 	    
		 	</div>

	 </div>
	 <!--最近搜索 E-->
 </div>
 
 <script>
   $(function(){
       	 $(".hd_menu").click(function(){
       	 	$("menu").css("display","block")
       	 });
       	
   });
</script>