<?php

use app\helper\_enum\PermissionAccessEnum;
use app\helper\_enum\UserRoleEnum;
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

        /**
         * Création des permissions d'accès au service projet de l'application.
         */
        $projectIndex = $auth->createPermission(PermissionAccessEnum::PROJECT_INDEX);
        $projectCreate = $auth->createPermission(PermissionAccessEnum::PROJECT_CREATE);
        $projectView = $auth->createPermission(PermissionAccessEnum::PROJECT_VIEW);
        $projectUpdate = $auth->createPermission(PermissionAccessEnum::PROJECT_UPDATE);
        $projectDelete = $auth->createPermission(PermissionAccessEnum::PROJECT_DELETE);
        $projectUpdateStatus = $auth->createPermission(PermissionAccessEnum::PROJECT_UPDATE_STATUS);
        $projectPdf = $auth->createPermission(PermissionAccessEnum::PROJECT_PDF);

        $auth->add($projectIndex);
        $auth->add($projectCreate);
        $auth->add($projectView);
        $auth->add($projectUpdate);
        $auth->add($projectDelete);
        $auth->add($projectUpdateStatus);
        $auth->add($projectPdf);

        /**
         * Création des permissions d'accès au service administration de l'application.
         */
        $adminIndex = $auth->createPermission(PermissionAccessEnum::ADMIN_INDEX);
        $adminCreate = $auth->createPermission(PermissionAccessEnum::COMPANY_CREATE);
        $adminView = $auth->createPermission(PermissionAccessEnum::COMPANY_VIEW);
        $adminUpdate = $auth->createPermission(PermissionAccessEnum::COMPANY_UPDATE);
        $adminDelete = $auth->createPermission(PermissionAccessEnum::COMPANY_DELETE);
        $adminProjectParameters = $auth->createPermission(PermissionAccessEnum::ADMIN_PROJECT_PARAMETERS);

        $auth->add($adminIndex);
        $auth->add($adminCreate);
        $auth->add($adminView);
        $auth->add($adminUpdate);
        $auth->add($adminDelete);
        $auth->add($adminProjectParameters);

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


        /**
         * Création des rôles d'accès de l'application.
         */
        $salaryRole = $auth->createRole(UserRoleEnum::SALARY);
        $projectManagerRole = $auth->createRole(UserRoleEnum::PROJECT_MANAGER);
        $celluleManagerRole = $auth->createRole(UserRoleEnum::CELLULE_MANAGER);
        $humanRessourcesRole = $auth->createRole(UserRoleEnum::HUMAN_RESSOURCES);
        $supportRole = $auth->createRole(UserRoleEnum::SUPPORT);
        $adminRole = $auth->createRole(UserRoleEnum::ADMIN);
        $superAdminRole = $auth->createRole(UserRoleEnum::SUPER_ADMIN);


        /**
         * Attribution des permissions au rôles de salarié.
         */
        $auth->addChild($salaryRole, $projectIndex);
        $auth->addChild($salaryRole, $projectView);

        /**
         * Attribution des permissions au rôles de chef de projet.
         * Ce rôle pourra accéder à ces fonctionnalités cependant, notons ceci :
         *  - Il ne peut voir que les devis dont il fait parti ou qu'il a crée.
         *  - Il ne peut modifier que les devis dont il est le chef de projet.
         */
        $auth->addChild($projectManagerRole, $projectIndex);
        $auth->addChild($projectManagerRole, $projectCreate);
        $auth->addChild($projectManagerRole, $projectView);
        $auth->addChild($projectManagerRole, $projectUpdate);

        /**
         * Attribution des permissions au rôles de responsable de cellule.
         * Ce rôle pourra accéder à ces fonctionnalités cependant, notons ceci :
         *  - Il ne peut voir que les devis de sa cellule.
         *  - Il ne peut modifier que les devis de sa cellule.
         */
        $auth->addChild($projectManagerRole, $projectIndex);
        $auth->addChild($projectManagerRole, $projectCreate);
        $auth->addChild($projectManagerRole, $projectView);
        $auth->addChild($projectManagerRole, $projectUpdate);

        /**
         * Attribution des rôles à des utilisateurs
         * (pour l'environnement de développement seulement).
         */
        $auth->assign($salaryRole, 1);
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
