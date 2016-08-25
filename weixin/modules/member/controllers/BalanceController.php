<?php

namespace weixin\modules\member\controllers;

use Yii;
use common\models\MoneyLog;
use yii\web\Controller;
use common\service\MemberMoneyService;
use common\service\MoneyLogService;
use common\service\JsonService;
use common\enum\MoneyEnum;
/**
 * MemberController implements the CRUD actions for Member model.
 */
class BalanceController extends Controller
{
    public function behaviors()
    {
        if( !yii::$app->user->identity->id ) $this->redirect(Yii::$app->urlManager->createUrl(['site/index']));
        return [
        ];
    }
    /**
    *   余额列表
    */
    public function actionIndex()
    {   
    	
    	$MoneyLogService=new MoneyLogService();
        $money_type=[
            MoneyEnum::MONEY,
            MoneyEnum::CZ_MONEY
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
        $member_id=yii::$app->user->identity->id;
        
        $moneyLogModel=new MoneyLog;

        $memberMoneyService=new MemberMoneyService();
        $MoneyModel=$memberMoneyService->findModelByMember_id($member_id);
        $money=$memberMoneyService->getMoney('',$member_id);
    	return $this->render('index',['money'=>$money,'model'=>$MoneyModel,'list'=>$list,'moneyLogModel'=>$moneyLogModel]);
    }
}
