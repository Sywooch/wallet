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
        <?= Html::a('Income', ['create', 'type' => 'income'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Expense', ['create', 'type' => 'expense'], ['class' => 'btn btn-danger']) ?>
        <?= Html::a('Transfer', ['create', 'type' => 'transfer'], ['class' => 'btn btn-warning']) ?>
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
