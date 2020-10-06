<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use app\assets\AppAsset;
use app\assets\LoginAsset;

AppAsset::register($this);
LoginAsset::register($this);

$backgroundImage = 'https://admin.preprod.capatools.fr/web/';

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

<body class="has-fixed-sidenav welcomeBg" id="body-login">
    <?php $this->beginBody(); ?>

    <div class="container">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>

    <?php $this->endBody() ?>


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
</body>

</html>
<?php $this->endPage() ?>