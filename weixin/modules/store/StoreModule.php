<?php

namespace weixin\modules\store;

class StoreModule extends \yii\base\Module
{
    public $controllerNamespace = 'weixin\modules\store\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $this->layout = '/home';
    }
}
