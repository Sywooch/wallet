<?php
use app\models\account\Account;
use app\models\contractor\Contractor;
use app\models\transaction\TransactionIncoming;
use yii\helpers\ArrayHelper;

if (is_null($__ITEM)) {
    $__ITEM = new TransactionIncoming();
}
?>

<li class="incoming" data-key="incoming-<?= $__ITEM->id; ?>">
    <?= $form->field($__ITEM, 'account_id')->label(false)->dropDownList(ArrayHelper::merge(["" => "Select account"], Account::plainHierarcyForUser(Yii::$app->user->getId()))); ?>
    <?= $form->field($__ITEM, 'contractor_id')->label(false)->dropDownList(ArrayHelper::merge(["" => "Select contractor"], Contractor::dropdown(Yii::$app->user->getId()))); ?>
    <?= $form->field($__ITEM, 'sum')->label(false)->textInput(); ?>
    <div role="comment-container-incoming-<?= $__ITEM->id; ?>">
    <?php if ($__ITEM->comment) : ?>
        <?= $form->field($__ITEM, 'comment')->label(false)->textarea(); ?>
    <?php else : ?>
        <a href="#" onclick="$(this).remove(); $('div[role=\'comment-container-incoming-<?= $__ITEM->id; ?>\'] textarea').show(); return false;">Add comment</a>
        <?= $form->field($__ITEM, 'comment')->label(false)->textarea([
            'style' => 'display: none;'
        ]); ?>
    <?php endif; ?>
    </div>
    <hr/>
</li>
