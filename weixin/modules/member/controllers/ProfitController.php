<?php

namespace weixin\modules\member\controllers;

use Yii;
use yii\web\Controller;
use common\service\ProfitService;
use common\service\MemberService;
use common\service\LevelService;
use common\service\JsonService;
/**
 * MemberController implements the CRUD actions for Member model.
 */
class ProfitController extends Controller
{
    public function behaviors()
    {
        if( !yii::$app->user->identity->id ) $this->redirect(Yii::$app->urlManager->createUrl(['site/index']));
        return [
        ];
    }
    public function actionIndex(){
        $member_id=yii::$app->user->identity->id;
    	$service=new ProfitService();
        $myProfit=$service->getProfit($member_id);
        $params=Yii::$app->request->queryParams;
        $type=$params['type']?$params['type']:1;
    	$list=$service->getAllProfit($member_id,$type);
        $levelService=new LevelService();
        $level=$levelService->getComponentData(1,0);
        if(Yii::$app->request->isAjax){
            $html = $this->renderPartial('_index', ['list' => $list,'level'=>$level], true, false);
            if($html){
                $info='';$list=$html;
            }else{
                $info=yii::t('app_status','empty');
                $list='';
            }
            echo JsonService::success('',$info,$list,'',['page'=>Yii::$app->request->queryParams['page']]);
            exit;
        }




        $memberService= new MemberService();
        //$childrenCount=$memberService->getAllChildren($member_id);   // 显示所有自己下面的所有会员数量
        $oneChildren=$memberService->getNChildren($member_id,1);
        $twoChildren=$memberService->getNChildren($member_id,2);
        $threeChildren=$memberService->getNChildren($member_id,3);
        $childrenCount = $oneChildren[0]['count'] + $twoChildren[0]['count'];  //只显示一，二代会员数量

    	return $this->render('index',['type'=>$type,'list'=>$list,'childrenCount'=>$childrenCount,'one'=>$oneChildren,'two'=>$twoChildren,'three'=>$threeChildren,'money'=>$myProfit['money'],'level'=>$level]);
    }
}