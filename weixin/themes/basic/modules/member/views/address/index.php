<?php
use yii\helpers\Url;
// use yii\grid\GridView;
// use common\service\AdminService;
// use common\enum\PermissionEnum;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\member\MemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this -> title = Yii::t('app_member', 'address_list');
$this -> params['breadcrumbs'][] = $this -> title;
?>
<!-- wddz-content 我的地址 S-->
<div class="wddz-wraper mt10">
<?php foreach ($list as $key => $model) { ?>
<div class="wddz-content wddz-contentp">
    <div class="wddzli-top clearfix">
    	<span class="addr-sel"><i class="dm-icon <?php if($model->is_default){?>select<?php } ?>" onclick="setDefault(<?=$model->id?>)"></i></span>
    </div>
	<div class="f14 fw-b"><?=$model['name'] ?><span class="fw-b ml10"><?=$model['mobile'] ? $model['mobile'] : $model['tel'] ?></span><span class="r-fc fr" onclick="dele(this);" dele="<?=$model['id'] ?>">删除</span></div>

	<a class="addr-name" href="<?=Yii::$app->urlManager->createUrl(['/member/address/update', 'id' => $model['id'], 'sku_id'=>$sku_id]) ?>"><span class="r-fc <?php
	if ($model -> is_default == 0)
		echo 'hidden';
 ?>" ><?="[" . Yii::t('app_member', 'default') . "]" ?> </span><i class="arrowent"></i>

	<?="{$model['province']}&nbsp;&nbsp;{$model['city']}&nbsp;&nbsp;{$model['area']}&nbsp;&nbsp;{$model['detail']}" ?></a>

</div>
<?php } ?>
</div>

<div class="tjdd-btn">
  <div class="btn-lie intjdd-btn inwddz-btn">
	<a href="<?=Url::toRoute('create?sku_id=' . $sku_id) ?>" class="fr "><?=Yii::t('app_member', 'add_address') ?></a>
 </div>
</div>
<script type="text/javascript">$(function() {
			$('.clearfix').on('click', '.setDefault', function(event) {
						var $this = $(this);
						var url = $this.attr('href');
						$.getJSON(url, '', function(data) {
									if (data.success == 1) {
										var text = "<?= Yii::t('app_member', 'default') ?>";
$this.addClass('hidden')
	.parents('.clearfix').siblings('div.mt5').find('span.r-fc')
	.removeClass('hidden')
	.parents('.wddz-content').siblings('.wddz-content').each(function() {
		var it = $(this);
		it.children('.mt5').find('span.r-fc').addClass('hidden');
		it.children('.fc12').find('a.setDefault').removeClass('hidden');
	});

//跳转到购物页面
// var return_url = "<?= Yii::$app -> session['from_url_' . Yii::$app -> user -> id] ?>";
// if(return_url.length>0){
// 	location.href = return_url;
// }
} else {
	$.MsgBox.Alert("", data.msg);
}
});
event.preventDefault();
});
$('.clearfix').on('click', '.delete', function(event) {
var $this = $(this);
var url = $this.attr('href');
$.getJSON(url, '', function(data) {
	if (data.success == 1) {
		$this.parents('div.wddz-content').hide();
	} else {
		$.MsgBox.Alert("", data.msg);
	}
});
event.preventDefault();
});
});

	function setDefault(o) {
		var url = "<?=Url::toRoute(['setdefault'])?>" + "?id=" + o;
		location.href = url;
	}

//删除地址
function dele(o) {
	var id = $(o).attr("dele");
	$.MsgBox.Confirm("", "你确定要删除该收货地址？", function() {
				var url = "<?= Url::to(['/member/address/delete']) ?>";
$.post(url, {
			id: id,
			'_csrf': '<?=Yii::$app -> request -> csrfToken ?>'},

function(data) {
	var res = eval('(' + data + ')');
	if (parseInt(res.code) == 200) {
		$.MsgBox.Alert("", res.msg);
		window.location.reload();
	} else {
		$.MsgBox.Alert("", res.msg);
		return false;
	}
}
);
});
}</script>