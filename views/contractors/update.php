<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\contractor\Contractor */

$this->title = Yii::t('contractor', 'Update {modelClass}: ', [
    'modelClass' => 'Contractor',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('contractor', 'Contractors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('contractor', 'Update');
?>
<div class="contractor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
