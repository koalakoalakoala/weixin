<?php
namespace weixin\modules\member\models;

use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class PayPassBackForm extends Model
{
    public $mobile; //手机号
    public $verify; //验证码
    public $password; // 密码
    public $confirmPassword; //确认密码

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mobile','verify'], 'required', 'on'=>['verify']],        
            [['password','confirmPassword'], 'required', 'on'=>['set']],    
            [['confirmPassword'], 'compare','compareAttribute'=>'password', 'message'=>'两次密码不相同', 'on'=>['set']],        
        ];
    } 


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mobile' => Yii::t('app', '手机号'),
            'verify' => Yii::t('app', '验证码'),
            'password' => Yii::t('app', '密码'),
            'confirmPassword' => Yii::t('app', '确认密码'),
        ];
    }   
}
