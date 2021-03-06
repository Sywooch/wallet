<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\contractor\Contractor */

$this->title = Yii::t('contractor', 'Create {modelClass}', [
    'modelClass' => 'Contractor',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('contractor', 'Contractors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contractor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
