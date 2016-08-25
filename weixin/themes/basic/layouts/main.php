<?php
use weixin\assets\AppAsset;
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
	<!--<input type="hidden" class="stick-tittle2" />
	<input type="hidden" class="stick-tittle" />-->
    <?php $this->beginBody() ?>
    <div class="mod_container">
        <?= $content ?>
        <?= \bluezed\scrollTop\ScrollTop::widget() ?>
    </div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
