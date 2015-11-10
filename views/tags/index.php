<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\tag\models\TagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('tag', 'Tags');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('tag', 'Create {modelClass}', [
    'modelClass' => 'Tag',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Type</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($models as $model) : ?>
            <tr data-key="<?= $model->id; ?>">
                <td><?= $model->id; ?></td>
                <td style="padding-left: <?=10+15*$model->level;?>px"><?= $model->name; ?></td>
                <td><?= $model->type; ?></td>
                <td>
                    <a href="/tags/<?=$model->id;?>" title="View" aria-label="View" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a> 
                    <a href="/tags/update/<?=$model->id;?>" title="Update" aria-label="Update" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a> 
                    <a href="/tags/delete/<?=$model->id;?>" title="Delete" aria-label="Delete" data-confirm="Are you sure you want to delete this item?" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash"></span></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>
