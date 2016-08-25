<?php

namespace weixin\modules\member\controllers;

use Yii;
// use common\models\MoneyLog;
use yii\web\Controller;
// use common\service\MemberMoneyService;
// use common\service\RechargeService;
// use common\service\MemberService;
// use common\service\WeixinService;
use common\service\JsonService;
// use common\enum\MoneyEnum;


/**
 * MemberController implements the CRUD actions for Member model.
 */
class RecommendController extends Controller
{
	public function behaviors()
    {
        if( !yii::$app->user->identity->id ) $this->redirect(Yii::$app->urlManager->createUrl(['site/index']));
        return [
        ];
    }
    public function actionIndex(){
    	return $this->render('index');
    }

}