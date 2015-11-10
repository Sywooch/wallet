<?php
use app\models\transaction\TransactionOutgoing;
use app\models\account\Account;

if (is_null($__ITEM)) {
    $__ITEM = new TransactionOutgoing();
}
?>
<div class="outgoing" data-key="<?= $__ITEM->id; ?>" class="form-inline">
    <?= $form->field($__ITEM, 'account_id')->label(false)->dropDownList(Account::plainHierarcyForUser(Yii::$app->user->getId())); ?>
    <?= $form->field($__ITEM, 'sum')->label(false)->textInput(); ?>
    <div role="comment-container-<?= $__ITEM->id; ?>">
    <?php if ($__ITEM->comment) : ?>
        <?= $form->field($__ITEM, 'comment')->label(false)->textarea(); ?>
    <?php else : ?>
        <a href="#" onclick="$(this).remove(); $('div[role=\'comment-container-<?= $__ITEM->id; ?>\'] textarea').show(); return false;">Add comment</a>
        <?= $form->field($__ITEM, 'comment')->label(false)->textarea([
            'style' => 'display: none;'
        ]); ?>
    <?php endif; ?>
    </div>
    <hr/>
</div>