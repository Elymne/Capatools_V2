<?php

use yii\db\Migration;

/**
 * Generate all devis access for users.
 * Access are stocked in php script file.
 */
class m200800_000001_administration_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $auth = Yii::$app->authManager;

        // Index permission.
        $index = $auth->createPermission('indexAdmin');
        $auth->add($index);

        // Create permission.
        $create = $auth->createPermission('createAdmin');
        $auth->add($create);

        // View permission.
        $view = $auth->createPermission('viewAdmin');
        $auth->add($view);

        // Update permission.
        $update = $auth->createPermission('updateAdmin');
        $auth->add($update);

        // Delete permission.
        $delete = $auth->createPermission('deleteAdmin');
        $auth->add($delete);


        // -- USERS PROLES -- \\


        // Project Manager permissions.
        $administratorPermission = $auth->createRole('administrator');

        // Add a new role.
        $auth->add($administratorPermission);

        // Associate permissions to role.
        $auth->addChild($administratorPermission, $index);
        $auth->addChild($administratorPermission, $create);
        $auth->addChild($administratorPermission, $view);
        $auth->addChild($administratorPermission, $update);
        $auth->addChild($administratorPermission, $delete);


        // -- USERS ASSIGNEMENT -- \\


        $auth->assign($administratorPermission, 2); // sacha
        $auth->assign($administratorPermission, 3); // admin
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
