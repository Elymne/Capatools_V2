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
        
        //Ajout de la cellule AROBO
        $this->insert('{{%Cellule}}', [
            'idententifiant' => 'AROBO',
            'name' => 'Robotique et Procede'
        ]);
        $this->insert('{{%Cellule}}', [
            'idententifiant' => 'AIREA',
            'name' => 'Irealite'
        ]);
        $this->insert('{{%Cellule}}', [
            'idententifiant' => 'ACMER',
            'name' => 'Mer'
        ]);
        $this->insert('{{%Cellule}}', [
            'idententifiant' => 'ACAPT',
            'name' => 'Capteurs et Composites'
        ]);
        $this->insert('{{%Cellule}}', [
            'idententifiant' => 'AIXEA',
            'name' => 'Ixead'
        ]);
        $this->insert('{{%Cellule}}', [
            'idententifiant' => 'AERIM',
            'name' => 'Erimat'
        ]);
        $this->insert('{{%Cellule}}', [
            'idententifiant' => 'ACSUP',
            'name' => 'Support'
        ]);
        $this->insert('{{%Cellule}}', [
            'idententifiant' => 'ACBSO',
            'name' => 'Cbs'
        ]);
        $this->insert('{{%Cellule}}', [
            'idententifiant' => 'ATHCH',
            'name' => 'THERACH'
        ]);
        $this->insert('{{%Cellule}}', [
            'idententifiant' => 'AGENO',
            'name' => 'BIRD'
        ]);
        $this->insert('{{%Cellule}}', [
            'idententifiant' => 'ACPCE',
            'name' => 'CPC ENG'
        ]);
        $this->insert('{{%Cellule}}', [
            'idententifiant' => 'AINSI',
            'name' => 'Insilico'
        ]); 

        $this->insert('{{%Cellule}}', [
            'idententifiant' => 'ABIOS',
            'name' => 'Biosys'
        ]); 
        $this->insert('{{%Cellule}}', [
            'idententifiant' => 'AKNOW',
            'name' => 'Know Edge'
        ]);

        $this->insert('{{%Cellule}}', [
            'idententifiant' => 'ADZYM',
            'name' => 'D-Zyme'
        ]);   
        $this->insert('{{%Cellule}}', [
            'idententifiant' => 'XXXXXXXXXXXXXXX',
            'name' => 'Gepea'
        ]); 
        $this->insert('{{%Cellule}}', [
            'idententifiant' => 'ASPEC',
            'name' => 'Spectrometrise'
        ]);  
        $this->insert('{{%Cellule}}', [
            'idententifiant' => 'XXXXXXXXXXXXXXXXXXXXXX',
            'name' => 'C.E.C'
        ]);  
        $this->insert('{{%Cellule}}', [
            'idententifiant' => 'XXXXXXXXXXXXXXXX',
            'name' => 'EASI'
        ]);    
        $this->insert('{{%Cellule}}', [
            'idententifiant' => 'XXXXXXXXXXXXXXXX',
            'name' => 'ITIS!'
        ]);    
        $this->insert('{{%Cellule}}', [
            'idententifiant' => 'ALTENXXXXXXXXXXXXXX',
            'name' => 'LTN'
        ]);   
        $this->insert('{{%Cellule}}', [
            'idententifiant' => 'XXXXXXXXXXXX',
            'name' => 'OBS LITTORAL'
        ]);  
        $this->insert('{{%Cellule}}', [
            'idententifiant' => 'AVALI',
            'name' => 'VALINBTP'
        ]);  
        $this->insert('{{%Cellule}}', [
            'idententifiant' => 'APATR',
            'name' => 'PATRIMOINE'
        ]);  
        $this->insert('{{%Cellule}}', [
            'idententifiant' => 'ATHCL',
            'name' => 'THERACLM'
        ]);  
        $this->insert('{{%Cellule}}', [
            'idententifiant' => 'ATHCL',
            'name' => 'THERACLM'
        ]);  
        $this->insert('{{%Cellule}}', [
            'idententifiant' => 'ATHPC',
            'name' => 'THERAPC'
        ]); 
        $this->insert('{{%Cellule}}', [
            'idententifiant' => 'ACECO',
            'name' => 'Economie Circulaire'
        ]);  
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('Cellule');

        return false;
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
