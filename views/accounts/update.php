<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\account\models\Account */

$this->title = Yii::t('account', 'Update {modelClass}: ', [
    'modelClass' => 'Account',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('account', 'Accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('account', 'Update');
?>
<div class="account-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'balance' => $balance,
    ]) ?>

</div>
