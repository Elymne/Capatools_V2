<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use app\assets\AppAsset;
use app\widgets\TopMenuBar;
use app\widgets\LeftMenuBar;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="has-fixed-sidenav">
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
            <div class="container">
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
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
        $('.collapsible').collapsible();
        $('.sidenav').sidenav();
        $('.dropdown-trigger').dropdown({
            constrainWidth: false,
            alignment: 'left'
        });
        $('.fixed-action-btn').floatingActionButton();
        $('.tooltipped').tooltip();
    });
</script>

</html>
<?php $this->endPage() ?>