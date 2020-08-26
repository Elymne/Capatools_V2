<?php

namespace app\models\projects\forms;

use app\models\projects\Consumable;

/**
 * Classe relative au modèle métier des dépenses.
 * Celle-ci permet de créer un formulaire de création de dépenses sur la création d'un projet et de vérifier la validité des données inscrites dans les champs.
 * Cette classe est a utiliser lorsque vous voulez créer une vue avec un formulaire depuis un contrôleur.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class ProjectCreateConsumableForm extends Consumable
{

    private $keyTypes = [
        self::TYPE_EXTERNAL_DELIVERY => 1,
        self::TYPE_CONSUMABLE => 2,
        self::TYPE_INTERNAL_DELIVERY => 3
    ];

    /**
     * Fonction provenant de la classe ActiveRecord, elle permet de vérifier l'intégrité des données.
     */
    public function rules()
    {
        return [
            [["title", "price", "type"], "safe"],
            ['title', 'required', 'message' => 'Vous devez au moins renseigner ce champ, si vous ne souhaitez pas ajouter dépenses, précisez le sur ce champ (ex : aucun + le prix à 0).'],
            ['price', 'required', 'message' => 'Vous devez au moins renseigner un prix.'],
        ];
    }

    public function getSelectedType(): int
    {

        if ($this->type == null)
            return 1;
        else
            return $this->keyTypes[$this->type];
    }
}
