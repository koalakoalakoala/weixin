<?php

namespace weixin\modules\goods;

class GoodsModule extends \yii\base\Module
{
    public $controllerNamespace = 'weixin\modules\goods\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $this->layout = '/home';
    }
}
