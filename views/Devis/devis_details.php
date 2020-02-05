<?php

use yii\widgets\DetailView;

$this->title = $query->id_capa;

topHtml($query);

displayDetails($query);

bottomHtml($query);







function displayDetails($query)
{

    echo DetailView::widget([
        'model' => $query,
        'attributes' => [
            [
                'label' => 'Identifiant Capacites',
                'value' => $query->id_capa,
                'contentOptions' => ['class' => 'bg-red'],     // HTML attributes to customize value tag
                'captionOptions' => ['tooltip' => 'Tooltip']
            ],
            [
                'label' => 'Cellule',
                'value' => $query->unit->name,
                'contentOptions' => ['class' => 'bg-red'],     // HTML attributes to customize value tag
                'captionOptions' => ['tooltip' => 'Tooltip']
            ],
            [
                'label' => 'Nom du client',
                'value' => $query->client->name,
                'contentOptions' => ['class' => 'bg-red'],     // HTML attributes to customize value tag
                'captionOptions' => ['tooltip' => 'Tooltip']
            ],
            [
                'label' => 'Nature du client',
                'value' => $query->client->type,
                'contentOptions' => ['class' => 'bg-red'],     // HTML attributes to customize value tag
                'captionOptions' => ['tooltip' => 'Tooltip']
            ],
            [
                'label' => 'Nature du client',
                'value' => $query->client->type,
                'contentOptions' => ['class' => 'bg-red'],     // HTML attributes to customize value tag
                'captionOptions' => ['tooltip' => 'Tooltip']
            ],
            [
                'label' => 'Responsable du projet',
                'value' => $query->projectManager->fullname,
                'contentOptions' => ['class' => 'bg-red'],     // HTML attributes to customize value tag
                'captionOptions' => ['tooltip' => 'Tooltip']
            ],
            [
                'label' => 'TVA',
                'value' => $query->tva,
                'contentOptions' => ['class' => 'bg-red'],     // HTML attributes to customize value tag
                'captionOptions' => ['tooltip' => 'Tooltip']
            ],
            [
                'label' => 'durée de la prestation',
                'value' => $query->service_duration,
                'contentOptions' => ['class' => 'bg-red'],     // HTML attributes to customize value tag
                'captionOptions' => ['tooltip' => 'Tooltip']
            ],
            [
                'label' => 'Nom du fichier',
                'value' => $query->filename,
                'contentOptions' => ['class' => 'bg-red'],     // HTML attributes to customize value tag
                'captionOptions' => ['tooltip' => 'Tooltip']
            ],
            [
                'label' => 'Version du fichier',
                'value' => $query->version,
                'contentOptions' => ['class' => 'bg-red'],     // HTML attributes to customize value tag
                'captionOptions' => ['tooltip' => 'Tooltip']
            ],
            [
                'label' => 'Date de création du devis',
                'value' => $query->filename_first_upload,
                'contentOptions' => ['class' => 'bg-red'],     // HTML attributes to customize value tag
                'captionOptions' => ['tooltip' => 'Tooltip']
            ],
            [
                'label' => 'Date de la dernière modification du devis',
                'value' => $query->filename_last_upload,
                'contentOptions' => ['class' => 'bg-red'],     // HTML attributes to customize value tag
                'captionOptions' => ['tooltip' => 'Tooltip']
            ],
        ]
    ]);
}

function topHtml($query)
{ ?>

    <h3>
        Devis : <?php echo $query->internal_name; ?>
    </h3>

<?php }


function bottomHtml($query)
{ ?>

    <a class="waves-effect waves-light btn">button</a>

<?php }
