<?php
namespace App\Services\Importers;

class JsonImporter extends Importer
{
    public function import(string $filePath): array
    {
        if (!file_exists($filePath) || !is_readable($filePath)) return [];
        $content = file_get_contents($filePath);
        return json_decode($content, true) ?? [];
    }
}
