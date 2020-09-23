<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use app\assets\AppAsset;
use app\widgets\TopMenuBar;
use app\widgets\LeftMenuBar;

AppAsset::register($this);
$bread =  '' . Yii::$app->homeUrl . 'images/breadcrumb.png';
$iconcapa = Yii::$app->homeUrl . '/favicon.png';
?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>

    <link rel="apple-touch-icon" sizes="57x57" href="capaicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="capaicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="capaicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="capaicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="capaicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="capaicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="capaicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="capaicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="capaicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="capaicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="capaicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="capaicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="capaicon/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="capaicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">


    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">



    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="vertical-layout page-header-light vertical-menu-collapsible vertical-dark-menu preload-transitions 2-columns" data-open="click" data-menu="vertical-dark-menu" data-col="2-columns">
    <?php $this->beginBody();
    if (!Yii::$app->user->isGuest && Yii::$app->controller->action->id != 'firstlogin') {

        TopMenuBar::begin();
        TopMenuBar::widget();
        TopMenuBar::end();

        LeftMenuBar::begin();
        LeftMenuBar::widget();
        LeftMenuBar::end();
    }
    ?>

    <div id="main">
        <div class="row">
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>


    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; Capacites <?= date('Y') ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

<script type="text/javascript">
    $(document).ready(function() {
        $(' .collapsible').collapsible();
        $('.sidenav').sidenav();
        $('.dropdown-trigger').dropdown({
            constrainWidth: false,
            alignment: 'left'
        });
        $('.fixed-action-btn').floatingActionButton();
        $('.tooltipped').tooltip();
    });
</script>

</html> <?php $this->endPage() ?> <?php
