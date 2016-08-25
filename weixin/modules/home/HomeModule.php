<?php

namespace weixin\modules\home;

class HomeModule extends \yii\base\Module
{
    public $controllerNamespace = 'weixin\modules\home\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $this->layout = '/home';
    }
}
