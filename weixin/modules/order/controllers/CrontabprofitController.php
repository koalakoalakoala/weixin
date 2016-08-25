<?php

namespace weixin\modules\order\controllers;

use common\enum\OrderEnum;
use common\models\Order;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use common\service\ProfitService;
use common\enum\OrderBackEnum;
use common\service\OrderService;
use common\models\OrderBack;
/**
 * MemberController implements the CRUD actions for Member model.
 */
class CrontabprofitController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return false;
    }

    /**
     * 执行分润
     */
    public function actionGetprofitinfo(){
        /**
         * 查找订单表获取预分润用户和金额
         */
        $ready_profit_members = Order::find()->select("member_id,price,sn,orderstatus,profit")
            ->andWhere(["=","profit_status",0])
            ->andWhere(["in","orderstatus",OrderEnum::ALREADY_PAYMENT])
            ->asArray()->all();

        $params = [];
        if(!empty($ready_profit_members)){
            foreach ($ready_profit_members as $val) {
                $profit_service = new ProfitService($val['member_id'], $val['profit']);
                $params['sn']=$val['sn'];
                $params['from_mid']=$val['member_id'];
                $profit_service->dispatchProfit()->dispatchAward()->insert($params);
            }
        }else
            echo '当前没有可以执行预分润的订单!'.'</br>';

        /**
         * 获取可以实际分润的订单
         */
        $profit_orders= Order::find()->select("member_id,price,sn,orderstatus,profit")
            ->andWhere(["=","profit_status",2])
            ->andWhere(["=","orderstatus",OrderEnum::FINISHED])
            ->asArray()->all();
        if(!empty($profit_orders)){
            $profit_service = new ProfitService();
            foreach ($profit_orders as  $val) {
                $params['sn']=$val['sn'];
                $params['from_mid']=$val['member_id'];
                /**
                 * 执行实际分润
                 */
                $profit_service->update($params);
            }
        }else
            echo '当前没有可以执行分润的订单 !'.'</br>';
        return false;
    }


    /**
     * 15天定时完成订单脚本
     */
    public function actionAutoEnsureOrder()
    {
        $ago = time() - 15*24*3600;
        //换货订单自动确认收货
        $order_back_list = OrderBack::find()->where(['handle_status' => OrderBackEnum::HANDLE_WAIT_RECEIVE])->andWhere(["<","ex_time",$ago])->all();
        if($order_back_list){
            foreach($order_back_list as $k => $v){
                $res = OrderService::ensureChangeGoods($v->id);
                if($res['code'] == 200){
                    echo "换货订单：".$v->id."自动确认收货成功<br/>".chr(10);
                }else{
                    echo "换货订单：".$v->id."自动确认收货失败，原因：".$res['msg']."<br/>".chr(10);
                }
            }
        }else{
            echo "暂无15天待确认换货订单<br/>".chr(10);
        }

        //订单自动确认收货
        $order_list = Order::find()->where(['orderstatus' => OrderEnum::WAITING_RECEVE])->andWhere(["<","delivery_time",$ago])->all();
        if($order_list){
            foreach($order_list as $k1 => $v1){
                $res1 = OrderService::ensureOrder($v1->id);
                if($res1['code'] == 200){
                    echo "订单：".$v1->sn."自动确认收货成功<br/>".chr(10);
                }else{
                    echo "订单：".$v1->sn."自动确认收货失败，原因：".$res1['msg']."<br/>".chr(10);
                }
            }
        }else{
            echo "暂无15天待确认订单<br/>".chr(10);
        }
    }

    /**
     * 24小时未支付自动取消订单
     */
    public function actionCancleOrder()
    {
        $ago = time() - 24*3600;
        $order_list = Order::find()->where(['orderstatus' => OrderEnum::WAITING_PAYMENT])->andWhere(["<","create_time",$ago])->all();
        if($order_list){
            foreach($order_list as $k => $v){
                $v->orderstatus = OrderEnum::CANCELD;
                if($v->save()){
                    echo "订单:".$v->sn."取消成功<br/>".chr(10);
                }else{
                    echo "订单:".$v->sn."取消失败<br/>".chr(10);
                }
            }
        }else{
            echo "暂无待取消订单<br/>".chr(10);
        }
    }

}


