<?php
use app\models\transaction\TransactionExpense;
use yii\helpers\ArrayHelper;
use app\models\contractor\Contractor;

if (is_null($__ITEM)) {
    $__ITEM = new TransactionExpense();
}
?>

<li class="expense" data-key="expense-<?= $__ITEM->id; ?>">
    &nbsp;
        <div role="contractor-container-expense-<?= $__ITEM->id; ?>">
        <?php if ($__ITEM->contractor_id && $__ITEM->contractor_id != $model->expenseContractorId) : ?>
            <?= $form->field($__ITEM, 'contractor_id')->label(false)->dropDownList(
                    ArrayHelper::merge(["" => "Select contractor"], Contractor::dropdown(Yii::$app->user->getId())),
                    ['role' => "expense-contractor"]
                ); ?>
        <?php else : ?>
            <a href="#" onclick="$(this).remove(); $('div[role=\'contractor-container-expense-<?= $__ITEM->id; ?>\'] select').show(); return false;">Specify contractor</a>
            <?= $form->field($__ITEM, 'contractor_id')->label(false)->dropDownList(
                    ArrayHelper::merge(["" => "Select contractor"], Contractor::dropdown(Yii::$app->user->getId())),
                    ['role' => "expense-contractor", 'style' => 'display: none;']
                ); ?>
        <?php endif; ?>
        </div>
        <?= $form->field($__ITEM, 'name')->label(false)->textInput(); ?>
        <?= $form->field($__ITEM, 'price')->label(false)->textInput(); ?>
        <?= $form->field($__ITEM, 'qty')->label(false)->textInput(); ?>
        <?= $form->field($__ITEM, 'sum')->label(false)->textInput(); ?>
        <div role="comment-container-expense-<?= $__ITEM->id; ?>">
        <?php if ($__ITEM->comment) : ?>
            <?= $form->field($__ITEM, 'comment')->label(false)->textarea(); ?>
        <?php else : ?>
            <a href="#" onclick="$(this).remove(); $('div[role=\'comment-container-expense-<?= $__ITEM->id; ?>\'] textarea').show(); return false;">Add comment</a>
            <?= $form->field($__ITEM, 'comment')->label(false)->textarea([
                'style' => 'display: none;'
            ]); ?>
        <?php endif; ?>
        </div>
        <hr/>
</li>