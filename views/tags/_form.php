<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\tag\Tag;

/* @var $this yii\web\View */
/* @var $model app\modules\tag\models\Tag */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tag-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'type')->dropDownList([ 'expense' => 'Expense', 'income' => 'Income', 'transfer' => 'Transfer',], ['prompt' => '']) ?>


    <?= $form->field($model, 'parent_id')->dropDownList(Tag::plainHierarcyForUser(Yii::$app->user->getId(), null, $model)); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('tag', 'Create') : Yii::t('tag', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
