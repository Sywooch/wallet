<?php
use app\models\account\Account;
use app\models\contractor\Contractor;
use app\models\transaction\TransactionIncoming;
use yii\helpers\ArrayHelper;

if (is_null($__ITEM)) {
    $__ITEM = new TransactionIncoming();
}
?>

Incoming <?= $__ITEM->id; ?>
<?= $form->field($__ITEM, 'account_id')->dropDownList(Account::plainHierarcyForUser(Yii::$app->user->getId())); ?>

<?= $form->field($__ITEM, 'contractor_id')->dropDownList(ArrayHelper::merge(["" => ""], Contractor::dropdown(Yii::$app->user->getId()))); ?>

<?= $form->field($__ITEM, 'sum')->textInput(); ?>
<?= $form->field($__ITEM, 'comment')->textarea(); ?>
<hr/>