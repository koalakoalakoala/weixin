<?php
namespace weixin\controllers;

use common\service\LogService as Log;
use common\service\PaymentService;
use Yii;
use yii\web\Controller;

/**
 * Notify controller
 */
class NotifyController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * 华融支付回调
     */
    public function actionHr()
    {
        $post = $_POST;

        if (isset($post['Prdordno'])) {
            //处理订单逻辑
            $hrSn = $post['Prdordno'];
            $payOrdNo = $post['payOrdNo'];
            $status = $post['ordStatus'];
            $ordAmt = $post['ordAmt'] / 100; //化分为元
            //扣款成功为1
            if ($status == 1) {
                PaymentService::handleHrBack($hrSn, $payOrdNo, $ordAmt);
            }
            //获取响应数据;
            $replyData = Yii::$app->hrpay->getNotifyData($post);
            //输出xml响应华融支付
            echo $replyData;

            //记录日志
            Log::log('hr_pay_success.log', $replyData);
        }
    }
}
