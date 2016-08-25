<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/8/21
 * Time: 17:41
 */

namespace weixin\models;

use common\models\Bind;
use Yii;

class BindExtendForBM extends Bind
{
    public $mobile ;

    public $recommend_mobile = '1000000';

    public $Verification;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'r_member_id', 'num', 'create_time'], 'integer'],
            [['user_id', 'create_time', 'mobile', 'recommend_mobile', 'Verification' ,'name'], 'required'],
            [['name', 'pic', 'user_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '主键，自增'),
            'member_id' => Yii::t('app', '会员ID'),
            'name' => Yii::t('app', '名字'),
            'pic' => Yii::t('app', '头像'),
            'user_id' => Yii::t('app', '第三方用户ID 唯一'),
            'r_member_id' => Yii::t('app', '推荐会员ID'),
            'num' => Yii::t('app', 'Num'),
            'create_time' => Yii::t('app', '创建时间'),
            'mobile' =>  Yii::t('app', '手机号'),
            'recommend_mobile' => Yii::t('app', '推荐人手机号'),
            'Verification' => Yii::t('app', '验证码'),
        ];
    }


    public function load_params($data, $formName = null)
    {
        $this->load($data, $formName);
        $this->mobile = $data['mobile'];
        $this->recommend_mobile = $data['recommend_mobile'];
        $this->Verification = $data['verification'];

        return true;
    }
}