<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\account\Account;
use app\models\account\Balance;

class AccountsController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Lists all Account models.
     * @return mixed
     */
    public function actionIndex()
    {
        $models = Account::hierarcyForUser(Yii::$app->user->getId());
        $date = isset($_GET['date']) ? $_GET['date']  : null;
        if (isset($_GET['date0'])) {
            
            $date0 = $_GET['date0'] . ' 00:00:00';
            $date1 = date('Y-m-d 00:00:00', strtotime($_GET['date0'] . ' +1 day'));
//ddump($date1, $date0);
            $t = \app\models\transaction\Transaction::find()->where("date BETWEEN '$date0' AND '$date1'")->andWhere(['user_id' => 2])->all();

            $incs = [];
            $outs = [];

            foreach ($t as $transaction) {
                foreach ($transaction->transactionOutgoings as $out) {
                    if (!isset($outs[$out->account_id])) {
                        $outs[$out->account_id] = 0;
                    }
                    $outs[$out->account_id] += $out->sum;
                }
                foreach ($transaction->transactionIncomings as $in) {
                    if (!isset($incs[$in->account_id])) {
                        $incs[$in->account_id] = 0;
                    }
                    $incs[$in->account_id] += $in->sum;
                }
            }
            dump($outs, $incs);

            foreach ($models as $m) {
                if (!$m->virtual) {
                    if (isset($outs[$m->id]) || isset($incs[$m->id])) {
                        echo "Balance for account {$m->title}:";
                        echo "<br/>&nbsp;&nbsp;Date: " . $m->getBalance($_GET['date0'])->date;
                        echo "<br/>&nbsp;&nbsp;Sum: " . $m->getBalance($_GET['date0'])->sum;
                        echo "<br/>&nbsp;&nbsp; +" . (isset($incs[$m->id]) ? $incs[$m->id] : 0);
                        echo "<br/>&nbsp;&nbsp; -" . (isset($outs[$m->id]) ? $outs[$m->id] : 0);
                        echo "<br/><br/>";
                        
                        $b = new Balance();
                        $b->account_id = $m->id;
                        $b->date = date('Y-m-d', strtotime($_GET['date0'] . ' +1 day'));
                        $b->sum = $m->getBalance($_GET['date0'])->sum 
                                - (isset($outs[$m->id]) ? $outs[$m->id] : 0) 
                                + (isset($incs[$m->id]) ? $incs[$m->id] : 0);
                        $b->save();
                    }
                }
            }
            ddump(9);
        }
//        $searchModel = new AccountSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'models' => $models,
            'date' => $date,
        ]);
    }

    /**
     * Displays a single Account model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Account model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Account();
        $model->scenario = 'insert';
        $balance = new Balance();
        $balance->scenario = 'insert';

        $loaded = $model->load(Yii::$app->request->post()) && ($model->virtual || $balance->load(Yii::$app->request->post()));

        $valid = false;

        if ($loaded) {
            $valid = $model->validate();
            $valid = $valid && ($model->virtual || $balance->validate(['sum']));
        }

        if ($valid) {
            $model->save();
            if (!$model->virtual) {
                $balance->date = date('Y-m-d', strtotime('first day of this month'));
                $balance->account_id = $model->id;
                $balance->save();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'balance' => $balance,
        ]);
    }

    /**
     * Updates an existing Account model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Account model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Account model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Account the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Account::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
