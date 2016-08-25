<?php

namespace weixin\modules\member;

class MemberModule extends \yii\base\Module
{
    public $controllerNamespace = 'weixin\modules\member\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $this->layout = '/home';
    }
}
