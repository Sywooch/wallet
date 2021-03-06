<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\account\models\AccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('account', 'Accounts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('account', 'Create {modelClass}', [
    'modelClass' => 'Account',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <table>
        <thead>
            <tr>
                <td>Name</td>
                <td>Sum</td>
                <td>Incoming</td>
                <td>Outgoing</td>
                <td>&nbsp;</td>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($models as $model) : ?>
            <tr>
                <td style="padding-left: <?=15*$model->level;?>px">
                    <a href="<?= Url::toRoute(['/accounts/view', 'id' => $model->id]); ?>"><?= $model->title; ?></a>
                    <?php if (!$model->virtual) : ?>
                        <?php if ($model->type == 'credit') : ?>
                            <div style="text-align: right;"><small><?= sprintf('%.2f%%', $model->percent);?></small></div>
                        <?php endif; ?>
                        <?php if ($model->type == 'creditcard') : ?>
                            <div style="text-align: right;">
                                <small><?= $model->renderFinance($model->credit_card_limit); ?>
                                <br/><small><?= sprintf('%.2f%%', $model->percent);?></small>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if (!$model->virtual) : ?>
                        <?= ($model->getBalance($date)) ? $model->renderFinance($model->getBalance($date)->sum) : ""; ?>
                        (<?= ($model->getBalance($date)) ? $model->getBalance($date)->date : ""; ?>)
                    <?php else : ?>
                        &nbsp;
                    <?php endif; ?>
                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>
                    <?php if (!$model->virtual) : ?>
                        <a href="<?= Url::toRoute(['/transaction/create', 'type' => 'income', 'to' => $model->id]); ?>">Income</a>
                        <a href="<?= Url::toRoute(['/transaction/create', 'type' => 'transfer', 'from' => $model->id]); ?>">Transfer</a>
                        Transfer
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
