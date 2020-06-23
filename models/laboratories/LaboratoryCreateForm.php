<?php

namespace app\models\laboratories;

/**
 * Classe relative au modèle métier des laboratoires.
 * Celle-ci permet de créer un formulaire de création d'un laboratoire et de vérifier la validité des données inscrites dans les champs.
 * 
 * Cette classe est a utiliser lorsque vous voulez créer une vue avec un formulaire depuis un contrôleur.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class LaboratoryCreateForm extends Laboratory
{

    /**
     * Fonction surchargée de la classe ActiveRecord, elle permet de vérifier l'intégrité des données dans un modèle.
     */
    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'Veulliez renseigner le nom du laboratoire'],
            ['price_contributor_day', 'required', 'message' => 'Veulliez définir le prix/jour d\'un intervenant'],
            ['price_contributor_hour', 'required', 'message' => 'Veulliez définir le prix/heure d\'un intervenant'],
            ['price_ec_day', 'required', 'message' => 'Veulliez définir le prix/heure d\'un EC'],
            ['price_ec_hour', 'required', 'message' => 'Veulliez définir le prix/heure d\'un EC'],
            ['cellule', 'required', 'message' => 'Veulliez renseigner la cellule rattaché au laboratoire']
        ];
    }
}
