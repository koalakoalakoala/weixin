<?php
namespace weixin\models;

use yii\base\Model;

/**
 * 购车订单页表单模型
 * @author xiaomalover <xiaomalover@gmail.com>
 * @created 2016/5/28 16:46
 */
class CarOrder extends Model
{
    /**
     * 姓名
     */
    public $name;

    /**
     * 姓别
     */
    public $sex;

    /**
     * 手机号
     */
    public $mobile;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'mobile', 'sex'], 'required'],
            [
                ['mobile'],
                'match',
                'pattern' => '/^(0|86|17951)?(13[0-9]|15[012356789]|17[03678]|18[0-9]|14[57])[0-9]{8}$/',
                'message' => '手机号格式错误',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => '您的姓名',
            'mobile' => '您的手机号',
            'sex' => '姓别',
        ];
    }
}
