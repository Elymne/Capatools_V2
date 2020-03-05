<?php

use app\widgets\TopTitle;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\user\CapaUser */

$this->title = "Détail du salarié: " . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Capaidentities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>

<?= TopTitle::widget(['title' => $this->title]) ?>

<div class="container">
    <div class="capa_user-view">

        <div class="row">
            <div class="card">

                <div class="card-content">
                    <p>
                        <?= Html::a('Modifier <i class="material-icons right">mode_edit</i>', ['update', 'id' => $model->id], ['class' => 'waves-effect orange waves-light btn']) ?>
                        <?= Html::a('Supprimer <i class="material-icons right">delete</i> ', ['delete', 'id' => $model->id], [
                            'class' => 'waves-effect waves-light btn red',
                            'data' => [
                                'confirm' => 'Etes vous sûr de vouloir supprimer ce salarié ?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>
                </div>

                <div class="card-content">
                    <?= DetailView::widget([
                        'model' => $model,
                        'options' => [
                            'class' => ['highlight']
                        ],
                        'attributes' => [
                            [
                                'label' => 'Nom et prénom',
                                'attribute' => 'username',
                            ],
                            'email:email',
                            [
                                'label' => 'Nom de la cellule',
                                'attribute' => 'cellule.name',
                            ],
                        ],
                    ]) ?>

                    <br /><br /><br />

                    <?php echo createRolesTable($userRoles); ?>

                </div>

            </div>
        </div>

    </div>
</div>

<?php

function createRolesTable($userRoles)
{

    $head = <<<HTML

        <table class="highlight">
            <tbody>
                <tr>
                    <td class='header'>Rôles</td>
                    <td class='header'>Description</td>
                </tr>

            
    HTML;

    $body = '';

    foreach ($userRoles as $userRole) {

        $roleName = $userRole->name;
        $roleDescription = $userRole->description;

        $body = $body . <<<HTML
            <tr>
                <td>${roleName}</td>
                <td>${roleDescription}</td>
            </tr>
        HTML;
    }

    $foot = <<<HTML
            </tbody>
        </table>
    HTML;

    return $head . $body . $foot;
}
