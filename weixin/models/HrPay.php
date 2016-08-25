<?php
namespace weixin\models;

use yii\base\Model;

/**
 * 华融支付表单类
 * @author xiaomalover <xiaomalover@gmail.com>
 * @created 2016/5/26 9:32
 */
class HrPay extends Model
{
    /**
     * 姓名
     */
    public $name;

    /**
     * 身份证号
     */
    public $idCard;

    /**
     * 银行卡号
     */
    public $cardNo;

    /**
     * 预留手机号
     */
    public $mobile;

    /**
     * 短信验证码
     */
    public $verifyCode;

    /**
     * 信用卡校验码
     */
    public $cvv2;

    /**
     * 有效期年
     */
    public $year;

    /**
     * 有效期月
     */
    public $month;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'idCard', 'cardNo', 'mobile', 'verifyCode'], 'required'],
            [
                ['name', 'idCard', 'cardNo', 'mobile', 'verifyCode', 'cvv2', 'year', 'month'],
                'required', 'on' => 'ccPay',
            ],
            [
                ['mobile'],
                'match',
                'pattern' => '/^(0|86|17951)?(13[0-9]|15[012356789]|17[03678]|18[0-9]|14[57])[0-9]{8}$/',
                'message' => '手机号格式错误',
            ],
            [
                ['cardNo'],
                'match',
                'pattern' => '/^(\d{16}|\d{19})$/',
                'message' => '银行卡格式错误',
            ],
            [
                ['idCard'],
                'match',
                'pattern' => '/^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/',
                'message' => '身份证号格式错误',

            ],
            [
                ['idCard'],
                'match',
                'pattern' => '/^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/',
                'message' => '身份证号格式错误',

            ],
            [
                'year',
                'checkValidDate',
                'skipOnEmpty' => false,
                'skipOnError' => false,
                'on' => 'ccPay',
            ],
        ];
    }

    /**
     * 验证有效期
     */
    public function checkValidDate($attribute, $params)
    {
        $res = is_numeric($this->month) &&
            is_numeric($this->year) &&
            ($this->month > 0 && $this->month <= 12) &&
            ($this->year >= date("Y") && strlen($this->year) == 4);
        if (!$res) {
            $this->addError($attribute, "请输入正确的有效期");
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => '您的姓名',
            'idCard' => '身份证号',
            'cardNo' => '银行卡号',
            'mobile' => '预留手机号',
            'verifyCode' => '短信验证码',
            'cvv2' => 'CVV2码',
            'month' => '有效期月份',
            'year' => '有效期年份',
        ];
    }
}
