<?php
namespace weixin\controllers;

use common\enum\OrderEnum;
use common\extension\Tools;
use common\models\Order;
use common\service\OrderService;
use weixin\models\HrPay;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use common\models\OrderBank;

/**
 * Site controller
 * @author xiaomalover <xiaomalover@gmail.com>
 */
class HrController extends Controller
{
    public $layout = 'home';
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
                            'select',
                            'bc-pay',
                            'cc-pay',
                            'get-verify',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * 信用卡银行卡选择界面
     */
    public function actionSelect()
    {
        $params = Yii::$app->request->get();
        if (isset($params['order_id'])) {
            $order = Order::findOne([
                'orderstatus' => OrderEnum::WAITING_PAYMENT,
                'id' => $params['order_id'],
                'hr_paid' => 0,
            ]);
            if ($order) {
                return $this->render("select", [
                    'order' => $order,
                ]);
            } else {
                header("Content-type:text/html;charset=utf-8");
                die("订单不存在或已经支付");
            }
        }
    }

    /**
     * 银行卡支付
     */
    public function actionBcPay()
    {
        $params = Yii::$app->request->get();
        if (isset($params['order_id'])) {
            $order = Order::findOne([
                'orderstatus' => OrderEnum::WAITING_PAYMENT,
                'id' => $params['order_id'],
                'hr_paid' => 0,
            ]);
            if ($order) {
                $model = new HrPay;
                $posts = Yii::$app->request->post();
                if ($model->load($posts) && $model->validate()) {
                    $res = Yii::$app->hrpay->pay(
                        $posts['hrSn'],
                        $model->verifyCode,
                        $posts['price'],
                        $posts['goodsName'],
                        date("YmdHis"),
                        $model->cardNo,
                        $model->name,
                        $model->idCard,
                        $model->mobile
                    );
                    if ($res['code'] == 200) {
                        //同步回调成功，改华融支付为已支付
                        //以免重复支付
                        $order->hr_paid = 1;
                        $order->save(false);
                        $this->saveBankInfo(
                            $order->id,
                            $model->cardNo,
                            $model->name,
                            $model->mobile,
                            '0'
                        );
                        return $this->redirect(['/order/payment/success']);
                    } else {
                        //验证码不匹配，不跳页面当页展示错误
                        //余额不足其它错误跳转页面
                        if ($res['msg'] == '验证码不匹配') {
                            $model->addError('verifyCode', $res['msg']);
                        } else {
                            return $this->redirect([
                                '/order/payment/fail',
                                'order_id' => $order->id,
                                'msg' => $res['msg'],
                            ]);
                        }
                    }
                }
                $goods_name = OrderService::getOrderGoods($order->id);
                //华融支付每次要生成订单号

//              $order->hr_sn = Tools::generateSn('HR', 20);
                $goods_name = OrderService::getOrderGoods($order->id);
                $order->hr_sn = Tools::generateSn('HR', 20);
                if ($order->save()) {
                    return $this->render('bc-pay', compact(
                        'order',
                        'goods_name',
                        'model')
                    );
                }
            } else {
                header("Content-type:text/html;charset=utf-8");
                die("订单不存在或已经支付");
            }
        }
    }

    /**
     * 信用卡支付
     */
    public function actionCcPay()
    {
        $params = Yii::$app->request->get();
        if (isset($params['order_id'])) {
            $order = Order::findOne([
                'orderstatus' => OrderEnum::WAITING_PAYMENT,
                'id' => $params['order_id'],
                'hr_paid' => 0,
            ]);
            if ($order) {
                $model = new HrPay;
                $model->setScenario('ccPay');
                $posts = Yii::$app->request->post();
                if ($model->load($posts) && $model->validate()) {
                    $res = Yii::$app->hrpay->pay(
                        $posts['hrSn'],
                        $model->verifyCode,
                        $posts['price'],
                        $posts['goodsName'],
                        date("YmdHis"),
                        $model->cardNo,
                        $model->name,
                        $model->idCard,
                        $model->mobile,
                        '1',
                        $model->cvv2,
                        $model->month,
                        $model->year
                    );
                    if ($res['code'] == 200) {
                        //同步回调成功，改华融支付为已支付
                        //以免重复支付
                        $order->hr_paid = 1;
                        $order->save(false);
                        $this->saveBankInfo(
                            $order->id,
                            $model->cardNo,
                            $model->name,
                            $model->mobile,
                            '1'
                        );
                        return $this->redirect(['/order/payment/success']);
                    } else {
                        //验证码不匹配，不跳页面当页展示错误
                        //余额不足其它错误跳转页面
                        if ($res['msg'] == '验证码不匹配') {
                            $model->addError('verifyCode', $res['msg']);
                        } else {
                            return $this->redirect([
                                '/order/payment/fail',
                                'order_id' => $order->id,
                                'msg' => $res['msg'],
                            ]);
                        }
                    }
                }
                $goods_name = OrderService::getOrderGoods($order->id);
                //华融支付每次要生成订单号
                $order->hr_sn = Tools::generateSn('HR', 20);
                if ($order->save()) {
                    return $this->render('cc-pay', compact(
                        'order',
                        'goods_name',
                        'model')
                    );
                }
            } else {
                header("Content-type:text/html;charset=utf-8");
                die("订单不存在或已经支付");
            }
        }
    }

    /**
     * ajax获取验证码
     */
    public function actionGetVerify()
    {
        $params = Yii::$app->request->post();
        if (isset($params['mobile']) &&
            isset($params['hrSn']) &&
            isset($params['price']) &&
            isset($params['goodsName'])
        ) {
            $mobile = $params['mobile'];
            $hrSn = $params['hrSn'];
            $price = $params['price'];
            $goodsName = $params['goodsName'];
            $canSend = !Yii::$app->session->get('hr_pay_' . $mobile)
                || (time() - Yii::$app->session->get('hr_pay_' . $mobile) > 60);
            if ($canSend) {
                $res = Yii::$app->hrpay->getVerifyCode(
                    $mobile,
                    $hrSn,
                    $price,
                    $goodsName
                );
                if ($res) {
                    Yii::$app->session->set('hr_pay_' . $mobile, time());
                    $res = ['code' => 200, 'msg' => '验证码发送成功！'];
                } else {
                    $res = ['code' => 500, 'msg' => '验证码发送失败，请稍候再试。'];
                }
            } else {
                $res = ['code' => 500, 'msg' => '请过60秒后再试'];
            }
        } else {
            $res = ['code' => 500, 'msg' => '参数缺失'];
        }
        return Json::encode($res);
    }

    /**
     * 存银行卡信息
     */
    private function saveBankInfo($order_id, $cardNo, $name, $mobile, $type)
    {
        $ob = new OrderBank;
        $ob->order_id = $order_id;
        $ob->card_no = $cardNo;
        $ob->name = $name;
        $ob->mobile = $mobile;
        $ob->type = $type;
        $ob->save();
    }
}
