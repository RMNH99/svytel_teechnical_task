<?php
namespace App\Traits;

use App\Services\Exporters\CsvExporter;
use App\Services\Exporters\JsonExporter;
use App\Services\Exporters\XmlExporter;

trait Exportable
{
    public function exportData(string $format): string
    {
        $data = $this->toArray();

        $exporter = match(strtolower($format)) {
            'csv' => new CsvExporter(),
            'json' => new JsonExporter(),
            'xml' => new XmlExporter(),
        };

        return $exporter->export($data);
    }
}
