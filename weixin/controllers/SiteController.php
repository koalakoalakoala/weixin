<?php
namespace weixin\controllers;

use common\models\Bind;
use common\service\BindService;
use Yii;
use yii\base\Event;
use yii\helpers\Url;
use weixin\models\LoginForm;
use weixin\models\Member;
use weixin\models\PasswordResetRequestForm;
use weixin\models\ResetPasswordForm;
use weixin\models\SignupForm;
use weixin\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\service\CommonService;
use yii\helpers\Json;
use weixin\models\BindExtendForBM;
use common\models\DwalletMember;
use weixin\models\User;
use common\models\DmallCreditProductApplyInfo;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->redirect(['/home/home']);
    }

    //绑定引导页面
    public function actionBind($bind_id = 1)
    {
        $model = BindExtendForBM::find()->select(['name', 'id'])->where(['id'=>$bind_id])->one();
        return $this->render('bind', ['model'=>$model]);
    }

    //绑定提交
    public function actionDetermine()
    {
        $data = Yii::$app->request->post();
        $Verify = CommonService::checkVerify($data['verification'], $data['mobile'], CommonService::VERIFY_TYPE_REG);

        //手机验证码输入正确
        if($Verify) {
            //微信账号绑定会员操作，进行事务操作
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model = BindExtendForBM::find()->where(['id' => $data['id']])->one();
                $model->load_params($data);
                $member_id = Member::find()->select('id')->where(['mobile' => $data['mobile']])->one();
                $r_member_id = null;

                if(!empty($data['recommend_mobile'])) {
                    //推荐人的会员ID获取 - 通过推荐人手机号
                    $r_member_id = Member::find()->select('id')->where(['mobile' => $data['recommend_mobile']])->one();
                }

                if($r_member_id)
                {
                    $model->r_member_id = $r_member_id->id;
                } else {
                    $model->r_member_id = '1000000';
                }

                //如果这个手机号  对应没有会员 则 需要 在会员表里，创建一条记录 - 对于此处的数据库记录更新操作，是否需要事务处理 - 单条更新
                if (!$member_id) {
                    $member_id = new Member();
                    $member_id->username = 'test';
                    $member_id->password = 'test';
                    $member_id->create_time = time();
                    $member_id->active = 1;
                    $member_id->mobile = $data['mobile'];
                    if($r_member_id)
                    {
                        $member_id->r_member_id = $r_member_id->id;
                    } else {
                        $member_id->r_member_id = '1000000';
                    }
                    $member_id->save();
                }
                $model->member_id = $member_id->id;
                $model->name = $data['name'];
                $model->save();
                $transaction->commit();
                return Json::encode(['code' => 200, 'msg' => '验证成功', 'url' => '/site/index']);
            } catch(Exception $e){
                $transaction->rollBack();
                echo 'edit failure!';
            }
        } else { //手机验证码输入错误
            return Json::encode(['code'=>200,'msg'=>'验证失败', 'url'=>'/site/bind?id='.$data['id'] ]);
        }
    }

    //发送验证短信
    public function actionVerification()
    {
        $params = Yii::$app->request->post();
        $res = CommonService::sendMobileVerifyCode($params['mobile'], CommonService::VERIFY_TYPE_REG);
        if($res)
        {
            return Json::encode(['code'=>200,'msg'=>'验证码发送成功']);
        }
        else
        {
            return Json::encode(['code'=>500, 'msg'=>'验证码发送失败']);
        }
    }

    //查找推荐人名称
    public function actionSearchmember()
    {
        $params = Yii::$app->request->post();

        $member_model = Member::find()->select(['id', 'username'])->where(['mobile'=>$params['recomobile'] ])->one();

        if($member_model) {
            if($member_model->id == '100'){
                return Json::encode(['code' => 200, 'username' => '默认推荐人：中盾商城']);
            }
            return Json::encode(['code' => 200, 'username' => $member_model->username]);
        } else {
            return Json::encode(['code' => 200,'username' => "无此推荐人"]);
        }
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        $params = Yii::$app->request->post() ;

        foreach($params as $key=>&$v){
            if($key =="LoginForm")
                $v['password']=md5($v['password']);
        }

        if ($model->load($params) && $model->login()) {
            return $this->goHome();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionTokenlogin()
    {
        $params = Yii::$app->request->get();
        if(isset($params['access_token']) && $params['access_token']){
            $mem = DwalletMember::find()->where(['access_token'=>$params['access_token']])->one();
            if($mem){
                $member_id = $mem->member_id;
                $user = User::findIdentity($member_id);
                if($user){
                    $res = Yii::$app->user->login($user, 3600 * 24 * 30);
                    if($res){
                        return Json::encode(['code'=>200,'msg'=>'登录成功']);
                    }else{
                        return Json::encode(['code'=>500,'msg'=>'登录失败']);
                    }
                }else{
                    return Json::encode(['code'=>500,'msg'=>'没有找到商城用户']);
                }
            }else{
                return Json::encode(['code'=>500,'msg'=>'没有找到钱富宝用户']);
            }
        }else{
            return Json::encode(['code'=>500,'msg'=>'缺少参数']);
        }
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }


    public function actionTest()
    {
        $res = file_get_contents("http://api.yii.com/v1/posts?id=1");
        print_r($res);
    }

    /**
     * 协议地址
     * @return string
     */
    public function actionFile(){
        $type=Yii::$app->request->get('type');
        switch($type)
        {
            case 'register':
                return $this->render('register');
            case 'service':
                return $this->render('service');
        }

    }
      /**
         * 消费信贷
         * @return string
         */
        public function actionCredit(){
            $type=Yii::$app->request->get('type');
            switch($type)
            {
                case 'apply':
                    return $this->render('apply');
                case 'refer':
                    return $this->render('refer');
                case 'credit_supermarket':
                   return $this->render('credit_supermarket');
                 case 'hcdetails':
                     return $this->render('hcdetails');
                 case 'successful':
                     return $this->render('successful');
                 case 'wrong':
                     return $this->render('wrong');
                 case 'work':
                     return $this->render('work');
                 case 'kontakty':
                     return $this->render('kontakty');
                 case 'warranty':
                     return $this->render('warranty');
                 case 'security':
                     return $this->render('security');
                 case 'business':
                     return $this->render('business');
            }

        }
    /**
     * 恒昌精英贷
     * @return string
     */
    public function actionApply() {

        $params = Yii::$app->request->post();
        $model = new DmallCreditProductApplyInfo();
        $model->setScenario('apply');
        $model->product_id = 1;
        $model->create_time = time();

        if ($model->load($params) && $model->save()) {
            return $this->redirect(['successful']);
        } else {
            return $this->render('apply', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 申请成功页面
     * @return string
     */
    public function actionSuccessful() {
        return $this->render('successful');
    }

    /**
     * 申请不动产
     * @return string
     */
    public function actionRefer() {
        return $this->render('refer');
    }

     /**
     * 恒昌精英贷
     * @return string
     */
    public function actionHcdetails() {
        return $this->render('hcdetails');
    }

    /**
     * 信贷超市
     * @return string
     */
    public function actionCreditSupermarket() {
        return $this->render('credit-supermarket');
    }

    /**
     * 错误页面
     * @return string
     */
    public function actionWrong() {
        return $this->render('wrong');
    }
  /**
         * 实体加盟
         * @return string
         */
    public function actionJoin(){
       $type=Yii::$app->request->get('type');
       switch($type)
        {
        case 'entity':
            return $this->render('entity');
        case 'proxy':
            return $this->render('proxy');
        case 'case':
           return $this->render('case');
         case 'case-more':
             return $this->render('case-more');
         case 'case-dynamic':
             return $this->render('case-dynamic');
         case 'align':
             return $this->render('align');
         case 'agency':
             return $this->render('agency');
            }

        }
}
