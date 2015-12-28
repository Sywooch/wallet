<?php

namespace app\controllers;

use Yii;
use app\models\transaction\Transaction;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TransactionController implements the CRUD actions for Transaction model.
 */
class TransactionController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Transaction models.
     * @return mixed
     */
    public function actionIndex()
    {
//        $b = new \app\models\account\Balance();
//        $b->account_id = 41;
//        $b->date = '2015-12-26';
//        $b->sum = 20;
//        $b->updateFuture(100);
//        ddump(0);
        $query = Transaction::find()->where(['user_id' => Yii::$app->user->getId()]);
        if (isset($_GET['date'])) {
            $dt = $_GET['date'];
            $query->andWhere("date BETWEEN '" . $dt . " 00:00:00' AND '" . $dt . " 23:59:59'");
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy(['date' => SORT_DESC]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Transaction model.
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
     * Creates a new Transaction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($type)
    {
        $model = new Transaction();
        $model->type = $type;
        $model->user_id = Yii::$app->user->getId();
        $loaded = $model->load(Yii::$app->request->post());
        
//        ddump($loaded, $_POST, $model);
        if ($loaded && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
//            ddump($model->errors);
            return $this->render('create', [
                'type' => $type,
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Transaction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $loaded = $model->load(Yii::$app->request->post());
        if ($loaded && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Transaction model.
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
     * Finds the Transaction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Transaction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transaction::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
