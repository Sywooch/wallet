<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\contractor\Contractor;
/* @var $this yii\web\View */
/* @var $model app\models\transaction\Transaction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaction-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <div>
        <a href="#" class="btn btn-primary" role="add-incoming">Add incoming</a>
        <a href="#" class="btn btn-primary" role="add-outgoing">Add outgoing</a>
        <a href="#" class="btn btn-primary" role="add-expense">Add comissions</a>
    </div>

    <div role="transaction-details">
        <div role="transaction-details-outgoing">
            <h3>From</h3>
            <ol>
                <?php foreach ($model->transactionOutgoings as $__ITEM) : ?>
                    <?php include (__DIR__ . "/__outgoing.php"); ?>
                <?php endforeach; ?>
            </ol>
        </div>
        <div role="transaction-details-incoming">
            <h3>To</h3>
            <ol>
                <?php foreach ($model->transactionIncomings as $__ITEM) : ?>
                    <?php include (__DIR__ . "/__incoming.php"); ?>
                <?php endforeach; ?>
            </ol>
        </div>

        <div role="transaction-details-expense">
            <h3>Comissions</h3>
            <ol>
            <?php foreach ($model->transactionExpenses as $__ITEM) : ?>
                <?php include (__DIR__ . "/__expense.php"); ?>
            <?php endforeach; ?>
            </ol>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>

<div role="transaction-details-add" style="display: none;">
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
$(function () {
    <?php if (!count($model->transactionIncomings)) : ?>
    $('[role="add-incoming"]').click();
    <?php endif; ?>
        
    <?php if (!count($model->transactionOutgoings)) : ?>
    $('[role="add-outgoing"]').click();
    <?php endif; ?>
});
</script>
