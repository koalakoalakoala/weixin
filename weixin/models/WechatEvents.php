<?php
namespace weixin\models;
use common\models\MemberInfo;
use Yii;
use common\models\Bind;
use yii\base\Exception;

class WechatEvents extends Bind{
    /**
     * 关注业务逻辑处理
     * 包含搜索关注和扫描二维码关注
     * @param obj=null $wechat_obj
     * @return string
     */
    static function onSubscribe($wechat_obj)
    {
        $fromUsername = $wechat_obj['FromUserName'];
        //检测是否有关注过--
        $bind_model = Bind::findOne(['user_id'=>$fromUsername]);
        if (!empty($bind_model)) {
            if($bind_model->is_subscribe== 0){
                $bind_model->is_subscribe= 1;
                $bind_model->save();
                //判断是否绑定过
                if ($bind_model->member_id == 0) {
                    $str_arr = explode('_', $wechat_obj['EventKey']);
                    if ($str_arr[0] == 'qrscene') {
                        $bind_model->r_member_id = $str_arr[1];
                        $bind_model->save();
                        //有推荐关系
                        $meminfo_model = MemberInfo::findOne(['member_id'=>$bind_model->r_member_id]);
                        if ($meminfo_model) {
                            $content="欢迎关注【中盾商城】！恭喜您由【" . $meminfo_model->realname . "】成功推荐成为【中盾商城】会员,感谢您对我们的支持;【中盾商城】是综合性的金融、电商、便民、慈善服务平台\r\n";
                        }
                    }
                }
            }else{
                $content="欢迎再次关注【中盾商城】！感谢您对我们的支持;【中盾商城】是综合性的金融、电商、便民、慈善服务平台\r\n";
            }
        } else {
            //获取当前用户的详细信息
            $wechat_info = Yii::$app->wechat->getMemberInfo($fromUsername);
            //Yii::getLogger()->log(json_encode($wechat_info).'info',3);
            //$member_count = Bind::find()->count(); //会员总数
            //如果是第一次关注，则插入绑定表字段
            $bind_model = new Bind();
            $bind_model->member_id = 0;
            $bind_model->user_id = $fromUsername;
            $bind_model->name = $wechat_info['nickname'];
            $bind_model->pic = $wechat_info['headimgurl'];
            $bind_model->num = 1;
            $bind_model->is_subscribe= 1;
            $bind_model->create_time = time();
            //并且检查是否通过推荐关系关注

            $str_arr = explode('_', $wechat_obj['EventKey']);
            if ($str_arr[0] == 'qrscene') {
                //有推荐关系
                $bind_model->r_member_id = $str_arr[1];
                $meminfo_model = MemberInfo::findOne(['member_id'=>$bind_model->r_member_id]);
                if ($meminfo_model) {
                    $content="欢迎关注【中盾商城】！恭喜您由【" . $meminfo_model->realname . "】成功推荐成为【中盾商城】会员,感谢您对我们的支持;【中盾商城】是综合性的金融、电商、便民、慈善服务平台\r\n";
                }
            } else {
                $content="欢迎关注【中盾商城】！【中盾商城】是综合性的金融、电商、便民、慈善服务平台。您可以先【绑定手机并设置推荐人】锁定您的关系";
            }
            $bind_model->save();
        }
        $content.="^__^中盾商城客服很高兴为您服务客服400热线:\r\n400-607-1818\r\n 客服QQ:\r\n2797353115  2726523632\r\n 客服微信:\r\nww1122003456  zhc19780723";
        Yii::$app->wechat->sendText($fromUsername,$content);
        //return true;
    }
    /**
     * 取消关注业务逻辑处理
     * 包含搜索关注和扫描二维码关注
     * @param obj=null $wechat_obj
     * @return string
     */
    static function unSubscribe(){

    }


    /**
     * 数据XML编码
     * @param mixed $data 数据
     * @param mixed $wechat_obj 数据
     * @return xml string
     * <ToUserName><![CDATA[%s]]></ToUserName>
     * <FromUserName><![CDATA[%s]]></FromUserName>
     * <CreateTime>%s</CreateTime>
     * <MsgType><![CDATA[%s]]></MsgType>
     * <Content><![CDATA[%s]]></Content>
     * <FuncFlag>0</FuncFlag>
     */
    public function data_to_xml($wechat_obj,$data) {
        if(!isset($data['Content'])) throw new Exception("必须包含Content参数!");
        if(empty($wechat_obj)) throw new Exception("未接收到任何参数");
        $default_arr = [
            'ToUserName'=>$wechat_obj['FromUserName'],
            'FromUserName'=>$wechat_obj['FromUserName'],
            'FuncFlag'=>0,
            'MsgType'=>'text',
            'CreateTime'=>time(),
        ];
        $prexml_data = array_merge($data,$default_arr);
        $xml = '';
        foreach ($prexml_data as $key => $val) {
            is_numeric($key) && $key = "item id=\"$key\"";
            $xml    .=  "<$key>";
            $xml    .=  ( is_array($val) || is_object($val)) ? self::data_to_xml($val,$data)  : self::xmlSafeStr($val);
            list($key, ) = explode(' ', $key);
            $xml    .=  "</$key>";
        }
        return "<xml>".$xml."</xml>";
    }
    public static function xmlSafeStr($str)
    {
        return '<![CDATA['.preg_replace("/[\\x00-\\x08\\x0b-\\x0c\\x0e-\\x1f]/",'',$str).']]>';
    }
}