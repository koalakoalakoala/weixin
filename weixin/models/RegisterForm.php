<?php
namespace weixin\models;

use yii\base\Model;
use common\models\Member;

class RegisterForm extends Model
{
    public $mobile;
    public $r_mobile;
    public $password;
    public $agreement;

    public function rules()
    {
        return [
            //手机号相关
            ['mobile', 'required', 'message'=>'请输入手机号'],
            ['mobile', 'match', 'pattern' => '/^(0|86|17951)?(13[0-9]|15[012356789]|17[03678]|18[0-9]|14[57])[0-9]{8}$/i', 'message'=>'手机号不合法'],
            //密码相关
            ['password', 'required','message'=>'密码不能为空'],
            ['password', 'match', 'pattern' => '/^[A-Za-z0-9]+$/', 'message'=>'密码不能包含特殊字符'],
            ['password', 'match', 'pattern' => '/^(\d{1,10}[a-zA-Z]{1,10}([0-9a-zA-Z])*)|([a-zA-Z]{1,10}\d{1,10}([0-9a-zA-Z])*)$/', 'message'=>'密码必须同时含有字母和数字'],
            ['password', 'string', 'length' => [6, 20], 'message'=>'aaa'],
            //推荐人相关
            ['r_mobile', 'match', 'pattern' => '/^(0|86|17951)?(13[0-9]|15[012356789]|17[03678]|18[0-9]|14[57])[0-9]{8}$/i', 'message'=>'推荐人手机号不合法'],
            //协议相关
            ['agreement', 'required','message'=>'请勾选协议'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'password' => '密码',
            'mobile' => '手机号码'
        ];
    }
}