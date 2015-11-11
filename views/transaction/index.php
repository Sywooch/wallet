<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transactions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Transaction', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'date',
            ['class' => 'app\widgets\grid\TransactionDescriptionColumn'],
            ['class' => 'app\widgets\grid\TransactionExpensesColumn'],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>

</div>
