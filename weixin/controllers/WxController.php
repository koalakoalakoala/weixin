<?php
namespace weixin\controllers;

use yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\log\FileTarget;
use yii\log\Logger;
use common\models\Bind;
use common\models\Member;
use common\models\MemberInfo;
use common\models\MemberMoney;
use weixin\models\LoginForm;

/**
 * 微信相关控制器
 * @author xiaomalover <xiaomalover@gmail.com>
 */
class WxController extends Controller
{
    /**
     * 关闭csrf验证，不然微信服务器无法提交数据
     */
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        //认证(此方法主要用在公众号后台配置URL时验证使用)
        if(isset($_GET["echostr"])){
            $this->valid();
        }
        //消息接收(微信公众号收到用户信息后，会post $GLOBALS["HTTP_RAW_POST_DATA"]这个参数，把信息放在里面)
        if(isset($GLOBALS["HTTP_RAW_POST_DATA"])){
            $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
            //$this->logResult($postStr, Logger::LEVEL_INFO); //保存用户发送的信息体到log到runtime文件夹下一，wechat.log文件里，方便调试
            if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
                $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                $textTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Content><![CDATA[%s]]></Content>
                            <FuncFlag>0</FuncFlag>
                            </xml>";
                if(!empty( $keyword ))
                {
                    $msgType = "text";
                    $contentStr = "欢迎来到中盾商城!";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }else{
                    echo "Input something...";
                }
            }else {
                echo "";
                exit;
            }
        }
    }

    /**
     * 验证
     */
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        //valid signature , option
        if ($this->checkSignature()) {
            echo $echoStr;
            exit;
        }
    }

    /**
     * 检查签名
     * @return [type] [description]
     */
    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        return Yii::$app->wechat->checkSignature($signature, $timestamp, $nonce);
    }

    /**
     * 记录微信支付的日志
     */
    private function logResult($word, $level)
    {
        $time = microtime(true);
        $log = new FileTarget();
        $log->logFile = Yii::$app->getRuntimePath() . '/logs/wechat.log';
        $log->messages[] = [$word,$level,'wxpay',$time];
        $log->export();
    }


    /**
     *创建自定义菜单
     *跨境商城
     *          跨境商品 http://dmallwx.dm188.cn/home/home
     *          消费金融 http://www.qianfb.com/
     * 会员注册 http://app.qianfb.com/gwoffical/qfbmobile.html
     *
     * 企业咨询
     *         公司简介 http://www.d188.cn/
     *         项目介绍 http://baike.baidu.com/link?url=AMoq5dReKJ6fu63Gi0RSUOLjPxiOwDlvnwn7QlW7ag5mKQvRNhMbzoTgX5PEno2_aCvOwcF3ZyurfuKLylI0TK
     *         售后服务 消息 中英街售后小密为您服务！
     *         活动预看 消息 双十一。中英街全场5折。
     */
    public function actionCreateMenu()
    {
        $menu = [
            [
                'name' => '跨境商城',
                'sub_button' => [
                    [
                        'type' => 'view',
                        'name' => '跨境商品',
                        'url' => 'http://wechat.zdmall888.com/home/home'
                    ],
                    [
                        'type' => 'view',
                        'name' => '实体加盟',
                        'url' => 'http://www.qianfb.com/'
                    ]
                ]
            ],
            [
                'name' => '消费金融',
                'sub_button' => [
                    [
                        'type' => 'view',
                        'name' => '消费信贷',
                        'url' => 'http://wechat.zdmall888.com/wx/oauth'
                    ],
                    [
                        'type' => 'view',
                        'name' => '消费金融',
                        'url' => 'http://wechat.zdmall888.com/wx/oauth'
                    ]
                ]
            ],
            [
                'name' => '企业咨询',
                'sub_button' => [
                    [
                        'type' => 'view',
                        'name' => '公司简介',
                        'url' => 'http://www.d188.cn/'
                    ],
                    [
                        'type' => 'view',
                        'name' => '项目介绍',
                        'url' => 'http://baike.baidu.com/link?url=AMoq5dReKJ6fu63Gi0RSUOLjPxiOwDlvnwn7QlW7ag5mKQvRNhMbzoTgX5PEno2_aCvOwcF3ZyurfuKLylI0TK'
                    ],
                    [
                        'type' => 'click',
                        'name' => '售后服务',
                        'key' => 'V1001_SERVICE'
                    ],
                    [
                        'type' => 'click',
                        'name' => '活动预看',
                        'key' => 'V1002_ACTIVITY'
                    ]
                ]
            ]
        ];
        $aa = Yii::$app->wechat->createMenu($menu);
        print_r($aa);
    }

    /**
     * 生成授权链接并跳转
     */
    public function actionOauth()
    {
        $url = Yii::$app->wechat->getOauth2AuthorizeUrl(Url::to(['is-subscribe']
            , true), $state = 'authorize', $scope = 'snsapi_userinfo');
        header('location:'.$url);
    }

    /**
     * 检查当前是否已进行关注，如没关注则进行绑定关注
     */
    public function actionIsSubscribe()
    {
        $code =  $_GET['code'];
        //第一步:取全局access_token
        $res = Yii::$app->wechat->getOauth2AccessToken($code);

        //取得用户基本信息
        $userinfo = Yii::$app->wechat->getSnsMemberInfo($res['openid']
            , $res['access_token'], 'zh_CN');

        //存微信的openid和微信用户信息到session
        Yii::$app->session->set("openid",$userinfo['openid']);
        Yii::$app->session->set('wx_userinfo', $userinfo);

        //查找之前是否绑定过，没绑定过就跳去填表单
        if ($res) {
            //检测是否有关注
            $bind = Bind::findOne(['user_id' => $res['openid']]);
            if ($bind) {
                $member_info = Member::find()
                    ->select("id, username, mobile, password")
                    ->where(['id' => $bind->member_id])
                    ->asArray()->one();
                $login_model = new LoginForm();
                $login_model->username= $member_info['mobile'];
                $login_model->password = $member_info['password'];
                if ($login_model->login()) {
                    return $this->redirect(Url::to(['home/home']));
                }
            } else {
                //跳转到填写手机号码页面,并检查填定的手机是否已经存在于数据库
                return $this->redirect(Url::to(['mobile-checkin']));
            }
        } else {
            return $this->redirect(Url::to(['oauth']));
        }
    }

    /**
     * 处理填写的手机号
     */
    public function actionMobileCheckin()
    {
        $model = '';
        $params_post = Yii::$app->request->post();
        if (!empty($params_post)) {
            return $this->wxLogin($params_post);
        }
        return $this->render('mobile-checkin', [
            'model' => $model,
        ]);
    }

    /**
     * 查找用户是否绑定,如果绑定进行登录,然后跳转，
     * 如果没有绑定进行绑定的跳转
     */
    public function wxLogin($params)
    {
        $mobile = $params['phone_num'];
        //检查数据库是否已存在该手机号码，
        //存在并进行绑定操作并且记录用户基本信息
        $m_info = Member::findOne(['mobile'=>$mobile]);
        if ($m_info) {
            //查出用户信息表，修改
            $member_info = MemberInfo::findOne(['member_id' => $m_info->id]);
            $member_info->nickname = addslashes(Yii::$app->session['wx_userinfo']['nickname']);
            $member_info->province = Yii::$app->session['wx_userinfo']['province'];
            $member_info->avatar = Yii::$app->session['wx_userinfo']['headimgurl'];
            $member_info->city = Yii::$app->session['wx_userinfo']['city'];
            $res_info = $member_info->save();

            $bind_model = new Bind;
            $bind_model->member_id = $m_info->id;
            $bind_model->name = addslashes(Yii::$app->session['wx_userinfo']['nickname']);
            $bind_model->pic = Yii::$app->session['wx_userinfo']['headimgurl'];
            $bind_model->user_id = Yii::$app->session['wx_userinfo']['openid'];
            $bind_model->create_time = time();
            $res_bind = $bind_model->save();

            //保存成功自动登录
            if ($res_info && $res_bind) {
                $login_model = new LoginForm();
                $login_model->username = $m_info['mobile'];
                $login_model->password = $m_info['password'];
                if ($login_model->login()) {
                    return $this->redirect(Url::to(['home/home']));
                }
            }
        } else {
            $trans = Yii::$app->db->beginTransaction();
            try {
                //注册用户
                $member = new Member;
                $member->username = $mobile;
                $member->mobile = $mobile;
                $member->create_time = time();
                if (!$member->save()) {
                    throw new Exception("member");
                }

                //生成用户属性
                $member_info = new MemberInfo;
                $member_info->member_id = $member->id;
                $member_info->nickname = addslashes(Yii::$app->session['wx_userinfo']['nickname']);
                $member_info->province = Yii::$app->session['wx_userinfo']['province'];
                $member_info->avatar = Yii::$app->session['wx_userinfo']['headimgurl'];
                $member_info->city = Yii::$app->session['wx_userinfo']['city'];
                if (!$member_info->save()) {
                    throw new Exception("memberInfo");
                }

                //生成用户帐户
                $member_money = new MemberMoney;
                $member_money->member_id = $member->id;
                if (!$member_money->save()) {
                    throw new Exception("memberMoney");
                }

                //生成绑定记录
                $bind_model = new Bind;
                $bind_model->member_id = $member->id;
                $bind_model->name = addslashes(Yii::$app->session['wx_userinfo']['nickname']);
                $bind_model->pic = Yii::$app->session['wx_userinfo']['headimgurl'];
                $bind_model->user_id = Yii::$app->session['wx_userinfo']['openid'];
                $bind_model->create_time = time();
                if (!$bind_model->save()) {
                    throw new Exception("bind");
                }

                //提交事务
                $trans->commit();

                //自动登录
                $m_rs = Member::find()->select("id, mobile, password")
                    ->where(['id' => $member->id])->asArray()->one();
                $login_model = new LoginForm();
                $login_model->username = $m_rs['mobile'];
                $login_model->password = $m_rs['password'];
                if ($login_model->login()) {
                    return $this->redirect(Url::to(['home/home']));
                }
            } catch (Exception $e) {
                $trans->rollBack();
                switch ($e->getMessage()) {
                    case 'member':
                        $str = "保存用户信息失败";
                        break;
                    case 'memberInfo':
                        $str = "保存用户属性信息失败";
                        break;
                    case 'memberMoney':
                        $str = "保存用户帐户信息失败";
                        break;
                    case 'bind':
                        $str = "保存绑定信息失败";
                        break;
                    default:
                        $str = $e->getMessage();
                        break;
                }
                header("Content-type: text/html; charset=utf-8");
                die($str);
            }
        }
    }
}
