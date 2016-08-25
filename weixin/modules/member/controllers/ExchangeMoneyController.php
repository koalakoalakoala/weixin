<?php

namespace weixin\modules\member\controllers;

use common\enum\MoneyEnum;
// use common\models\MoneyLog;
use common\service\JsonService;
use common\service\MemberMoneyService;
use common\service\MoneyLogService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * MemberController implements the CRUD actions for Member model.
 */
class ExchangeMoneyController extends Controller
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

    public function actionIndex()
    {
        $MoneyLogService = new MoneyLogService();
        $money_type = [
            MoneyEnum::EXCHANGE_MONEY,
        ];
        $list = $MoneyLogService->getList($money_type);
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

        $member_id = yii::$app->user->identity->id;
        $memberMoneyService = new MemberMoneyService();
        $MoneyModel = $memberMoneyService->findModelByMember_id($member_id);
        return $this->render('index', ['money' => $MoneyModel, 'list' => $list]);
    }
}
