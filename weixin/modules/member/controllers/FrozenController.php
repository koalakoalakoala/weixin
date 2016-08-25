<?php
namespace weixin\modules\member\controllers;

use Yii;
use yii\web\Controller;
use common\models\MoneyLog;
use common\enum\MoneyEnum;
use yii\data\ActiveDataProvider;
use common\service\MemberMoneyService;

/**
 * @author xiaomalover <xiaomalover@gmail.com>
 * 冻结金额相关
 */
class FrozenController extends Controller
{
    /**
     * 列表
     */
    public function actionIndex()
    {
        $query = MoneyLog::find();
        $member_id = Yii::$app->user->id;
        $query->where(['money_type' => MoneyEnum::FRONZE_MONEY
            , 'member_id' => $member_id]);
        $query->orderBy('create_time desc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 8,
                'defaultPageSize' => 8,
                'validatePage' => TRUE,
            ],
        ]);

        $member_id = Yii::$app->user->id;
        $ms = new MemberMoneyService();
        $money = $ms->findModelByMember_id($member_id);

        return $this->render("index", ['dataProvider' => $dataProvider
            , 'money' => $money]);
    }
}
