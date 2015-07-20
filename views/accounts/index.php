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
                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>
                    <?php if (!$model->virtual) : ?>
                        <a href="<?= Url::toRoute(['/transfer/incoming/create', 'account' => $model->id]); ?>">Income</a>
                        Transfer
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>