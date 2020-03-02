<?php

use yii\db\Migration;

/**
 * Generate all devis access for users.
 * Access are stocked in php script file.
 */
class m200800_000000_devis_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $auth = Yii::$app->authManager;

        // Index permission.
        $index = $auth->createPermission('indexDevis');
        $auth->add($index);

        // Create permission.
        $create = $auth->createPermission('createDevis');
        $auth->add($create);

        // View permission.
        $view = $auth->createPermission('viewDevis');
        $auth->add($view);

        // Add company permission.
        $addCompany = $auth->createPermission('addCompanyDevis');
        $auth->add($addCompany);

        // Update permission.
        $update = $auth->createPermission('updateDevis');
        $auth->add($update);

        // Delete permission.
        $delete = $auth->createPermission('deleteDevis');
        $auth->add($delete);

        // Update status permission.
        $updateStatus = $auth->createPermission('updateStatusDevis');
        $auth->add($updateStatus);


        // -- USERS PROLES -- \\


        // Project Manager permissions.
        $projectManagerPermission = $auth->createRole('projectManagerDevis');
        $auth->add($projectManagerPermission);
        $auth->addChild($projectManagerPermission, $index);
        $auth->addChild($projectManagerPermission, $create);
        $auth->addChild($projectManagerPermission, $view);
        $auth->addChild($projectManagerPermission, $addCompany);
        $auth->addChild($projectManagerPermission, $update);
        $auth->addChild($projectManagerPermission, $updateStatus);

        // Responsable Operationnel permissions.
        $operationalManager = $auth->createRole('operationalManagerDevis');
        $auth->add($operationalManager);
        $auth->addChild($operationalManager, $index);
        $auth->addChild($operationalManager, $create);
        $auth->addChild($operationalManager, $view);
        $auth->addChild($operationalManager, $addCompany);
        $auth->addChild($operationalManager, $update);
        $auth->addChild($operationalManager, $delete);
        $auth->addChild($operationalManager, $updateStatus);

        // Responsable Operationnel permissions.
        $accountingSupport = $auth->createRole('accountingSupportDevis');
        $auth->add($accountingSupport);
        $auth->addChild($accountingSupport, $index);
        $auth->addChild($accountingSupport, $create);
        $auth->addChild($accountingSupport, $view);
        $auth->addChild($accountingSupport, $addCompany);
        $auth->addChild($accountingSupport, $update);
        $auth->addChild($accountingSupport, $delete);
        $auth->addChild($accountingSupport, $updateStatus);


        // -- USERS ASSIGNEMENT -- \\


        $auth->assign($projectManagerPermission, 2); // sacha
        $auth->assign($operationalManager, 3); // admin
        $auth->assign($accountingSupport, 4); // balkany
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200302_123949_init_rbac cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200302_123949_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
