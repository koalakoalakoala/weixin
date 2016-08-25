<?php

namespace weixin\modules\member\controllers;

use Yii;
use common\models\MoneyLog;
use yii\web\Controller;
use common\service\MemberMoneyService;
use common\service\MoneyLogService;
use common\service\EdgBackService;
use common\service\PointCashService;
use common\service\MemberService;
use common\service\CommonService;
use common\service\JsonService;
use common\enum\MoneyEnum;
use yii\helpers\Url;
/**
 * MemberController implements the CRUD actions for Member model.
 */
class PointController extends Controller
{
    public function behaviors()
    {
        if( !yii::$app->user->identity->id ) $this->redirect(Yii::$app->urlManager->createUrl(['site/index']));
        return [
        ];
    }
    public function actionIndex(){
    	$MoneyLogService=new MoneyLogService();
        $money_type=[
            MoneyEnum::POINT,
        ];
    	$list=$MoneyLogService->getList($money_type);
		if(Yii::$app->request->isAjax){
            $html = $this->renderPartial('_index', ['list' => $list], true, false);
            if($html){
                $info='';$list=$html;
            }else{
                $info=yii::t('app_status','empty');
                $list='';
            }
            echo JsonService::success('',$info,$list,'',['page'=>Yii::$app->request->queryParams['page']]);
            exit;
        }
		$memberMoneyService=new MemberMoneyService();
		$money=$memberMoneyService->getMoney('gold_points');
    	return $this->render('index',['money'=>$money, 'list'=>$list]);
    }
    /**
    *提现
    */
    public function actionCash(){
		$CashService=new PointCashService();
        $model=$CashService->getModel();
        $member_id=yii::$app->user->identity->id;
        $post=Yii::$app->request->post();
        if($post){
            $result=$CashService->create($member_id,$post);//提交


            if($result['success']==0){
                $model=$result['info'];
            }else{
                return $this->redirect(Url::toRoute('index'));
            }
        }
        $memberModel=MemberService::findModelById($member_id,['member_money']);

        if(count($memberModel->member_money)==0){
            $memberMoneyService=new MemberMoneyService();
            $moneyModel=$memberMoneyService->getDefaultModel($member_id);
        }else{
            $moneyModel=$memberModel->member_money;
        }
		// $edgMoney=$CashService->getDistributionMoney($moneyModel->money);
        $default=$model->getDefaultValue();
        foreach ($default as $key=>$value) {
        	$model->$key=$model->$key!==null?$model->$key:$value;
        }
    	return $this->render('cash',['memberModel'=>$memberModel,'moneyModel'=>$moneyModel,'model'=>$model]);
    }


    /**
    *兑换EGD
    */
    public function actionEgd(){

		$CashService=new EdgBackService();
        $model=$CashService->getModel();
        $member_id=yii::$app->user->identity->id;
        $post=Yii::$app->request->post();
        if($post){
            $result=$CashService->create($member_id,$post);//提交
            if($result['success']==0){
                $model=$result['info'];
            }else{
                return $this->redirect(Url::toRoute('index'));
            }
        }
        $memberModel=MemberService::findModelById($member_id,['member_money']);

        if(count($memberModel->member_money)==0){
            $memberMoneyService=new MemberMoneyService();
            $moneyModel=$memberMoneyService->getDefaultModel($member_id);
        }else{
            $moneyModel=$memberModel->member_money;
        }
		$edgMoney=$CashService->getDistributionMoney($moneyModel->gold_points);
        $default=$model->getDefaultValue();
        foreach ($default as $key=>$value) {
        	$model->$key=$model->$key!==null?$model->$key:$value;
        }
    	return $this->render('egd',['memberModel'=>$memberModel,'moneyModel'=>$moneyModel,'model'=>$model,'edgMoney'=>$edgMoney]);
    }

    /**
    *获取金额的处理办法
    */
    public function actionGetmoney(){
        $CashService=new EdgBackService();
        $params=Yii::$app->request->queryParams;
        $bool=$CashService->checkMoney($params['money']); 
        if($bool['success']==0){
            echo JsonService::error($bool['msg']);
            exit;
        }

        $result=$CashService->getDistributionMoney($params['money']);
        echo JsonService::success('',$result);
    }
	/**
    *获取验证码
    */
    public function actionVerify($mobile,$type){
        if($mobile==false)exit(JsonService::error());
        $debug=yii::$app->params['app_debug'];
        $return =CommonService::sendMobileVerifyCode($mobile,$type,$debug);
        echo $return?JsonService::success($return):JsonService::error();
    }
}