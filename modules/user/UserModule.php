<?php

namespace app\modules\user;
use Yii;

class UserModule extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\user\controllers';

    public function init()
    {
        parent::init();

        Yii::$app->urlManager->addRules(['login' => 'user/default/login'], false);
        Yii::$app->urlManager->addRules(['logout' => 'user/default/logout'], false);
        Yii::$app->urlManager->addRules(['signup' => 'user/default/signup'], false);
        Yii::$app->urlManager->addRules(['request-password-reset' => 'user/default/request-password-reset'], false);
        Yii::$app->urlManager->addRules(['reset-password' => 'user/default/reset-password'], false);

        Yii::$app->params['user.passwordResetTokenExpire'] =3600;
//        ddump(Yii::$app->urlManager);
        // custom initialization code goes here
    }
}
