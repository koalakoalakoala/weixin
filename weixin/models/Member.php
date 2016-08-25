<?php

namespace weixin\models;

use Yii;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "{{%admin}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property integer $enabled
 * @property integer $is_sys
 * @property integer $create_time
 * @property integer $last_login
 * @property string $last_ip
 */
class Member extends ActiveRecord  
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%member}}';
    }
    

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'create_time'], 'required'],
            [['active', 'create_time'], 'integer'],
            [['username'], 'string', 'max' => 30],
            [['password'], 'string', 'max' => 32],
            // [['last_ip'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'username'),
            'password' => Yii::t('app', 'Password'),
            'active' => Yii::t('app', 'Enabled'),
            // 'is_sys' => Yii::t('app', 'Is Sys'),
            'create_time' => Yii::t('app', 'Create Time'),
            // 'last_login' => Yii::t('app', 'Last Login'),
            // 'last_ip' => Yii::t('app', 'Last Ip'),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }
    
    /**
     * 获取帐号
     */
    public function getUsername()
    {
        return $this->username;
    }
    
    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return yii::$app->security->validatePassword($password,yii::$app->security->generatePasswordHash($password));
    }
    
    
    /**
     * 根据帐号密码查找
     * @param 帐号 $username
     * @param 密码 $password
     * @return Ambigous <\yii\db\static, NULL>
     */
    public static function findByUsername($username,$password)
    {
        return static::findOne(['mobile' => $username, 'password' => $password,'active'=>\common\enum\StatusEnum::ENABLED]);
    }
}
