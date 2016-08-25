<?php

namespace weixin\controllers;
use weixin\models\WechatEvents;
use Yii;
use yii\base\Exception;
use yii\helpers\Url;
use yii\web\Controller;
use weixin\models\LoginForm;
use weixin\models\Member;
use common\models\Bind;
class IndexController extends Controller{
	public $enableCsrfValidation = false;
    /**
     * @return bool
     * 处理微信回调信息接口
     */
    public function actionIndex()
    {
        try{
            $wechat_obj= Yii::$app->wechat->parseRequestData();
            //Yii::getLogger()->log(json_encode($wechat_obj).'ojb',3);
                switch ($wechat_obj['MsgType']) {
                    case 'event':
                        //关注事件
                        if ($wechat_obj['Event']== 'subscribe') {
                            WechatEvents::onSubscribe($wechat_obj);
                        }
                        //菜单点击
                        else if ($wechat_obj->Event== 'CLICK') {
                            Menu::click($wechat_obj);
                        }
                        break;
                }
        }catch (\Exception $e) {
            echo $e->getMessage();
        }
    }


    /**
     * 微信授权登录
     * 网页授权获取用户信息:第一步
     * 通过此函数生成授权url
     * @param $redirectUrl 授权后重定向的回调链接地址，请使用urlencode对链接进行处理
     * @param string $state 重定向后会带上state参数，开发者可以填写a-zA-Z0-9的参数值
     * @param string $scope 应用授权作用域，snsapi_base （不弹出授权页面，直接跳转，只能获取用户openid），
     * snsapi_userinfo （弹出授权页面，可通过openid拿到昵称、性别、所在地。并且，即使在未关注的情况下，只要用户授权，也能获取其信息）
     * @return Url
     */
    public function actionWechatlogin()
    {
        /**
         * 接收登录跳转的参数
         * $params
         * @ $params['type'] member/member? home/home?  goods? 跳转类型
         * @ $params['member_id']
         * @ $params['goods_id']
         * @ $goodsid 商品ID 如果是查看商品,跳转到相应的商品页面
         */
        $params = Yii::$app->request->get();
        Yii::$app->session->set("back_parameter",$params);
        $openid = Yii::$app->session->get("openid");
        if(isset($openid)){
            return $this->redirect(Yii::$app->params['www_domain'].$params['type'].http_build_query($params));
            //return $this->redirect($params['type'].http_build_query($params));
        }
        $redirectUrl = Yii::$app->params["www_domain"].Url::toRoute(["callbacktogetcode",'id'=>1]);
        $location_url = Yii::$app->wechat->getOauth2AuthorizeUrl(urldecode($redirectUrl), $state = 'authorize', $scope = 'snsapi_base');
        header("location:$location_url");
    }

    /**
     * @return bool
     * @throws Exception
     * 回调获取code 通过code得到openid验证用户是否关注
     */
    public function actionCallbacktogetcode()
    {
        $code = Yii::$app->request->get("code");
        $params = Yii::$app->session->get("back_parameter");
        $wechat_data = Yii::$app->wechat->getOauth2AccessToken($code, $grantType = 'authorization_code');
        $params['openid'] = $wechat_data['openid'];
        Yii::$app->session->set("openid",$params['openid']);
        if(!empty($wechat_data)){
            //检测是否有关注
            $bind_model = new Bind();
            $bind_arr = $bind_model->findOne(['user_id'=>$wechat_data['openid']]);
            if(!empty($bind_arr)){
                if($bind_arr->member_id == 0){
                    if($params['member_id']){
                        $rbindinfo = Bind::model()->find('member_id = '.$params['member_id']);
                        $r_member_id = $rbindinfo->id;
                        $bind_arr->r_member_id = $r_member_id?$r_member_id:1;
                        $bind_arr->save();
                        return $this->redirect(Yii::$app->params['www_domain'].$params['type'].http_build_query($params));
                    }else
                        return $this->redirect(Yii::$app->params['www_domain'].$params['type'].http_build_query($params));
                }else
                    $this->wxLogin($params);

            }else{
                $redirectUrl = Yii::$app->params["www_domain"].Url::toRoute(["callbacktogetuserinfo"]);
                $location_url = Yii::$app->wechat->getOauth2AuthorizeUrl($redirectUrl, $state = 'authorize', $scope = 'snsapi_userinfo');
                header("location:$location_url");
            }
        }else
            return $this->createUrl(Url::to("home/home"));
    }

    /**
     * 授权获取用户信息
     */
    public function actionCallbacktogetuserinfo()
    {
        $code = Yii::$app->request->get("code");
        $params = Yii::$app->session->get("back_parameter");
        if($params['member_id']){
            $bind_model = new Bind();
            $rbindinfo = $bind_model->findOne(['member_id = '.$params['member_id']]);
            $r_member_id = $rbindinfo->id;
        }else{
            $r_member_id=1;
        }
        $userAccessData = Yii::$app->wechat->getOauth2AccessToken($code);
        $userAccessInfo=Yii::$app->wechat->getSnsMemberInfo($userAccessData['openid'],$userAccessData['access_token']);
        $bind_model = new Bind();
        $bind_model->r_member_id = $r_member_id?$r_member_id:1;
        $bind_model->user_id = $userAccessInfo['openid'];
        $bind_model->name = $userAccessInfo['nickname'];
        $bind_model->pic = $userAccessInfo['headimgurl'];
        $bind_model->create_time = time();
        $bind_model->save();
        return $this->redirect(Yii::$app->params['www_domain'].$params['type'].http_build_query($params));
    }

    /**
     * @param $params
     * @return \yii\web\Response
     */
    public function wxLogin($params)
    {
        /**
         * 查找用户是否绑定,如果绑定进行登录,然后跳转，
         * 如果没有绑定进行没有绑定的跳转
         */
        $bindinfo = Bind::find()->select("member_id")->where(['user_id' => $params['openid']])->asArray()->one();
        if (!empty($bindinfo)) {
            $member = Member::find()->select("id,mobile,password")->where(['id' => $bindinfo['member_id']])->asArray()->one();
            $login_model = new LoginForm();
            $login_model->username= $member['mobile'];
            $login_model->password = $member['password'];
            if ($login_model->login()) {
                return $this->redirect(Yii::$app->params['www_domain'].$params['type'].http_build_query($params));
            }
        }else{
            return $this->redirect(Yii::$app->params['www_domain'].$params['type'].http_build_query($params));
        }
    }


    public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }
    private function checkSignature()
    {
        // you must define TOKEN by yourself

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = Yii::$app->components['wechat']['token'];
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
}
?>
