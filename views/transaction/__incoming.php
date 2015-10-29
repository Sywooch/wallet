<?php
use app\models\account\Account;
use app\models\transaction\TransactionIncoming;
if (is_null($__ITEM)) {
    $__ITEM = new TransactionIncoming();
}
?>

Incoming <?= $__ITEM->id; ?>
<?= $form->field($__ITEM, 'account_id')->dropDownList(Account::plainHierarcyForUser(Yii::$app->user->getId())); ?>

<div class="form-group field-transaction-incoming-<?= $__ITEM->id;?>-contractor_id required">
<label class="control-label" for="transaction-user_id">Contractor ID</label>
<input type="text" id="transaction-user_id" class="form-control" name="Transaction[incoming][$__ITEM->id][contractor_id]">
</div>

<div>Sum</div>

<div>Comment</div>