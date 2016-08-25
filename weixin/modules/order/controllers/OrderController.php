<?php

namespace weixin\modules\order\controllers;

use common\enum\OrderEnum;
use common\models\DeliveryAddress;
use common\models\Order;
use common\models\Sku;
use common\models\Store;
use common\service\OrderService;
use common\service\SkuService;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/*
 * MemberController implements the CRUD actions for Member model.
 */
class OrderController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
//                    [
                    //                        'actions' => ['index'],
                    //                        'allow' => true,
                    //                    ],
                    [
                        'actions' => [
                            'buy-now',
                            'select-addr',
                            'create-buy-now-order',
                            'index',
                            'create-order',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * 确认订单页
     */
    public function actionIndex()
    {
        /*if(!Yii::$app->user->isGuest)
        {*/
        if (isset($_GET['sku_ids'])) {

            //更新购物车里的商品信息
            $this->refreshGoods();

            $identity = Yii::$app->user->identity;

            //传入地址id
            $address_id = null;
            if (isset($_GET['address_id'])) {
                $address_id = $_GET['address_id'];
            }

            $addr = OrderService::getMemberAddr($this->getLoginMemberId(), $address_id);
            $positions = OrderService::getSelectedItems(explode(",", $_GET['sku_ids']));

            $address_null = null;
            if (!$addr) {
                $address_null = null;
            } else {
                $address_null = "tjdd-top-none";
            }

            $sku_id = $_GET['sku_ids'];

            if (!$positions) {
                return $this->redirect(['/member/order/index']);
            }
            return $this->render('index', compact('addr', 'positions', 'address_null', 'sku_id'));
        }
        /*} else {
    return $this->redirect('/site/login');
    }*/
    }

    /**
     * 立即购买订单确认页
     */
    public function actionBuyNow()
    {
        //获取当前用户的默认收获地址
        $address_id = null;
        if (isset($_GET['address_id'])) {
            $address_id = $_GET['address_id'];
        }

        $addr = OrderService::getMemberAddr($this->getLoginMemberId(), $address_id);
        if (isset($_GET['sku_id']) && isset($_GET['num']) && $_GET['sku_id'] && $_GET['num']) {
            $sku = Sku::findOne($_GET['sku_id']);
            $num = $_GET['num'];

            //取sku的属性name value
            $sku_attrs = SkuService::searchSkuAttrNameValue($sku);

            $address_null = null;
            if (!$addr) {
                $address_null = null;
            } else {
                $address_null = "tjdd-top-none";
            }

            return $this->render('buy-now', compact('sku', 'addr', 'num', 'sku_attrs', 'address_null'));
        }
    }

    /**
     * 选择收货地址
     */
    public function actionSelectAddr()
    {
        $from_url = Yii::$app->request->getReferrer();
        //将来源地址存入session，以供选择完地址跳回使用
        $user_id = $this->getLoginMemberId();
        Yii::$app->session['from_url_' . $user_id] = $from_url;
        //查询用户有没有收货地址
        $addr = DeliveryAddress::find()->where(['member_id' => $user_id, 'is_del' => 0])->one();

        $sku_ids = $_GET['sku_ids'];

        //地址库没有，进入增加页面
        if (!$addr) {
            return $this->redirect(['/member/address/create']);
        } else {
            return $this->redirect(array('/member/address/choice?sku_ids=' . $sku_ids));
        }
    }

    /**
     * 生成订单
     */
    public function actionCreateOrder()
    {
        if (Yii::$app->cart->isEmpty) {
            return Json::encode(['code' => 500, 'msg' => '购物车没有商品']);
        } else {
            $params = Yii::$app->request->post();
            if (isset($params['address_id']) && $params['address_id'] && isset($params['sku_ids']) && $params['sku_ids'] && isset($params['quan_sku_ids'])) {
                $member_id = $this->getLoginMemberId();
                $order_res = OrderService::createOrder($params['address_id'], $member_id, explode(",", $params['sku_ids']), $params['quan_sku_ids']);
                return json_encode($order_res);
            } else {
                return Json::encode(['code' => 500, 'msg' => '收货地址参数丢失或未选择结算商品']);
            }
        }

    }

    /**
     * 立即购买生成订单
     */
    public function actionCreateBuyNowOrder()
    {
        $params = Yii::$app->request->post();
        if (isset($params['address_id']) && isset($params['sku_id']) && isset($params['num']) && $params['address_id'] && $params['sku_id'] && $params['num'] && isset($params['quan'])) {
            $member_id = $this->getLoginMemberId();
            $order_res = OrderService::createBuyNowOrder($params['address_id'], $member_id, $params['sku_id'], $params['num'], $params['quan']);
            return json_encode($order_res);
        } else {
            return Json::encode(['code' => 500, 'msg' => '请添加收货地址']);
        }
    }

    /**
     * 订单生成成功，待支付页
     */
    public function actionPrePay()
    {
        //获取用户未支付订单
        $orders = Order::find()->where(['member_id' => $this->getLoginMemberId(), 'orderstatus' => OrderEnum::WAITING_PAYMENT])->orderBy("id desc")->all();
        if ($orders) {
            return $this->render("pre-pay", compact('orders'));
        } else {
            return $this->redirect(['/goods/goods/index']);
        }
    }

    /**
     * 获取当前登录用户的id
     */
    private function getLoginMemberId()
    {
        return Yii::$app->user->id;
    }

    /**
     * 更新购物车中的商品
     */
    public function refreshGoods()
    {
        $cart = Yii::$app->cart;
        $list = $cart->positions;
        if (count($list)) {
            //首先获取sku的id，和店铺id，以便下面一起查询
            $sku_ids = [];
            $store_ids = [];
            foreach ($list as $k => $v) {
                //遍历以获取sku的id
                foreach ($v['goods'] as $k1 => $v1) {
                    $sku_ids[] = $k1;
                }
                //店铺id
                $store_ids[] = $v['store']['id'];
            }

            //重新查询sku和店铺
            $skus = Sku::find()->where(['in', 'sku_id', $sku_ids])->all();
            $stores = Store::find()->where(['in', 'id', $store_ids])->all();

            foreach ($list as $k => $v) {
                //更新商品信息
                $new_sku = $new_store = null;
                foreach ($v['goods'] as $k1 => $v1) {
                    $quantity = $v1->quantity;
                    foreach ($skus as $v2) {
                        if ($v2->sku_id == $k1) {
                            $new_sku = $v2;
                        }
                    }
                    $new_sku->quantity = $quantity;
                    $list[$k]['goods'][$k1] = $new_sku;
                }
                //更新店铺信息
                $store = Store::findOne($v['store']['id']);
                foreach ($stores as $v3) {
                    if ($v3->id == $v['store']['id']) {
                        $new_store = $v3;
                    }
                }
                $list[$k]['store'] = $new_store;
            }
        }
        $cart->setPositions($list);
    }

    /**
     * Finds the SkuActivity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SkuActivity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findSku($id)
    {
        if (($model = Sku::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
