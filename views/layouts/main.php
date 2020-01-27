<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\widgets\TopMenuBar;

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

TopMenuBar::begin();

TopMenuBar::widget();
TopMenuBar::end();

?>





        <ul id="sidenav-left" class="sidenav sidenav-fixed">
        <li><a href="<?= Yii::$app->homeUrl?>" class="logo-container"><?= Html::encode(Yii::$app->name) ?><i class="material-icons left"><img src="<?= Html::encode(Yii::$app->homeUrl) ?>images/logo.png"/></i></a></li>
        <li class="no-padding">
          <ul class="collapsible collapsible-accordion">
            <li class="bold waves-effect active"><a class="collapsible-header">Pages<i class="material-icons chevron">chevron_left</i></a>
              <div class="collapsible-body">
                <ul>
                  <li><a href="/pages/admin-dashboard" class="waves-effect active">Dashboard<i class="material-icons">web</i></a></li>
                  <li><a href="/pages/admin-fixed-chart" class="waves-effect">Fixed Chart<i class="material-icons">list</i></a></li>
                  <li><a href="/pages/admin-grid" class="waves-effect">Grid<i class="material-icons">dashboard</i></a></li>
                  <li><a href="/pages/admin-chat" class="waves-effect">Chat<i class="material-icons">chat</i></a></li>
                </ul>
              </div>
            </li>
            <li class="bold waves-effect"><a class="collapsible-header">Charts<i class="material-icons chevron">chevron_left</i></a>
              <div class="collapsible-body">
                <ul>
                  <li><a href="/pages/admin-line-charts" class="waves-effect">Line Charts<i class="material-icons">show_chart</i></a></li>
                  <li><a href="/pages/admin-bar-charts" class="waves-effect">Bar Charts<i class="material-icons">equalizer</i></a></li>
                  <li><a href="/pages/admin-area-charts" class="waves-effect">Area Charts<i class="material-icons">multiline_chart</i></a></li>
                  <li><a href="/pages/admin-doughnut-charts" class="waves-effect">Doughnut Charts<i class="material-icons">pie_chart</i></a></li>
                  <li><a href="/pages/admin-financial-charts" class="waves-effect">Financial Charts<i class="material-icons">euro_symbol</i></a></li>
                  <li><a href="/pages/admin-interactive-charts" class="waves-effect">Interactive Charts<i class="material-icons">touch_app</i></a></li>
                </ul>
              </div>
            </li>
            <li class="bold waves-effect"><a class="collapsible-header">Tables<i class="material-icons chevron">chevron_left</i></a>
              <div class="collapsible-body">
                <ul>
                  <li><a href="/pages/admin-fullscreen-table" class="waves-effect">Fullscreen with Chart<i class="material-icons">show_chart</i></a></li>
                  <li><a href="/pages/admin-table-custom-elements" class="waves-effect">Table with Custom Elements<i class="material-icons">settings</i></a></li>
                </ul>
              </div>
            </li>
            <li class="bold waves-effect"><a class="collapsible-header">Calendar<i class="material-icons chevron">chevron_left</i></a>
              <div class="collapsible-body">
                <ul>
                  <li><a href="/pages/admin-calendar" class="waves-effect">Calendar<i class="material-icons">cloud</i></a></li>
                </ul>
              </div>
            </li>
            <li class="bold waves-effect"><a class="collapsible-header">Headers<i class="material-icons chevron">chevron_left</i></a>
              <div class="collapsible-body">
                <ul>
                  <li><a href="/pages/admin-header-tabbed" class="waves-effect">Tabbed<i class="material-icons">tab</i></a></li>
                  <li><a href="/pages/admin-header-metrics" class="waves-effect">Metrics<i class="material-icons">web</i></a></li>
                  <li><a href="/pages/admin-header-search" class="waves-effect">Search<i class="material-icons">search</i></a></li>
                </ul>
              </div>
            </li>
            <li class="bold waves-effect"><a class="collapsible-header">Account<i class="material-icons chevron">chevron_left</i></a>
              <div class="collapsible-body">
                <ul>
                  <li><a href="/pages/admin-log-in" class="waves-effect">Log In<i class="material-icons">person</i></a></li>
                  <li><a href="/pages/admin-settings" class="waves-effect">Settings<i class="material-icons">settings</i></a></li>
                </ul>
              </div>
            </li>
          </ul>
        </li>
      </ul>



      <div id="dropdown1" class="dropdown-content notifications">
        <div class="notifications-title">notifications</div>
        <div class="card">
          <div class="card-content"><span class="card-title">Joe Smith made a purchase</span>
            <p>Content</p>
          </div>
          <div class="card-action"><a href="#!">view</a><a href="#!">dismiss</a></div>
        </div>
        <div class="card">
          <div class="card-content"><span class="card-title">Daily Traffic Update</span>
            <p>Content</p>
          </div>
          <div class="card-action"><a href="#!">view</a><a href="#!">dismiss</a></div>
        </div>
        <div class="card">
          <div class="card-content"><span class="card-title">New User Joined</span>
            <p>Content</p>
          </div>
          <div class="card-action"><a href="#!">view</a><a href="#!">dismiss</a></div>
        </div>
      </div>

    <div class="container">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Capacites <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>

<script type="text/javascript">
  $(document).ready(function(){
    $('.collapsible').collapsible();
	$('.sidenav').sidenav();
	$('.dropdown-trigger').dropdown({constrainWidth: false, alignment: 'left'});
	$('.fixed-action-btn').floatingActionButton();
	$('.tooltipped').tooltip();
  });
</script>

</html>
<?php $this->endPage() ?>
