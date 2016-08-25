<?php
namespace weixin\controllers;

use yii\web\Controller;
use common\service\PaymentService;

/**
 * Site controller
 */
class TestController extends Controller
{
    public function actionIndex()
    {
         $res = PaymentService::backMoney(164);
        print_r($res);
    }
}
