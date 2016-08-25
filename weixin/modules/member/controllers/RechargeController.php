<?php

namespace weixin\modules\member\controllers;

use Yii;
// use common\models\MoneyLog;
use yii\web\Controller;
// use common\service\MemberMoneyService;
use common\service\RechargeService;
use common\service\MemberService;
use common\service\WeixinService;
use common\service\JsonService;
use common\enum\MoneyEnum;


/**
 * MemberController implements the CRUD actions for Member model.
 */
class RechargeController extends Controller
{
	public function behaviors()
    {
        if( !yii::$app->user->identity->id ) $this->redirect(Yii::$app->urlManager->createUrl(['site/index']));
        return [
        ];
    }

    /**
    *充值支付回调
    */
    public function actionNotice(){


    	$rechargeService=new RechargeService();
    	$result=$rechargeService->update();
    	if($result['success']==1){
    		echo "success";
    	}else{
    		echo "error";
    	}
    	
    }


    /**
	 * 充值支付
	 */
    public function actionIndex(){
    	$member_id = yii::$app->user->identity->id;
		// $memberModel = MemberService::findModelById($member_id,['bind']);
		// $openid=$memberModel->bind->user_id;
		$rechargeService=new RechargeService();
		$post=yii::$app->request->post();
		if($post){
			$result=$rechargeService->create($member_id,$post,MoneyEnum::WEIXIN);
			if($result['success']==1){
				echo (JsonService::success('',$result['info']->attributes));exit;
			}else{
				echo JsonService::error('');exit ;
			}
		}else{
			$sn = Yii::$app->request->queryParams['sn'];
			if(!empty($sn)){
				$result=$rechargeService->toWeixin($sn);
				return $this->render("index",array("jsApiParameters"=>$result['jsApiParameters'],'model'=>$result['model']));
				exit;
			}
			$model=$rechargeService->getModel();
		}
    	return $this->render('index',['model'=>$model,'jsApiParameters'=>0]);
    }
}