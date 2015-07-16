<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\tag\models\Tag */

$this->title = Yii::t('tag', 'Update {modelClass}: ', [
    'modelClass' => 'Tag',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('tag', 'Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('tag', 'Update');
?>
<div class="tag-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
