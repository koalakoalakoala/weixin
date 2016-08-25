<?php

namespace weixin\modules\order;

class OrderModule extends \yii\base\Module
{
    public $controllerNamespace = 'weixin\modules\order\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $this->layout = '/home';
    }
}
