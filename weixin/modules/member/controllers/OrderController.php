<?php

namespace weixin\modules\member\controllers;

use common\enum\OrderBackEnum;
use common\enum\OrderEnum;
use common\models\Order;
use common\models\OrderBack;
use common\models\OrderGoods;
use common\service\LogService as Log;
use common\service\OrderService;
use common\service\PaymentService;
use common\service\ZdApiService;
use weixin\modules\member\models\OrderBackListSearch;
use weixin\modules\member\models\OrderListSearch;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;

/**
 * MemberController implements the CRUD actions for Member model.
 */
class OrderController extends Controller
{
    public $layout = "/home";

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
     * 我的
     */
    public function actionIndex()
    {
        $searchModel = new OrderListSearch("index");
        //$searchModel->
        $dataProvider = $searchModel->search();
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    /**
     * 待支付
     */
    public function actionWaitPay()
    {
        $searchModel = new OrderListSearch("wait-pay");
        //$searchModel->
        $dataProvider = $searchModel->search();
        return $this->render("wait_pay", ['dataProvider' => $dataProvider]);
    }

    /**
     * 待收货
     */
    public function actionWaitReceive()
    {
        $searchModel = new OrderListSearch("wait-receive");
        $dataProvider = $searchModel->search();
        return $this->render("wait_receive", ['dataProvider' => $dataProvider]);
    }

    /**
     * 待评论
     */
    public function actionWaitComment()
    {
        $searchModel = new OrderListSearch("wait-comment");
        //$searchModel->
        $dataProvider = $searchModel->search();
        return $this->render("wait_comment", ['dataProvider' => $dataProvider]);
    }

    /**
     * 我的退换贷列表
     */
    public function actionMyBack()
    {
        $this->layout = "/home";
        $searchModel = new OrderBackListSearch();
        $dataProvider = $searchModel->search();
        return $this->render("my-back", ['dataProvider' => $dataProvider]);
    }

    /**
     * 退换货
     */
    public function actionReturn()
    {
        if (isset($_GET['order_id']) && isset($_GET['og_id'])) {
            $order = Order::findOne($_GET['order_id']);
            $orderGoods = OrderGoods::findOne($_GET['og_id']);
            //判断是否正在退换货
            $ob = OrderBack::find()->where(['order_id' => $_GET['order_id'], 'sku_id' => $orderGoods->sku_id])->one();
            if ($ob && $ob->handle_status != OrderBackEnum::HANDLE_FINISH) {
                return $this->redirect(['/member/order/index']);
            }
            $params = $params = Yii::$app->request->post();
            if (count($params) > 0) {
                $res = OrderService::returnOrder($params, $order, $orderGoods);
                if ($res) {
                    return $this->redirect('my-back');
                }
            }
            return $this->render('return', compact('order', 'orderGoods'));
        }
    }

    /**
     * ajax 取消订单
     */
    public function actionCancle()
    {
        $params = Yii::$app->request->post();
        if (isset($params['order_id'])) {
            $res = OrderService::cancleOrder($params['order_id']);
            return Json::encode($res);
        } else {
            return Json::encode(['code' => 500, 'msg' => '参数缺失']);
        }
    }

    /**
     * ajax 确认收货
     */
    public function actionEnsure()
    {
        $params = Yii::$app->request->post();
        if (isset($params['order_id'])) {
            $res = OrderService::ensureOrder($params['order_id']);
            if ($res['code'] == 200) {
                $order = $res['order'];
                if ($order->give_golds > 0) {
                    //报单
                    $data = [
                        'sn' => $order->sn,
                        'member_id' => $order->member->mobile,
                        'itemMoney' => $order->price,
                        'backMoney' => $order->give_golds,
                        'money' => $order->price,
                    ];
                    $bd = new ZdApiService;
                    $bdRes = $bd->zdCreateOrder($data);
                    if ($bdRes['state']) {
                        $order->bd_status = OrderEnum::BD_SUCCESS;
                        $order->save();
                    } else {
                        $order->bd_status = OrderEnum::BD_FAIL;
                        $order->save();
                        Log::log('bd_fail.log',
                            'Order_id: ' . $order->sn . '; Code: ' . $bdRes['code'] . '; Msg:' . $bdRes['msg']);
                    }
                }
            }
            return Json::encode($res);
        } else {
            return Json::encode(['code' => 500, 'msg' => '参数缺失']);
        }
    }

    /**
     * ajax 换货商品确认收货
     */
    public function actionChangeEnsure()
    {
        $params = Yii::$app->request->post();
        if (isset($params['back_id'])) {
            $res = OrderService::ensureChangeGoods($params['back_id']);
            return Json::encode($res);
        } else {
            return Json::encode(['code' => 500, 'msg' => '参数缺失']);
        }
    }

    /**
     * 退款，订单在已付款待审核和待发货状态都可以直接退款
     */
    public function actionBackMoney()
    {
        $params = Yii::$app->request->post();
        if (isset($params['order_id'])) {
            $res = PaymentService::backMoney($params['order_id']);
            return Json::encode($res);
        } else {
            return Json::encode(['code' => 500, 'msg' => '参数缺失']);
        }
    }

    /**
     * 订单详情
     */
    public function actionDetail()
    {
        if (isset($_GET['id'])) {
            $this->layout = "/home";
            $model = Order::findOne($_GET['id']);
            return $this->render("detail", ['model' => $model]);
        }
    }
}
