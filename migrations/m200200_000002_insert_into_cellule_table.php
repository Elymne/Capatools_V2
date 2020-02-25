<?php

use yii\db\Migration;

class m200200_000002_insert_into_cellule_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->insert('{{%cellule}}', [
            'identity' => 'AIERA',
            'name' => 'IREALITE'
        ]);
        $this->insert('{{%cellule}}', [
            'identity' => 'ACMER',
            'name' => 'MER'
        ]);
        $this->insert('{{%cellule}}', [
            'identity' => 'ACAPT',
            'name' => 'CAPTEURS ET COMPOSITES'
        ]);

        $this->insert('{{%cellule}}', [
            'identity' => 'AIXEA',
            'name' => 'IXEAD'
        ]);
        $this->insert('{{%cellule}}', [
            'identity' => 'AERIM',
            'name' => 'ERIMAT'
        ]);
        $this->insert('{{%cellule}}', [
            'identity' => 'AIXPE',
            'name' => 'IXPEL'
        ]);
        $this->insert('{{%cellule}}', [
            'identity' => 'ACSUP',
            'name' => 'SUPPORT'
        ]);
        $this->insert('{{%cellule}}', [
            'identity' => 'AROBO',
            'name' => 'ROBOTIQUE ET PROCEDES'
        ]);
        $this->insert('{{%cellule}}', [
            'identity' => 'ACBSO',
            'name' => 'CBS'
        ]);
        $this->insert('{{%cellule}}', [
            'identity' => 'ATHCH',
            'name' => 'THERASSAY CH'
        ]);
        $this->insert('{{%cellule}}', [
            'identity' => 'ACPCE',
            'name' => 'CPC ENG'
        ]);
        $this->insert('{{%cellule}}', [
            'identity' => 'AINSI',
            'name' => 'INSILICO'
        ]);

        $this->insert('{{%cellule}}', [
            'identity' => 'ABIOS',
            'name' => 'BIOSYS'
        ]);
        $this->insert('{{%cellule}}', [
            'identity' => 'AKNOW',
            'name' => 'KNOWEDGE'
        ]);

        $this->insert('{{%cellule}}', [
            'identity' => 'AGEPR',
            'name' => 'GP'
        ]);

        $this->insert('{{%cellule}}', [
            'identity' => 'ALTEN',
            'name' => 'LTN'
        ]);
        $this->insert('{{%cellule}}', [
            'identity' => 'AVALI',
            'name' => 'VALINBTP'
        ]);

        $this->insert('{{%cellule}}', [
            'identity' => 'ASPEC',
            'name' => 'SPECTROMAITRISE'
        ]);
        $this->insert('{{%cellule}}', [
            'identity' => 'APATR',
            'name' => 'PATRIMOINE'
        ]);

        $this->insert('{{%cellule}}', [
            'identity' => 'ADZYM',
            'name' => 'DZYME'
        ]);
        $this->insert('{{%cellule}}', [
            'identity' => 'ATHCL',
            'name' => 'THERASSAY CLM'
        ]);
        $this->insert('{{%cellule}}', [
            'identity' => 'ATHPC',
            'name' => 'THERASSAY PC'
        ]);
        $this->insert('{{%cellule}}', [
            'identity' => 'AEREL',
            'name' => 'ERELUEC'
        ]);
        $this->insert('{{%cellule}}', [
            'identity' => 'ACECO',
            'name' => 'ECONOMIE CIRCULAIRE'
        ]);
        $this->insert('{{%cellule}}', [
            'identity' => 'AEASI',
            'name' => 'EASI'
        ]);
        $this->insert('{{%cellule}}', [
            'identity' => 'ATHAL',
            'name' => 'THALASSOMICS'
        ]);
        $this->insert('{{%cellule}}', [
            'identity' => 'AEAU0',
            'name' => 'EAU'
        ]);
        $this->insert('{{%cellule}}', [
            'identity' => 'AACCE',
            'name' => 'ACCESS MEMORIA'
        ]);
        $this->insert('{{%cellule}}', [
            'identity' => 'AOBSL',
            'name' => 'OBSERVATOIRE DU LITTORAL'
        ]);
        $this->insert('{{%cellule}}', [
            'identity' => 'AOBS2',
            'name' => 'OBSERVATOIRE DU LITTORAL 2'
        ]);
        $this->insert('{{%cellule}}', [
            'identity' => 'AEPUM',
            'name' => 'EPUM'
        ]);
        $this->insert('{{%cellule}}', [
            'identity' => 'AENFA',
            'name' => 'ENFANCE'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%cellule}}');
    }
}
