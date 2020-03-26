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

        // Pdf permission.
        $pdf = $auth->createPermission('pdfDevis');
        $auth->add($pdf);

        // Pdf permission.
        $updateMilestoneStatus = $auth->createPermission('updateMilestoneStatusDevis');
        $auth->add($updateMilestoneStatus);

        // -- USERS PROLES -- \\


        // Project Manager permissions.
        $projectManagerPermission = $auth->createRole('projectManagerDevis');

        // Add a new role.
        $auth->add($projectManagerPermission);

        // Associate permissions to role.
        $auth->addChild($projectManagerPermission, $index);
        $auth->addChild($projectManagerPermission, $create);
        $auth->addChild($projectManagerPermission, $view);
        $auth->addChild($projectManagerPermission, $addCompany);
        $auth->addChild($projectManagerPermission, $update);
        $auth->addChild($projectManagerPermission, $updateStatus);
        $auth->addChild($projectManagerPermission, $pdf);
        $auth->addChild($projectManagerPermission, $updateMilestoneStatus);

        // Responsable Operationnel permissions.
        $operationalManager = $auth->createRole('operationalManagerDevis');

        // Add a new role.
        $auth->add($operationalManager);

        // Associate permissions to role.
        $auth->addChild($operationalManager, $index);
        $auth->addChild($operationalManager, $create);
        $auth->addChild($operationalManager, $view);
        $auth->addChild($operationalManager, $addCompany);
        $auth->addChild($operationalManager, $update);
        $auth->addChild($operationalManager, $delete);
        $auth->addChild($operationalManager, $updateStatus);
        $auth->addChild($projectManagerPermission, $pdf);
        $auth->addChild($projectManagerPermission, $updateMilestoneStatus);

        // Responsable Operationnel permissions.
        $accountingSupport = $auth->createRole('accountingSupportDevis');

        // Add a new role.
        $auth->add($accountingSupport);

        // Associate permissions to role.
        $auth->addChild($accountingSupport, $index);
        $auth->addChild($accountingSupport, $create);
        $auth->addChild($accountingSupport, $view);
        $auth->addChild($accountingSupport, $addCompany);
        $auth->addChild($accountingSupport, $update);
        $auth->addChild($accountingSupport, $delete);
        $auth->addChild($accountingSupport, $updateStatus);
        $auth->addChild($projectManagerPermission, $pdf);
        $auth->addChild($projectManagerPermission, $updateMilestoneStatus);


        // -- USERS ASSIGNEMENT (for testing) -- \\


        $auth->assign($projectManagerPermission, 1); // id 1 = toto
        $auth->assign($projectManagerPermission, 2); // id 2 = sacha
        $auth->assign($operationalManager, 3); // id 3 = admin
        $auth->assign($accountingSupport, 4); // id 4 = test

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
