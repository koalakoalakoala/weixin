<?php

namespace weixin\modules\order\controllers;

use common\enum\OrderEnum;
use common\extension\wxpay\Notify;
use common\models\Member;
use common\models\MemberMoney;
use common\models\Order;
use common\service\MemberService;
use common\service\PaymentService;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\log\FileTarget;
use yii\log\Logger;
use yii\web\Controller;

/**
 * 订单支付逻辑处理
 */
class PaymentController extends Controller
{
    //不关闭无法接收回调参数
    public function beforeAction($action)
    {
        if ($action->id == 'wxpay') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

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
                        'actions' => ['wxpay'],
                        'allow' => true,
                    ],
                    [
                        'actions' => [
                            'index',
                            'balapay',
                            'success',
                            'fail',
                            'exchange',
                            'exchange-fail',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'wxpay' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        if (isset($_GET['order_id'])) {
            //查询订单，看是否为未支付订单
            $order = PaymentService::getUnPayOrder($_GET['order_id']);
            if (!$order) {
                //没有找到待支付订单的处理
                $this->redirect(['/goods/goods/index']);
            }

            if ($order->type == OrderEnum::TYPE_EXCHANGE) {
                //兑换订单支付页
                $this->redirect(['exchange', 'order_id' => $_GET['order_id']]);
            }

            $memberMoney = MemberMoney::find()->where(['member_id' => Yii::$app->user->id])->one();
            //目前没有用微信，到进取消注释就好
            $jsApiParameters = [];

            //获取微信预支付订单号，供用户微信支付使用
            //            $openid = $this->getOpenid();
            //            $jsApiParameters = PaymentService::wxPayGetJsApiParameters($openid, $_GET['order_id']);

            return $this->render('index', compact( /*'jsApiParameters',*/'order', 'memberMoney'));
        }
    }

    /**
     * 微信支付回调
     */
    public function actionWxpay()
    {

        //使用通用通知接口
        $notify = new Notify();

        //存储微信的回调
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $notify->saveData($xml);

        //验证签名，并回应微信。
        //对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
        //微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
        //尽可能提高通知的成功率，但微信不保证通知最终能成功。
        if ($notify->checkSign() == false) {
            $notify->setReturnParameter("return_code", "FAIL"); //返回状态码
            $notify->setReturnParameter("return_msg", "签名失败"); //返回信息
        } else {
            $notify->setReturnParameter("return_code", "SUCCESS"); //设置返回码
        }
        $returnXml = $notify->returnXml();
        echo $returnXml;

        //==商户根据实际情况设置相应的处理流程=======
        if ($notify->checkSign() == true) {
            if ($notify->data["return_code"] == "FAIL") {
                $this->logResult("【通信出错】:\n" . $xml . "\n", Logger::LEVEL_WARNING);
            } elseif ($notify->data["result_code"] == "FAIL") {
                $this->logResult("【业务出错】:\n" . $xml . "\n", Logger::LEVEL_WARNING);
            } else {
                //此处应该更新一下订单状态，商户自行增删操作
                $this->logResult("【支付成功】:\n" . $xml . "\n", Logger::LEVEL_INFO);
                $arr = (Array) simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
                $total_fee = $arr['total_fee'] / 100; //把分的单位转成元
                $out_trade_no = $arr['out_trade_no'];
                $transaction_id = $arr['transaction_id'];
                PaymentService::handleWxpayBack($total_fee, $out_trade_no, $transaction_id);
            }
        }

    }

    /**
     * 记录微信支付的日志
     */
    private function logResult($word, $level)
    {
        $time = microtime(true);
        $log = new FileTarget();
        $log->logFile = Yii::$app->getRuntimePath() . '/logs/wxpay.log';
        $log->messages[] = [$word, $level, 'wxpay', $time];
        $log->export();
    }

    /**
     * 支付输入密码页面
     */
    public function actionBalapay()
    {
        if (isset($_POST['zfpwd']) && isset($_POST['order_id']) && isset($_POST['type']) && $_POST['zfpwd'] && $_POST['order_id'] && $_POST['type']) {
            //查看订单，是否为未支付
            $order = PaymentService::getUnPayOrder($_POST['order_id']);
            if ($order) {
                if ($order->member->zf_pwd == md5($_POST['zfpwd'])) {
                    $res = PaymentService::balancePay($_POST['order_id'], $_POST['type']);
                    return Json::encode($res);
                } else {
                    return Json::encode(["code" => 500, "msg" => "支付密码错误"]);
                }
            } else {
                return Json::encode(["code" => 500, "msg" => " 订单不存在或已支付"]);
            }
        } else {
            return Json::encode(["code" => 500, "msg" => "参数缺失"]);
        }
    }

    /**
     * 支付成功回调页
     */
    public function actionSuccess()
    {
        return $this->render('success');
    }

    /**
     * 支付失败
     */
    public function actionFail()
    {
        $params = Yii::$app->request->get();
        if (isset($params['order_id']) && isset($params['msg'])) {
            return $this->render(
                'fail',
                [
                    'order_id' => $params['order_id'],
                    'msg' => $params['msg'],
                ]
            );
        }
    }

    /**
     * 兑换支付失败
     */
    public function actionExchangeFail()
    {
        $params = Yii::$app->request->get();
        if (isset($params['msg'])) {
            return $this->render(
                'exchange-fail',
                [
                    'msg' => $params['msg'],
                    'order_id' => $params['order_id'],
                ]
            );
        }
    }

    /**
     * 取得用户openid
     */
    private function getOpenid()
    {
        //$openid = 'oVnucwhGeEsY-2UZSP04px2AUI9s';
        $openid = Yii::$app->session['openid'];
        return $openid;
    }

    public function actionExchange()
    {
        if (isset($_GET['order_id'])) {
            //查询订单，看是否为未支付订单
            $order = PaymentService::getUnPayOrder($_GET['order_id']);
            if (!$order) {
                //没有找到待支付订单的处理
                $this->redirect(['/goods/goods/index']);
            }

            if ($order->type != OrderEnum::TYPE_EXCHANGE) {
                //普通订单回普通支付页
                $this->redirect(['index', 'order_id' => $_GET['order_id']]);
            }

            $params = Yii::$app->request->post();
            if (isset($params['order_id'])) {
                $res = PaymentService::ExchangePay($params['order_id']);
                if ($res['code'] == 200) {
                    return $this->redirect(['/order/payment/success']);
                } else {
                    return $this->redirect([
                        '/order/payment/exchange-fail',
                        'msg' => $res['msg'],
                        'order_id' => $order->id,
                    ]);
                }
            }

            $exchange = MemberService::getExchange(Yii::$app->user->id);

            return $this->render('exchange', compact('order', 'exchange'));
        }
    }
}
