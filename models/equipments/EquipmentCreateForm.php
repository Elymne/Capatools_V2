<?php

namespace app\models\equipments;

/**
 * Classe relative au modèle métier des équipements.
 * Celle-ci permet de créer un formulaire de création d'un matériel et de vérifier la validité des données inscrites dans les champs.
 * 
 * Cette classe est a utiliser lorsque vous voulez créer une vue avec un formulaire depuis le contrôleur (contrôleur Administration ici).
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class EquipmentCreateForm extends Equipment
{

    /**
     * Fonction provenant de la classe ActiveRecord, elle permet de vérifier l'intégrité des données.
     */
    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'Veulliez renseigner le nom du matériel'],
            ['price_day', 'required', 'message' => 'Veulliez renseigner le prix journalier du matériel'],
            ['price_hour', 'required', 'message' => 'Veulliez renseigner le prix horaire du matériel'],
            ['type', 'required', 'message' => 'Veulliez renseigner le type du matériel'],
            ['laboratory', 'required', 'message' => 'Veulliez renseigner le laboratoire'],
        ];
    }
}
