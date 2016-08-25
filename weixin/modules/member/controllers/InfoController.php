<?php

namespace weixin\modules\member\controllers;

use Yii;
// use common\models\Member;
// use common\models\MemberInfo;
// use common\models\MoneyLog;
// use weixin\modules\member\models\MemberSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
// use common\service\LevelService;
use common\service\MemberService;
use common\models\Store;
use common\models\DwalletMember;
// use common\models\GoodsGallery;
// use common\service\JsonService;
// use common\enum\MoneyEnum;
/**
 * MemberController implements the CRUD actions for Member model.
 */
class InfoController extends Controller
{
    public function behaviors()
    {
        if( !yii::$app->user->identity->id ) $this->redirect(Yii::$app->urlManager->createUrl(['site/index']));
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    /**
    * 我的资料
    */
    public function actionIndex()
    {
        $member_id=yii::$app->user->identity->id;
        $model=MemberService::findModelById($member_id,['levels','member_info']);
        if ($model->store_id>0){
            $store = Store::findOne($model->store_id);
        }else{
            $store = '';
        }
    	return $this->render('index',['model'=>$model,'store'=>$store]);
    }

}
