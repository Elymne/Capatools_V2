<?php

use yii\db\Migration;

/**
 * Generate all devis access for users.
 * Access are stocked in php script file.
 */
class m200800_000002_rh_rbac extends Migration
{

    // S'inspirer des deux autres fichiers m200800_000000_devis_rbac et m200800_000001_administration_rbac.

    // Pour tout réini, tu dois supprimer les fichiers générés dans le dossier rbac. 
    // Tu dois aussi reset ta base de données de test. Ensuite, tu fais un migrate.

    // TODO gérer les rôles RH ici.
    // Créer une permission pour chaque fonction du contrôleur RH.
    // Créer les différents rôles utilisateurs à partir des permissions créées.

    // Attribuer ces permissions à des utilisateurs pour faire des tests.

    // Une fois les rôles créés, le reste se gère dans les controleurs. Tu dois associer chaque permission crée à une fonction du controleur.
    // Regarde sur le contrôleur Devis pour voir.

}
