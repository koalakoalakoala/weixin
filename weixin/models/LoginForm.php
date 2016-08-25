<?php
namespace weixin\models;

use Yii;
use yii\base\Model;
use common\models\Member as M;
/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $mobile;
    public $password;

    private $_user = false;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mobile', 'password'], 'required'],
            [
                ['mobile'],
                'match',
                'pattern' => '/^(0|86|17951)?(13[0-9]|15[012356789]|17[03678]|18[0-9]|14[57])[0-9]{8}$/',
                'message' => '手机号格式错误',
            ],
            ['password', 'validatePassword'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mobile' => \yii::t('app','手机号码'),
            'password' => \yii::t('app','登录密码')
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, yii::t('app','error_password'));
            }
        }
    }
    
    

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[mobile]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = M::findByUsername($this->mobile,$this->password);
        }
        return $this->_user;
    }
}
