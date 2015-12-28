<?php

namespace app\controllers;
use Yii;
use app\models\account\Account;

class CreditController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $models = Account::find()->
                where([
                    'user_id' => Yii::$app->user->getId(),
                    'type' => ['credit', 'creditcard'],
                    'virtual' => 0,
                ])->
                all();
        
        return $this->render('index', [
            'models' => $models,
        ]);
    }

}
