<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\ArrayHelper;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'My Wallet',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $userBarNav = Yii::$app->user->isGuest ? [['label' => 'Login', 'url' => ['/user/default/login']], ['label' => 'Sign up', 'url' => ['/user/default/signup']]] :
                        [['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                            'url' => ['/user/default/logout'],
                            'linkOptions' => ['data-method' => 'post']]
                        ];

            $userActionsBar = Yii::$app->user->isGuest ? [] : [
                                                                        ['label' => 'Accounts', 'url' => ['/accounts/index']],
                                                                        ['label' => 'Contractors', 'url' => ['/contractors/index']],
                                                                        ['label' => 'Tags', 'url' => ['/tags/index']],
                                                                        ['label' => 'Transactions', 'url' => ['/transaction/index']],
                                                              ];

            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => ArrayHelper::merge(
                    [['label' => 'Home', 'url' => ['/site/index']]],
                    $userActionsBar,
                    [
                        ['label' => 'About', 'url' => ['/site/about']],
                        ['label' => 'Contact', 'url' => ['/site/contact']],
                    ],
                    $userBarNav
                ),
            ]);
            NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; My Wallet <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
