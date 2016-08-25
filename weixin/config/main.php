<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-weixin',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'weixin\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        //店铺模块设置
        'store' => [
            'class'=>'weixin\modules\store\StoreModule'
        ],
        'member'=>[
            'class'=>'weixin\modules\member\MemberModule'
        ],
        //商品模块设置
        'goods' => [
            'class'=>'weixin\modules\goods\GoodsModule'
        ],
        //订单模块
        'order' => [
            'class'=>'weixin\modules\order\OrderModule'
        ],
        'home'=>[
            'class'=>'weixin\modules\home\HomeModule'
        ],
    ],
    'components' => [
        //主题设置
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@weixin/views' => '@weixin/themes/basic',                    //基础视图对应主题位置视图
                    '@weixin/modules' => '@weixin/themes/basic/modules',          //系统模块对应主题位置视图
                ],
                'baseUrl' => '@web/themes/basic',
            ],
        ],
        //国际化管理
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@weixin/messages',
                    //'sourceLanguage' => 'en',
                ],
            ],
        ],
        //url管理
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,//隐藏index.php
            //'enableStrictParsing' => false,
            //     'suffix' => '.html',//后缀，如果设置了此项，那么浏览器地址栏就必须带上.html后缀，否则会报404错误
            'rules' => [
                //'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ],
        ],

        'user' => [
            'identityClass' => 'weixin\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => '/member/member/login',
        ],

        'wechat' => [
            'class' => 'callmez\wechat\sdk\Wechat',
            'appId' => 'wxe5c92aded4895231',
            'appSecret' => '742b16733d666d30da4dbf7b5bdd2b81',
            'token' => 'zhongdun',
            'mchId' => '1316009001',
            'key' => 'a63d3491ce1184f26e7fef95edb91ebd',
            'jsApiCallUrl' => '',
            'sslcertPath' => '',
            'sslkeyPath' => '',
            'notifyUrl' => 'http://wechat.zdmall888.com/order/payment/wxpay',
            'curlTimeout' => 30,
        ],

        //日志管理
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
