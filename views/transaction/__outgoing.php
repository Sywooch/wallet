<?php

use app\models\account\Account;
use app\models\contractor\Contractor;
use app\models\transaction\TransactionOutgoing;
use yii\helpers\ArrayHelper;

if (is_null($__ITEM)) {
    $__ITEM = new TransactionOutgoing();
}
?>
<li class="outgoing" data-key="outgoing-<?= $__ITEM->id; ?>">
    <?= $form->field($__ITEM, 'account_id')->label(false)->dropDownList(ArrayHelper::merge(["" => "Select account"], Account::plainHierarcyForUser(Yii::$app->user->getId()))); ?>
    <?= $form->field($__ITEM, 'sum')->label(false)->textInput(); ?>
    <div role="comment-container-outgoing-<?= $__ITEM->id; ?>">
    <?php if ($__ITEM->comment) : ?>
        <?= $form->field($__ITEM, 'comment')->label(false)->textarea(); ?>
    <?php else : ?>
        <a href="#" onclick="$(this).remove(); $('div[role=\'comment-container-outgoing-<?= $__ITEM->id; ?>\'] textarea').show(); return false;">Add comment</a>
        <?= $form->field($__ITEM, 'comment')->label(false)->textarea([
            'style' => 'display: none;'
        ]); ?>
    <?php endif; ?>
    </div>
    <hr/>
</li>