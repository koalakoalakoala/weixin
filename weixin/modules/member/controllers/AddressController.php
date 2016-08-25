<?php

namespace weixin\modules\member\controllers;

use common\models\DeliveryAddress;
// use common\models\Member;
// use common\models\MemberInfo;
// use common\models\MoneyLog;
// use weixin\modules\member\models\AddressSearch;
use common\models\Region;
use common\service\AddressService;
// use yii\web\NotFoundHttpException;
// use yii\filters\VerbFilter;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\filters\AccessControl;

// use common\service\JsonService;
// use common\enum\MoneyEnum;
/**
 * MemberController implements the CRUD actions for Member model.
 */
class AddressController extends Controller
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
     *设置默认地址
     */
    public function actionSetdefault($id)
    {
        $model = DeliveryAddress::findOne($id);
        $model->is_default = 1;
        $model->save();
        DeliveryAddress::updateAll(['is_default' => 0], ['<>', 'id', $model->id]);
        return $this->redirect(Yii::$app->request->referrer);
    }
    /**
     *删除地址
     */
    public function actionDelete()
    {
        $params = Yii::$app->request->post();
        $address = new AddressService();
        if ($params['id']) {
            $res = $address->delete($params['id']);
            if ($res) {
                return Json::encode(['code' => '200', 'msg' => '删除成功']);
            } else {
                return Json::encode(['msg' => '删除失败']);
            }
        }
    }

    /**
     *   地址列表
     */
    public function actionIndex()
    {
        $model = AddressService::getList();

        //处理购物时的逻辑，如果是从购物过程中来，则处理完地址，跳回购物
        $ref = Yii::$app->request->getReferrer();
        //如果从个人中心修改，若用户还残留购物时的from_url的session，则清空
        if (strpos($ref, "member/info/index") && isset(Yii::$app->session['from_url_' . Yii::$app->user->id])) {
            unset(Yii::$app->session['from_url_' . Yii::$app->user->id]);
        }

        //从订单页传递sku_id值

        $sku_id = null;
        if (isset($_GET['sku_id'])) {
            $sku_id = $_GET['sku_id'];
        }

        return $this->render('index', ['list' => $model, 'sku_id' => $sku_id]);
    }
    /**
     *选择地址
     *
     */
    public function actionChoice($sku_ids)
    {

        $model = AddressService::getList();

        //处理购物时的逻辑，如果是从购物过程中来，则处理完地址，跳回购物
        $ref = Yii::$app->request->getReferrer();
        //如果从个人中心修改，若用户还残留购物时的from_url的session，则清空
        if (strpos($ref, "member/info/index") && isset(Yii::$app->session['from_url_' . Yii::$app->user->id])) {
            unset(Yii::$app->session['from_url_' . Yii::$app->user->id]);
        }

        //从订单页传递sku_id值
        $from_url = isset(Yii::$app->session['from_url_' . Yii::$app->user->id]) ? Yii::$app->session['from_url_' . Yii::$app->user->id] : '';

        //获取用户选择地址的id
        $selected_address_id = 0;
        preg_match('/(&|\?)address_id=[^&]+/', $from_url, $slt);
        if (isset($slt[0])) {
            $tmp = explode("=", $slt[0]);
            if (isset($tmp[1])) {
                $selected_address_id = $tmp[1];
            }

        }

        $from_url = preg_replace('/(&|\?)address_id=[^&]+/', '', $from_url);

        $sku_id = null;
        if (isset($_GET['sku_ids'])) {
            $sku_id = $_GET['sku_ids'];
        }

        return $this->render('choice', ['list' => $model, 'sku_ids' => $sku_id, 'from_url' => $from_url, 'selected_address_id' => $selected_address_id]);

        // return $this->redirect(array('/order/order/index?sku_ids='.$sku_id&));
    }

    /**
     *   新增地址
     */
    public function actionCreate()
    {
        $model = new DeliveryAddress();
        $params = Yii::$app->request->post();
        $model->member_id = Yii::$app->user->id;
        $model->create_time = time();
        if ($model->load($params) && $model->save()) {
            if ($model->is_default) {
                DeliveryAddress::updateAll(['is_default' => 0], ['<>', 'id', $model->id]);
            }
            $sku_id = Yii::$app->request->post()['DeliveryAddress']['sku_id'];

            return $this->redirect('index?sku_id=' . $sku_id);
        }

        $sku_id = null;
        if (isset($_GET['sku_id'])) {
            $sku_id = $_GET['sku_id'];
        }

        return $this->render('create', ['model' => $model, 'sku_id' => $sku_id]);
    }

    /**
     *修改地址
     */
    public function actionUpdate($id)
    {

        $AddressService = new AddressService();
        $model = $AddressService->findModelById($id);
        if (Yii::$app->request->post()) {
            // $is_default=Yii::$app->request->post('is_default');
            $is_default = Yii::$app->request->post('is_default');
            $model->is_default = $is_default ? 1 : 0;
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if ($model->is_default) {
                DeliveryAddress::updateAll(['is_default' => 0], ['<>', 'id', $model->id]);
            }

            $sku_id = Yii::$app->request->post()['DeliveryAddress']['sku_id'];

            return $this->redirect('index?sku_id=' . $sku_id);
        } else {
            if (count($model->errors)) {
                print_r($model->errors);
            }

        }

        $sku_id = null;
        if (isset($_GET['sku_id'])) {
            $sku_id = $_GET['sku_id'];
        }

        return $this->render('update', ['model' => $model, 'sku_id' => $sku_id]);
    }

    /**
     * 获取省信息
     */
    public function actionGetProvince()
    {
        $provinces = Region::find()->select(['code', 'name'])->where(['level' => 1])->all();

        $str_start = "<div class='add-cont' style=''><ul>";
        $str_end = "</ul></div>";
        $str_li = '';
        foreach ($provinces as $v) {
            $str_li .= "<li onclick='getCity(" . $v->code . ", \"" . $v->name . "\")'>" . $v->name . "</li>";
        }
        $str = $str_start . $str_li . $str_end;
        print_r($str);
    }

    /**
     * 获取市信息
     */
    public function actionGetCity()
    {
        $provinces = Region::find()->select(['code', 'name'])->where(['parent_code' => $_GET['code']])->all();

        $str_start = "<ul>";
        $str_end = "</ul>";
        $str_li = '';
        foreach ($provinces as $v) {
            $str_li .= "<li onclick='getArea(" . $v->code . ", \"" . $v->name . "\")'>" . $v->name . "</li>";
        }
        $str = $str_start . $str_li . $str_end;
        print_r($str);
    }

    /**
     * 获取地区信息
     */
    public function actionGetArea()
    {
        $provinces = Region::find()->select(['code', 'name'])->where(['parent_code' => $_GET['code']])->all();

        $str_start = "<ul>";
        $str_end = "</ul>";
        $str_li = '';
        foreach ($provinces as $v) {
            $str_li .= "<li onclick='setAddress(" . $v->code . ", \"" . $v->name . "\")'>" . $v->name . "</li>";
        }
        $str = $str_start . $str_li . $str_end;
        print_r($str);
    }
}
