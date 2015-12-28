<?php
/* @var $this yii\web\View */
?>
<h1>Credits</h1>

<div>
    Total: <?= count($models); ?>
</div>

<div>
    <?php foreach ($models as $model) : ?>
    <div>
        <h3><?= $model->title; ?></h3>
    </div>
    <?php endforeach; ?>
</div>