<?php

use app\helper\_enum\UserRoleEnum;
use yii\db\Migration;

/**
 * Generate all devis access for users.
 * Access are stocked in php script file.
 */
class m200800_000003_company_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $auth = Yii::$app->authManager;

        $index = $auth->createPermission('indexCompany');
        $auth->add($index);

        $view = $auth->createPermission('viewCompany');
        $auth->add($view);

        $create = $auth->createPermission('createCompany');
        $auth->add($create);

        $createContacts = $auth->createPermission('addContactsCompany');
        $auth->add($createContacts);

        $administratorPermission = $auth->getRole(UserRoleEnum::ADMINISTRATOR);
        $auth->addChild($administratorPermission, $index);
        $auth->addChild($administratorPermission, $view);
        $auth->addChild($administratorPermission, $create);
        $auth->addChild($administratorPermission, $createContacts);

        $superAdministratorPermission = $auth->getRole(UserRoleEnum::SUPER_ADMINISTRATOR);
        $auth->addChild($superAdministratorPermission, $index);
        $auth->addChild($superAdministratorPermission, $view);
        $auth->addChild($superAdministratorPermission, $create);
        $auth->addChild($superAdministratorPermission, $createContacts);

        $projectManagerPermission = $auth->getRole(UserRoleEnum::PROJECT_MANAGER_DEVIS);
        $auth->addChild($projectManagerPermission, $index);
        $auth->addChild($projectManagerPermission, $view);
        $auth->addChild($projectManagerPermission, $create);
        $auth->addChild($projectManagerPermission, $createContacts);
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
