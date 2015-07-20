<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\account\models\Account */

$this->title = Yii::t('account', 'Create {modelClass}', [
    'modelClass' => 'Account',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('account', 'Accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'balance' => $balance,
    ]) ?>

</div>
