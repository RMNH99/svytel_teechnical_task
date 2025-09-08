<?php
namespace App\Traits;

use App\Services\Importers\CsvImporter;
use App\Services\Importers\JsonImporter;

trait Importable
{
    public static function importData(string $filePath, string $format): array
    {
        $importer = match(strtolower($format)) {
            'csv' => new CsvImporter(),
            'json' => new JsonImporter(),
            default => throw new \Exception("Unsupported format: $format"),
        };

        return $importer->import($filePath);
    }
}
