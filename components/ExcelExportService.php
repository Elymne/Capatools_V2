<?php

namespace app\components;

use XLSXWriter;

class ExcelExportService
{

    const DEVIS_TYPE = 1;

    public static function exportModelDataToExcel($modelData, int $modelType)
    {
        if ($modelType === 1) self::createExportedDevisExcel($modelData);
    }

    private static function createExportedDevisExcel($modelData)
    {
        $header = [
            'nom_chef_projet' => 'string',
            'email' => 'string',
            'cellule' => 'string',
            'nom_client' => 'string',
            'duree_prestation' => 'string',
            'tva' => 'string',
            'type_prestation' => 'string',
            'identifiant_laboxy' => 'string'
        ];

        $rows = [
            [
                $modelData->capa_user->username,
                $modelData->capa_user->email,
                $modelData->capa_user->cellule->name,
                $modelData->company->name,
                $modelData->service_duration,
                $modelData->company->tva,
                $modelData->delivery_type->label,
                $modelData->id_laboxy
            ]
        ];

        $writer = new XLSXWriter();
        $writer->writeSheetHeader('Sheet1', $header);
        foreach ($rows as $row)
            $writer->writeSheetRow('Sheet1', $row);

        $file = 'example.xlsx';
        $writer->writeToFile($file);

        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            unlink($file);
            exit;
        }
    }
}
