<?php

use yii\db\Migration;

/**
 * Class m200203_132918_ajoutNomCellule
 */
class m200203_132918_ajoutNomCellule extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        
        $this->delete('Cellule');

        //Redémarre l'autoincrement à 1
        $this->execute('ALTER TABLE Cellule AUTO_INCREMENT = 1');

        //Ajout de la cellule AROBO
        $this->insert('{{%Cellule}}', [
            'identifiant' => 'AIERA',
            'name' => 'IREALITE'
        ]);
        $this->insert('{{%Cellule}}', [
            'identifiant' => 'ACMER',
            'name' => 'MER'
        ]);
        $this->insert('{{%Cellule}}', [
            'identifiant' => 'ACAPT',
            'name' => 'CAPTEURS ET COMPOSITES'
        ]);

        $this->insert('{{%Cellule}}', [
            'identifiant' => 'AIXEA',
            'name' => 'IXEAD'
        ]);
        $this->insert('{{%Cellule}}', [
            'identifiant' => 'AERIM',
            'name' => 'ERIMAT'
        ]);
        $this->insert('{{%Cellule}}', [
            'identifiant' => 'AIXPE',
            'name' => 'IXPEL'
        ]);
        $this->insert('{{%Cellule}}', [
            'identifiant' => 'ACSUP',
            'name' => 'SUPPORT'
        ]);
        $this->insert('{{%Cellule}}', [
            'identifiant' => 'AROBO',
            'name' => 'ROBOTIQUE ET PROCEDES'
        ]);
        $this->insert('{{%Cellule}}', [
            'identifiant' => 'ACBSO',
            'name' => 'CBS'
        ]);
        $this->insert('{{%Cellule}}', [
            'identifiant' => 'ATHCH',
            'name' => 'THERACH'
        ]);
        $this->insert('{{%Cellule}}', [
            'identifiant' => 'AGENO',
            'name' => 'BIRD'
        ]);
        $this->insert('{{%Cellule}}', [
            'identifiant' => 'ACPCE',
            'name' => 'CPC'
        ]);
        $this->insert('{{%Cellule}}', [
            'identifiant' => 'AINSI',
            'name' => 'INSILICO'
        ]); 

        $this->insert('{{%Cellule}}', [
            'identifiant' => 'ABIOS',
            'name' => 'BIOSYS'
        ]); 
        $this->insert('{{%Cellule}}', [
            'identifiant' => 'AKNOW',
            'name' => 'KNOWEDGE'
        ]);

        $this->insert('{{%Cellule}}', [
            'identifiant' => 'ADZYM',
            'name' => 'DZYME'
        ]);   
        $this->insert('{{%Cellule}}', [
            'identifiant' => 'XXXXXXXXXXXXXXX',
            'name' => 'Gepea'
        ]); 

        $this->insert('{{%Cellule}}', [
            'identifiant' => 'ALTEN',
            'name' => 'LTN'
        ]);    
        $this->insert('{{%Cellule}}', [
            'identifiant' => 'AVALI',
            'name' => 'VALINBTP'
        ]);  
        $this->insert('{{%Cellule}}', [
            'identifiant' => 'APATR',
            'name' => 'PATRIMOINE'
        ]);  
        $this->insert('{{%Cellule}}', [
            'identifiant' => 'ATHCL',
            'name' => 'THERACLM'
        ]);
        $this->insert('{{%Cellule}}', [
            'identifiant' => 'ATHPC',
            'name' => 'THERAPC'
        ]); 
        $this->insert('{{%Cellule}}', [
            'identifiant' => 'ACECO',
            'name' => 'ECONOMIE CIRCULAIRE'
        ]);
        $this->insert('{{%Cellule}}', [
            'identifiant' => 'ASPEC',
            'name' => 'SPECTROMAITRISE'
        ]); 
        $this->insert('{{%Cellule}}', [
            'identifiant' => 'AEREL',
            'name' => 'ERELUEC'
        ]);  
        $this->insert('{{%Cellule}}', [
            'identifiant' => 'AEASI',
            'name' => 'EASI'
        ]); 
        $this->insert('{{%Cellule}}', [
            'identifiant' => 'ATHAL',
            'name' => 'ATHAL'
        ]);  
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('Cellule');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200203_132918_ajoutCellule cannot be reverted.\n";

        return false;
    }
    */
}
