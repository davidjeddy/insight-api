<?php

namespace backend\modules\api\v1;

use Yii;

class Module extends \backend\modules\api\Module
{
    public $controllerNamespace = 'backend\modules\api\v1\controllers';

    public function init()
    {
        parent::init();
        Yii::$app->user->identityClass = 'backend\modules\api\v1\models\ApiUserIdentity';
        Yii::$app->user->enableSession = false;
        Yii::$app->user->loginUrl = null;
    }
}
