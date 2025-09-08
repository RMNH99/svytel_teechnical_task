<?php

namespace App\Services;

use App\Services\Exporters\CsvExporter;
use App\Services\Exporters\JsonExporter;
use App\Services\Exporters\XmlExporter;
use Illuminate\Support\Facades\Storage;

class MultiFormatExporter
{
    protected array $formats;

    public function __construct(array $formats = [])
    {
        $this->formats = $formats;
    }

    public function exportMany(array $data): array
    {
        $results = [];

        foreach ($this->formats as $format) {
            $exporter = match(strtolower($format)) {
                'csv' => new CsvExporter(),
                'json' => new JsonExporter(),
                'xml' => new XmlExporter(),
            };

            $content = $exporter->export($data);
            $filename = "exports/users_export_" . now()->format('Ymd_His') . ".$format";

            Storage::put($filename, $content);
            $results[$format] = $filename;
        }

        return $results;
    }
}
