<?php
use yii\helpers\Html;
// use yii\helpers\Html;
// use yii\grid\GridView;
// use common\service\AdminService;
// use common\enum\PermissionEnum;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\member\MemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app_member', 'add_address');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="create-form mt10">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
        'sku_id'=>$sku_id
    ]) ?>

</div>
