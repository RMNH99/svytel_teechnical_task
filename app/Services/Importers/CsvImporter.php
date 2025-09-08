<?php
namespace App\Services\Importers;

class CsvImporter extends Importer
{
    public function import(string $filePath): array
    {
        $data = [];
        if (!file_exists($filePath) || !is_readable($filePath)) return $data;

        if (($handle = fopen($filePath, 'r')) !== false) {
            $header = null;
            while (($row = fgetcsv($handle)) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
        return $data;
    }
}
