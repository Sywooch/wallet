<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\transaction\Transaction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaction-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <div>
        <a href="#" class="btn btn-primary" role="add-incoming">Add incoming</a>
        <a href="#" class="btn btn-primary" role="add-outgoing">Add outgoing</a>
        <a href="#" class="btn btn-primary" role="add-expense">Add expense</a>
    </div>

    <div role="transaction-details">
        <div role="transaction-details-incoming">
            <h3>Incoming</h3>
            <?php foreach ($model->transactionIncomings as $__ITEM) : ?>
            <div>
                <?php include (__DIR__ . "/__incoming.php"); ?>
            </div>
            <?php endforeach; ?>
        </div>

        <div role="transaction-details-outgoing">
            <h3>Outgoing</h3>
            <?php foreach ($model->transactionOutgoings as $__ITEM) : ?>
            <div>
                <?php include (__DIR__ . "/__outgoing.php"); ?>
            </div>
            <?php endforeach; ?>
        </div>

        <div role="transaction-details-expense">
            <h3>Expense</h3>
            <?php foreach ($model->transactionExpenses as $__ITEM) : ?>
            <div>
                <?php include (__DIR__ . "/__expense.php"); ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>

<div role="transaction-details-add" style="//display: none;">
    <div role="new-incoming">
        <?php
            $__ITEM = null;
            include (__DIR__ . "/__incoming.php");
        ?>
    </div>
    <div role="new-outgoing">
        <?php
            $__ITEM = null;
            include (__DIR__ . "/__outgoing.php");
        ?>
    </div>
    <div role="new-expense">
        <?php
            $__ITEM = null;
            include (__DIR__ . "/__expense.php");
        ?>
    </div>
</div>

<script type="text/javascript">
$(function() {
    var generateNewId = function(type) {
        
    }
    $('[role="add-incoming"]').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        var div = $('[role="transaction-details-add"] [role="new-incoming"]').clone();
        div.removeAttr('role');
        div.appendTo('[role="transaction-details"] [role="transaction-details-incoming"]');
    });
    $('[role="add-outgoing"]').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        var div = $('[role="transaction-details-add"] [role="new-outgoing"]').clone();
        div.removeAttr('role');
        div.appendTo('[role="transaction-details"] [role="transaction-details-outgoing"]');
    });
    $('[role="add-expense"]').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        var div = $('[role="transaction-details-add"] [role="new-expense"]').clone();
        div.removeAttr('role');
        div.appendTo('[role="transaction-details"] [role="transaction-details-expense"]');
    });
})
</script>