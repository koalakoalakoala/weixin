<?php

namespace weixin\modules\member\controllers;

use common\service\BankService;
use common\service\CommonService;
use common\service\JsonService;
use common\service\MemberMoneyService;
use common\service\MemberService;
use common\service\MoneyCashService;
use common\service\SystemService;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * MemberController implements the CRUD actions for Member model.
 */
class MoneycashController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * 提现列表
     * @return mixed
     */
    public function actionIndex()
    {
        $MoneyCashService = new MoneyCashService();
        $member_id = yii::$app->user->identity->id;
        $list = $MoneyCashService->getList($member_id);
        if (Yii::$app->request->isAjax) {
            $html = $this->renderPartial('_index', ['list' => $list], true, false);
            if ($html) {
                $info = '';
                $list = $html;
            } else {
                $info = yii::t('app_status', 'empty');
                $list = '';
            }
            echo JsonService::success('', $info, $list, '', ['page' => Yii::$app->request->queryParams['page']]);
            exit;
        }
        $model = $MoneyCashService->getModel();
        return $this->render('index', ['model' => $model, 'list' => $list]);
    }

    /**
     *获取金额的处理办法
     */
    public function actionGetmoney()
    {

        $MoneyCashService = new MoneyCashService();
        $params = Yii::$app->request->queryParams;
        $bool = $MoneyCashService->checkMoney($params['money']);
        if ($bool['success'] == 0) {
            echo JsonService::error($bool['msg']);
            exit;
        }

        $result = $MoneyCashService->getDistributionMoney($params['money']);
        echo JsonService::success('', $result);
    }
    public function actionCreate()
    {

        $MoneyCashService = new MoneyCashService();
        $model = $MoneyCashService->getModel();
        $member_id = yii::$app->user->identity->id;
        $post = Yii::$app->request->post();
        if ($post) {
            $result = $MoneyCashService->create($member_id, $post); //提交
            if ($result['success'] == 0) {
                $model = $result['info'];
            } else {
                return $this->redirect(Url::toRoute('balance/index'));
            }
        }
        $memberModel = MemberService::findModelById($member_id, ['member_money']);
        if (count($memberModel->member_money) == 0) {
            $memberMoneyService = new MemberMoneyService();
            $moneyModel = $memberMoneyService->getDefaultModel($member_id);
        } else {
            $moneyModel = $memberModel->member_money;
        }

        $bs = new BankService;
        $bank = $bs->getSelectList();
        $default_bank = $bs->getDefaultBankId();
        $system = SystemService::findModelById();
        $tx_rate = $system['tx_rate'];
        return $this->render('create', compact('memberModel'
            , 'moneyModel', 'bank', 'model', 'tx_rate'
            , 'default_bank'));
    }
    /**
     *获取验证码
     */
    public function actionVerify($mobile)
    {
        if ($mobile == false) {
            exit(JsonService::error());
        }

        $debug = yii::$app->params['app_debug'];
        $return = CommonService::sendMobileVerifyCode($mobile, CommonService::VERIFY_TYPE_CASH, $debug);
        echo $return ? JsonService::success($return) : JsonService::error();
    }
}
