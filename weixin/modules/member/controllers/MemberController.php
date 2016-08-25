<?php

namespace weixin\modules\member\controllers;

use common\models\Collect;
use common\models\Member;
use common\models\Store;
use common\models\Withdraw;
use common\service\CommonService;
use common\service\GoodsService;
use common\service\JsonService;
use common\service\LogService as Log;
use common\service\MemberMoneyService;
use common\service\MemberService;
use common\service\OrderService;
// use yii\helpers\Json;
use common\service\RegisterService;
use common\service\ZdApiService;
use weixin\models\LoginForm;
use weixin\models\RegisterForm;
use weixin\modules\member\models\PayPassBackForm as BackForm;
use Yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Session;

/**
 * MemberController implements the CRUD actions for Member model.
 */
class MemberController extends Controller
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
                            'index',
                            'login',
                            'register',
                            'forget',
                            'get-verify',
                            'agreement',
                        ],
                        'allow' => true,
                    ],
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
     * 后台主页
     * @return mixed
     */
    public function actionIndex()
    {
        $order_count = OrderService::getOrderCount(Yii::$app->user->id);
        $member_id = yii::$app->user->id;
        $model = MemberService::findModelById($member_id, ['levels', 'member_info']);
        if ($model && $model->store_id > 0) {
            $store = Store::findOne($model->store_id);
        } else {
            $store = '';
        }
        $memberMoneyService = new MemberMoneyService();
        $MoneyModel = $memberMoneyService->findModelByMember_id($member_id);
        return $this->render('index', ['model' => $model, 'moneyModel' => $MoneyModel, 'order_count' => $order_count, 'store' => $store]);
    }

    /**
     *setting设置页
     */
    public function actionSetting()
    {
        $service = new MemberService();
        $model = $service->getModel();
        return $this->render('setting', ['model' => $model]);
    }
    /**
     * 设置密码前验证手机
     */
    public function actionZfpwd()
    {
        $service = new MemberService();
        $member_id = yii::$app->user->identity->id;
        $post = Yii::$app->request->post();
        if ($post) {
            $result = $service->updateZfpwd($member_id, $post); //提交
            if ($result['success'] == 0) {
                $model = $result['info'];
            } else {
                return $this->redirect(Url::toRoute('setting'));
            }
        } else {
            $model = $service->findModelById($member_id);
        }

        return $this->render('zfpwd', ['model' => $model]);
    }
    public function actionPassword()
    {
        $service = new MemberService();
        $member_id = yii::$app->user->identity->id;
        $post = Yii::$app->request->post();
        if ($post) {
            $result = $service->updatePassword($member_id, $post); //提交
            if ($result['success'] == 0) {
                $model = $result['info'];
            } else {
                return $this->redirect(Url::toRoute('setting'));
            }
        } else {
            $model = $service->findModelById($member_id);
        }

        return $this->render('password', ['model' => $model]);
    }

    /**
     * 设置支付密码
     */
    public function actionSetPayPass()
    {
        //实例化表单模型，将场景设置为set
        $model = new BackForm();
        $model->setScenario('set');
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            //获取当前登录用户的帐户
            $member = $this->getMember();
            if ($member) {
                $member->zf_pwd = md5($model->password); //修改帐户的支付密码
                if ($member->save()) {

                }
            }
        }
        return $this->render('setPayPass', ['model' => $model]);
    }

    /**
     * ajax获取验证码
     */
    /*public function actionAjaxGetVerify()
    {
    $params = Yii::$app->request->post();
    if(isset($params['mobile']) && isset($params['type'])){
    $res = Service::sendMobileVerifyCode($params['mobile'],$params['type'],true);
    if($res){
    return Json::encode(['code' => 200, 'msg' => '验证码获取成功，请查看短信'].$res);
    }else{
    return Json::encode(['code' => 500, 'msg' => '验证码获取失败，请稍候重试']);
    }
    }
     */

    /**
     * 获取用户绑定的手机号
     */
    private function getMyMobile()
    {
        //TODO到时换成当前登录账户的手机号
        return '13501582440';
    }

    /**
     * 获取当前用户
     */
    private function getMember()
    {
        $mobile = $this->getMyMobile();
        $member = Member::find()->where(['mobile' => $mobile])->one();
        return $member;
    }
    /**
     *获取验证码
     */
    public function actionVerify($mobile, $type)
    {
        if ($mobile == false) {
            exit(JsonService::error());
        }

        $debug = yii::$app->params['app_debug'];
        $return = Service::sendMobileVerifyCode($mobile, $type, $debug);
        echo $return ? JsonService::success($return) : JsonService::error();
    }

    //会员收藏（商品或者店铺）
    public function actionCollect()
    {

        $collect = new Collect();
        $member_id = Yii::$app->user->identity->id;
        $collect_data = Collect::find();
        //$post_params = Yii::$app->request->post(); //通过ajax 传过来的数据
        $goods_data = $collect_data->andWhere(['member_id' => $member_id, 'type' => 1])->all();
        $store_data = $collect_data->where(['member_id' => $member_id, 'type' => 0])->all();

        $collect_store = array();
        foreach ($store_data as $k => $v) {
            $store_detail = Store::getCurrentStoreInfo($v['item_id']);
            if ($store_detail) {
                $collect_store[$k]['collect_id'] = $v['id'];
                $collect_store[$k]['store_id'] = $v['item_id'];
                $collect_store[$k]['member_id'] = $store_data[$k]['member_id'];
                $collect_store[$k]['store_name'] = $store_detail[0]['store_name'];
                $collect_store[$k]['store_logo'] = $store_detail[0]['store_logo'];
                $collect_store[$k]['level_name'] = $store_detail[0]['level']['name'];
            }
        }

        $collect_goods = array();
        foreach ($goods_data as $k1 => $v1) {
            //通过当前商品id获取商品的基本的信息，包括上、下架的商品
            $detail = GoodsService::getGoodsBaseInfo($v1['item_id']);
            $collect_goods[$k1]['collect_id'] = $v1['id'];
            $collect_goods[$k1]['member_id'] = $v1['member_id'];
            $collect_goods[$k1]['status'] = $detail[0]['status'];
            $collect_goods[$k1]['is_shelves'] = $detail[0]['is_shelves'];
            $collect_goods[$k1]['goods_id'] = $detail[0]['goods_id'];
            $collect_goods[$k1]['name'] = $detail[0]['name'];
            $collect_goods[$k1]['price'] = $detail[0]['price'];
            $collect_goods[$k1]['market_price'] = $detail[0]['defaultSku']['market_price'];
            $collect_goods[$k1]['image'] = Yii::$app->params['img_domain'] . $detail[0]['goodsgallery']['thumb1'];
        }

        return $this->render('collect', ['collect_goods' => $collect_goods, 'collect_store' => $collect_store]);
    }

    //在个人收藏中心（我的收藏）里面，删除不需要的收藏
    public function actionDelCollect()
    {
        $post_params = Yii::$app->request->post();
        $collect = new Collect;
        $result = null;
        if (isset($post_params) && $post_params['type'] == 1) {
            $result = $collect->findOne($post_params['collect_id'])->delete();
            if ($result) {
                return Json::encode(['code' => 200, 'msg' => '删除商品成功']);
            }

        } elseif (isset($post_params) && $post_params['type'] == 0) {
            $result = $collect->findOne($post_params['collect_id'])->delete();
            if ($result) {
                return Json::encode(['code' => 200, 'msg' => '删除商店成功']);
            }

        } else {
            //DONOTHING
            if ($result) {
                return Json::encode(['code' => 400, 'msg' => '删除失败，请重试']);
            }

        }
    }

    /**
     * 提现
     */
    public function actionWithdrawals()
    {
        $model = new Withdraw;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->member_id = yii::$app->user->identity->id;
            if ($model->save()) {
                return $this->redirect(['wd-success']);
            }
        } else {
            return $this->render('withdrawals', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 提现成功
     */
    public function actionWdSuccess()
    {
        return $this->render('wd-success');
    }

    /**
     * 用户注册
     */
    public function actionRegister()
    {
        $model = new RegisterForm();
        $params = \Yii::$app->request->post();
        if ($model->load($params) && $model->validate()) {
            $mobile = $params['RegisterForm']['mobile'];
            $r_mobile = $params['RegisterForm']['r_mobile'];
            $password = $params['RegisterForm']['password'];
            $result = RegisterService::regDmUser($mobile, $r_mobile, $password);
            if ($result['code'] == 200) {
                RegisterService::regGiveUserMcoupon($mobile);
                //TODO  自动登录
                $this->autoLogin($result['data']);
            } else {
                return $this->render('register', [
                    'model' => $model,
                    'msg' => !empty($result['msg']) ? $result['msg'] : '',
                    'r_msg' => !empty($result['r_msg']) ? $result['r_msg'] : '',
                ]);
            }
        } else {
            return $this->render('register', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 用户登录
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }

    }

    /**
     * 忘记密码
     */
    public function actionForget()
    {
        $model = new Member();
        $model->setScenario('forget');
        $params = \Yii::$app->request->post();
        if ($model->load($params) && $model->validate()) {
            $res = CommonService::checkVerify($model->verifycode, $model->mobile, CommonService::VERIFY_TYPE_PWD);
            if ($res) {
                $trans = Yii::$app->db->beginTransaction();
                try {
                    $member = Member::find()->where(['mobile' => $model->mobile])->one();
                    $member->password = md5($params['Member']['password']);
                    $r = $member->save();
                    if (!$r) {
                        throw new Exception("fail");
                    }
                    //同步会员系统注册
                    $data = [];
                    $data = ['member_id' => $member->mobile, 'password' => $params['Member']['password']];
                    $tbreg = new ZdApiService;
                    $suc = $tbreg->zdEditPwd($data);
                    if (!$suc['state']) {
                        Log::log('tb_pwdforget_fail.log', 'Mobile: '
                            . $model->mobile . '; Code: ' . $suc['code'] . '; Msg: ' . $suc['msg']);
                        throw new Exception("tbFail");
                    }
                    $trans->commit();
                    //TODO  自动登录
                    $this->autoLogin($member);

                } catch (Exception $e) {
                    $trans->rollback();
                    switch ($e->getMessage()) {
                        case 'fail':
                            \Yii::$app->session->setFlash('success', '密码修改失败');
                            break;
                        case 'tbFail':
                            \Yii::$app->session->setFlash('success', '网络异常，稍后再试。');
                            break;
                        default:
                            \Yii::$app->session->setFlash('success', $e->getMessage());
                            break;
                    }
                }
            } else {
                $model->addError('verifycode', "验证码错误");
            }
        }
        return $this->render('forget', [
            'model' => $model,
        ]);
    }

    /**
     * ajax获取验证码
     */
    public function actionGetVerify()
    {
        $params = Yii::$app->request->post();
        $res = array();
        if (isset($params['mobile'])) {
            $mobile = $params['mobile'];
            //判断是否是已注册过的会员
            $member = Member::find()->where(['mobile' => $mobile])->one();
            if (!$member) {
                $res = ['code' => 201, 'm_msg' => '该手机号未注册'];
            } else {
                //session有值且不大于60秒，不允许再次发送短信
                $canSend = !Yii::$app->session->get('mem_for_' . $mobile)
                    || (time() - Yii::$app->session->get('mem_for_' . $mobile) > 60);

                if ($canSend) {
                    $bl = CommonService::sendMobileVerifyCode($mobile, CommonService::VERIFY_TYPE_PWD);
                    if ($bl) {
                        Yii::$app->session->set('mem_for_' . $mobile, time());
                        $res = ['code' => 200, 'msg' => '验证码发送成功'];
                    } else {
                        $res = ['code' => 500, 'msg' => '验证码发送失败'];
                    }
                } else {
                    $res = ['code' => 500, 'msg' => '请过60秒后再试'];
                }
            }
        } else {
            $res = ['code' => 500, 'msg' => '手机号不能为空'];
        }
        echo json::encode($res);
        exit();
    }

    private function autoLogin($member)
    {
        $res = Yii::$app->user->login($member, 0);
        if ($res) {
            return $this->goBack();
        }
    }

    public function actionAgreement()
    {
        return $this->render('agreement');
    }

}
