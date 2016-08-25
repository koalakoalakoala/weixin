<?php
namespace weixin\modules\member\controllers;
use common\models\Bind;
use yii\web\Controller;
use common\service\CommonService;
use Yii;

/**
 * Class MembercardController
 * @package weixin\modules\member\controllers
 * 用户二维码
 */
class MembercardController extends Controller{
    //禁掉crsf验证
    public $enableCsrfValidation = false;
    /**
     *初始化方法
     */
    public  function init(){
        return 0;
    }
    /**
     *
     */
    public function actionCreatecard(){
        $uid = 2;//yii::$app->user->identity->id;
        $bind_model = Bind::findOne(['member_id'=>$uid]);
        $ticket_arr= Yii::$app->wechat->createQrCode([
            "expire_seconds" => 1800,
            "action_name" => "QR_LIMIT_SCENE",
            "action_info" => array("scene" => array("scene_id" => $bind_model->id, "scene_str" => 2222))
        ]
        );
        //获取二维码图片
        $black_card= Yii::$app->wechat->getQrCodeUrl($ticket_arr['ticket']);
        $root_path=Yii::$app->getBasePath();
        $img_path = $root_path."/web/img/wximg/blackcard/{$bind_model->id}.jpg";
        CommonService::smallImg($img_path, 261, 261, $img_path);
        if(!file_exists($img_path)){
            CommonService::put_file_from_url_content($black_card,$img_path);
        }
        $card_back_img = $root_path."/web/img/card_back_img.jpg";
        //获取头像
        $logo_path = $root_path.'/web/img/wximg/avatar/' . $bind_model->id . '.jpg';
        //缩小头像
        CommonService::smallImg($logo_path, 145, 145, $logo_path);
        if(!file_exists($logo_path))
        {
            @copy($root_path."/web/img/deavatar.jpg",$logo_path);
        }

        //合成头像和背景图
        $path_tx = $root_path.'/web/img/wximg/compose/';
        $n = $bind_model->id . 'tx.jpg';
        CommonService::copyImg($logo_path, $n, 39, 37, $path_tx, $card_back_img);
        $back = $root_path.'/web/img/wximg/compose/' . $bind_model->id . 'tx.jpg';
        //写文字
        if ($bind_model->name != '') {
            $im = @imagecreatefromjpeg($back);    //从图片建立文件，此处以jpg文件格式为例
            $white = imagecolorallocate($im, 250, 250, 250);
            $text = urldecode($bind_model->name);  //要写到图上的文字
            $font = $root_path.'/web/msyhbd.ttf';  //写的文字用到的字体。
            $srcw = imagesx($im);
            imagettftext($im, 25, 0, 285, 93, $white, $font, $text);
            $compose_path=$root_path.'/web/img/wximg/compose/' . $bind_model->id . 'wz.jpg';
            imagejpeg($im, $compose_path, 100);
            imagedestroy($im);
        }
        //生成的完整文件名称
        $n = $bind_model->id . 'wz.jpg';
        $path_wz = $root_path.'/web/img/wximg/qrcard/';
        //生成完整图片
        CommonService::copyImg($img_path, $n, 80, 866, $path_wz, $compose_path);
        $src_path = $root_path.'/web/img/wximg/qrcard/'.$bind_model->id.'wz.jpg';
        $qrcard_img = '/img/wximg/qrcard/'.$bind_model->id.'wz.jpg';
        return $this->render("createcard",['qrcard_img'=>$qrcard_img]);

    }
}