<?php

namespace weixin\modules\member\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\service\MemberService;
use common\service\SignService;
use common\service\LevelService;


/**
 * MemberController implements the CRUD actions for Member model.
 */
class LevelController extends Controller
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
    * 我的等级
    */
    public function actionIndex()
    {
        $id=yii::$app->user->identity->id;
        $model=MemberService::getMyLevel($id);
    	return $this->render('index',['model'=>$model]);
    }
    /**
    *权益
    */
    public function actionGrade(){
        $service=new LevelService();
        $list=$service->getRightList();
        return $this->render('grade',['list'=>$list]);
    }


    /**
    *   签到
    */
    public function actionSign(){
        $model=new SignService();
        
        if(Yii::$app->request->post()){
            $model->addSign();
        }

        $info=$model->getSignInfo();

        if(Yii::$app->request->post()){
            exit(json_encode(['code'=>200,'success'=>$info['success'],'layer'=>$info['info']['layer']]));
        }
        
        return $this->render('sign',['info'=>$info]);
    }

    
}
