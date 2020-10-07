<?php

use app\services\userRoleAccessServices\PermissionAccessEnum;
use app\services\userRoleAccessServices\UserRoleEnum;
use yii\db\Migration;

/**
 * Classe de migration qui permet de générer les permissions de l'application.
 * Les accès sont générés dans un fichier et non en base de données.
 */
class m200800_000050_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $auth = Yii::$app->authManager;

        /** CREATION DES PERMISSIONS */

        /**
         * Création des permissions d'accès au service projet de l'application.
         */
        $projectIndex = $auth->createPermission(PermissionAccessEnum::PROJECT_INDEX);
        $projectIndexDraft = $auth->createPermission(PermissionAccessEnum::PROJECT_INDEX_DRAFT);
        $projectView = $auth->createPermission(PermissionAccessEnum::PROJECT_VIEW);
        $projectUpdateStatus = $auth->createPermission(PermissionAccessEnum::PROJECT_UPDATE_STATUS);
        $projectUpdateMilestoneStatus = $auth->createPermission(PermissionAccessEnum::PROJECT_UPDATE_MILESTONE_STATUS);
        $projectPdf = $auth->createPermission(PermissionAccessEnum::PROJECT_PDF);
        $projectCreate = $auth->createPermission(PermissionAccessEnum::PROJECT_CREATE);
        $projectUpdate = $auth->createPermission(PermissionAccessEnum::PROJECT_UPDATE);
        $projectDelete = $auth->createPermission(PermissionAccessEnum::PROJECT_DELETE);

        $auth->add($projectIndex);
        $auth->add($projectIndexDraft);
        $auth->add($projectView);
        $auth->add($projectUpdateStatus);
        $auth->add($projectUpdateMilestoneStatus);
        $auth->add($projectPdf);
        $auth->add($projectCreate);
        $auth->add($projectUpdate);
        $auth->add($projectDelete);


        /**
         * Création des permissions d'accès au service administration de l'application.
         */
        $adminIndex = $auth->createPermission(PermissionAccessEnum::ADMIN_INDEX);
        $adminCreate = $auth->createPermission(PermissionAccessEnum::ADMIN_CREATE);
        $adminView = $auth->createPermission(PermissionAccessEnum::ADMIN_VIEW);
        $adminUpdate = $auth->createPermission(PermissionAccessEnum::ADMIN_UPDATE);
        $adminDelete = $auth->createPermission(PermissionAccessEnum::ADMIN_DELETE);
        $adminDevisParametersView = $auth->createPermission(PermissionAccessEnum::ADMIN_DEVIS_PARAMETERS_VIEW);
        $adminDevisParametersUpdate = $auth->createPermission(PermissionAccessEnum::ADMIN_DEVIS_PARAMETERS_UPDATE);
        $adminEquipementIndex = $auth->createPermission(PermissionAccessEnum::ADMIN_EQUIPEMENT_INDEX);
        $adminEquipementCreate = $auth->createPermission(PermissionAccessEnum::ADMIN_EQUIPEMENT_CREATE);

        $auth->add($adminIndex);
        $auth->add($adminCreate);
        $auth->add($adminView);
        $auth->add($adminUpdate);
        $auth->add($adminDelete);
        $auth->add($adminDevisParametersView);
        $auth->add($adminDevisParametersUpdate);
        $auth->add($adminEquipementIndex);
        $auth->add($adminEquipementCreate);


        /**
         * Création des permissions d'accès au service société de l'application.
         */
        $companyIndex = $auth->createPermission(PermissionAccessEnum::COMPANY_INDEX);
        $companyCreate = $auth->createPermission(PermissionAccessEnum::COMPANY_CREATE);
        $companyView = $auth->createPermission(PermissionAccessEnum::COMPANY_VIEW);
        $companyUpdate = $auth->createPermission(PermissionAccessEnum::COMPANY_UPDATE);
        $companyDelete = $auth->createPermission(PermissionAccessEnum::COMPANY_DELETE);

        $companyContactIndex = $auth->createPermission(PermissionAccessEnum::COMPANY_CONTACT_INDEX);
        $companyContactCreate = $auth->createPermission(PermissionAccessEnum::COMPANY_CONTACT_CREATE);
        $companyContactView = $auth->createPermission(PermissionAccessEnum::COMPANY_CONTACT_VIEW);
        $companyContactUpdate = $auth->createPermission(PermissionAccessEnum::COMPANY_CONTACT_UPDATE);
        $companyContactDelete = $auth->createPermission(PermissionAccessEnum::COMPANY_CONTACT_DELETE);

        $auth->add($companyIndex);
        $auth->add($companyCreate);
        $auth->add($companyView);
        $auth->add($companyUpdate);
        $auth->add($companyDelete);
        $auth->add($companyContactIndex);
        $auth->add($companyContactCreate);
        $auth->add($companyContactView);
        $auth->add($companyContactUpdate);
        $auth->add($companyContactDelete);


        /** CREATION DES RÔLES */

        /**
         * Création des rôles d'accès de l'application.
         */
        $salaryRole = $auth->createRole(UserRoleEnum::SALARY);
        $projectManagerRole = $auth->createRole(UserRoleEnum::PROJECT_MANAGER);
        $celluleManagerRole = $auth->createRole(UserRoleEnum::CELLULE_MANAGER);
        $accountingSupportRole = $auth->createRole(UserRoleEnum::ACCOUNTING_SUPPORT);
        $humanRessourcesRole = $auth->createRole(UserRoleEnum::HUMAN_RESSOURCES);
        $adminRole = $auth->createRole(UserRoleEnum::ADMIN);
        $superAdminRole = $auth->createRole(UserRoleEnum::SUPER_ADMIN);

        $auth->add($salaryRole);
        $auth->add($projectManagerRole);
        $auth->add($celluleManagerRole);
        $auth->add($accountingSupportRole);
        $auth->add($humanRessourcesRole);
        $auth->add($adminRole);
        $auth->add($superAdminRole);


        /** ATTRIBUTION DES PERMISSIONS AUX RÔLES */

        /**
         * Attribution des permissions au rôle de chef de projet.
         * Ce rôle pourra accéder à ces fonctionnalités cependant, notons ceci :
         *  - Il ne peut voir que les devis dont il fait parti ou qu'il a créé.
         *  - Il ne peut modifier que les devis dont il est le chef de projet.
         */
        $auth->addChild($projectManagerRole, $projectIndex);
        $auth->addChild($projectManagerRole, $projectIndexDraft);
        $auth->addChild($projectManagerRole, $projectView);
        $auth->addChild($projectManagerRole, $projectUpdateStatus);
        $auth->addChild($projectManagerRole, $projectUpdateMilestoneStatus);
        $auth->addChild($projectManagerRole, $projectPdf);
        $auth->addChild($projectManagerRole, $projectCreate);
        $auth->addChild($projectManagerRole, $projectUpdate);
        $auth->addChild($projectManagerRole, $projectDelete);

        $auth->addChild($projectManagerRole, $companyIndex);
        $auth->addChild($projectManagerRole, $companyCreate);
        $auth->addChild($projectManagerRole, $companyView);
        $auth->addChild($projectManagerRole, $companyUpdate);
        $auth->addChild($projectManagerRole, $companyDelete);
        $auth->addChild($projectManagerRole, $companyContactIndex);
        $auth->addChild($projectManagerRole, $companyContactCreate);
        $auth->addChild($projectManagerRole, $companyContactUpdate);
        $auth->addChild($projectManagerRole, $companyContactView);
        $auth->addChild($projectManagerRole, $companyContactDelete);

        /**
         * Attribution des permissions au rôle de responsable de cellule.
         * Ce rôle pourra accéder à ces fonctionnalités cependant, notons ceci :
         *  - Il ne peut voir que les devis de sa cellule.
         *  - Il ne peut modifier que les devis de sa cellule.
         */
        //TODO A voir.

        $auth->addChild($celluleManagerRole, $companyIndex);
        $auth->addChild($celluleManagerRole, $companyCreate);
        $auth->addChild($celluleManagerRole, $companyView);
        $auth->addChild($celluleManagerRole, $companyUpdate);
        $auth->addChild($celluleManagerRole, $companyDelete);
        $auth->addChild($celluleManagerRole, $companyContactIndex);
        $auth->addChild($celluleManagerRole, $companyContactCreate);
        $auth->addChild($celluleManagerRole, $companyContactUpdate);
        $auth->addChild($celluleManagerRole, $companyContactView);
        $auth->addChild($celluleManagerRole, $companyContactDelete);
        /**
         * Attribution des permissions au rôle de support.
         * Il peut voir tous les projets existants mais ne peut les modifier.
         */
        $auth->addChild($accountingSupportRole, $projectIndex);
        $auth->addChild($accountingSupportRole, $projectView);
        $auth->addChild($accountingSupportRole, $projectPdf);

        $auth->addChild($accountingSupportRole, $projectUpdateMilestoneStatus);
        $auth->addChild($accountingSupportRole, $projectUpdateStatus);
        $auth->addChild($accountingSupportRole, $companyIndex);
        $auth->addChild($accountingSupportRole, $companyCreate);
        $auth->addChild($accountingSupportRole, $companyView);
        $auth->addChild($accountingSupportRole, $companyUpdate);
        $auth->addChild($accountingSupportRole, $companyDelete);
        $auth->addChild($accountingSupportRole, $companyContactIndex);
        $auth->addChild($accountingSupportRole, $companyContactCreate);
        $auth->addChild($accountingSupportRole, $companyContactUpdate);
        $auth->addChild($accountingSupportRole, $companyContactView);
        $auth->addChild($accountingSupportRole, $companyContactDelete);

        /**
         * Attribution des permissions au rôle de ressources humaine.
         * Il peut créer, modifier et voir les utilisateurs.
         * Il ne peut pas voir les admin et superAdmin et ne peut pas en créer.
         */
        $auth->addChild($humanRessourcesRole, $adminCreate);
        $auth->addChild($humanRessourcesRole, $adminIndex);
        $auth->addChild($humanRessourcesRole, $adminView);
        $auth->addChild($humanRessourcesRole, $adminUpdate);

        /**
         * Attribution des permissions au rôle d'admin.
         * Il peut tout faire sauf supprimer ou modifier un admin. Peut-être même le voir.
         * Il ne peut pas créer d'admin.
         */
        $auth->addChild($adminRole, $projectIndex);
        $auth->addChild($adminRole, $projectIndexDraft);
        $auth->addChild($adminRole, $projectView);
        $auth->addChild($adminRole, $projectUpdateStatus);
        $auth->addChild($adminRole, $projectUpdateMilestoneStatus);
        $auth->addChild($adminRole, $projectPdf);
        $auth->addChild($adminRole, $projectCreate);
        $auth->addChild($adminRole, $projectUpdate);
        $auth->addChild($adminRole, $projectDelete);

        $auth->addChild($adminRole, $companyIndex);
        $auth->addChild($adminRole, $companyCreate);
        $auth->addChild($adminRole, $companyView);
        $auth->addChild($adminRole, $companyUpdate);
        $auth->addChild($adminRole, $companyDelete);
        $auth->addChild($adminRole, $companyContactIndex);
        $auth->addChild($adminRole, $companyContactCreate);
        $auth->addChild($adminRole, $companyContactUpdate);
        $auth->addChild($adminRole, $companyContactView);
        $auth->addChild($adminRole, $companyContactDelete);

        $auth->addChild($adminRole, $adminCreate);
        $auth->addChild($adminRole, $adminIndex);
        $auth->addChild($adminRole, $adminView);
        $auth->addChild($adminRole, $adminUpdate);
        $auth->addChild($adminRole, $adminDelete);
        $auth->addChild($adminRole, $adminDevisParametersView);
        $auth->addChild($adminRole, $adminDevisParametersUpdate);
        $auth->addChild($adminRole, $adminEquipementIndex);
        $auth->addChild($adminRole, $adminEquipementCreate);

        /**
         * Attribution des permissions au rôle de super admin.
         * Il peut tout faire.
         * Il ne peut pas créer de super admin.
         */
        $auth->addChild($superAdminRole, $projectIndex);
        $auth->addChild($superAdminRole, $projectIndexDraft);
        $auth->addChild($superAdminRole, $projectView);
        $auth->addChild($superAdminRole, $projectUpdateStatus);
        $auth->addChild($superAdminRole, $projectUpdateMilestoneStatus);
        $auth->addChild($superAdminRole, $projectPdf);
        $auth->addChild($superAdminRole, $projectCreate);
        $auth->addChild($superAdminRole, $projectUpdate);
        $auth->addChild($superAdminRole, $projectDelete);

        $auth->addChild($superAdminRole, $companyIndex);
        $auth->addChild($superAdminRole, $companyCreate);
        $auth->addChild($superAdminRole, $companyView);
        $auth->addChild($superAdminRole, $companyUpdate);
        $auth->addChild($superAdminRole, $companyDelete);
        $auth->addChild($superAdminRole, $companyContactIndex);
        $auth->addChild($superAdminRole, $companyContactCreate);
        $auth->addChild($superAdminRole, $companyContactUpdate);
        $auth->addChild($superAdminRole, $companyContactView);
        $auth->addChild($superAdminRole, $companyContactDelete);

        $auth->addChild($superAdminRole, $adminCreate);
        $auth->addChild($superAdminRole, $adminIndex);
        $auth->addChild($superAdminRole, $adminView);
        $auth->addChild($superAdminRole, $adminUpdate);
        $auth->addChild($superAdminRole, $adminDelete);
        $auth->addChild($superAdminRole, $adminDevisParametersView);
        $auth->addChild($superAdminRole, $adminDevisParametersUpdate);
        $auth->addChild($superAdminRole, $adminEquipementIndex);
        $auth->addChild($superAdminRole, $adminEquipementCreate);


        /**
         * Attribution des rôles à des utilisateurs.
         * (pour l'environnement de développement seulement).
         */
        $auth->assign($salaryRole, 1);
        $auth->assign($projectManagerRole, 2);
        $auth->assign($celluleManagerRole, 3);
        $auth->assign($accountingSupportRole, 4);
        $auth->assign($humanRessourcesRole, 5);
        $auth->assign($adminRole, 6);
        $auth->assign($superAdminRole, 7);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200302_123949_init_rbac cannot be reverted.\n";

        return false;
    }
}
