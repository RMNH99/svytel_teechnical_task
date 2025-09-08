<?php
namespace App\Services\Exporters;

class XmlExporter extends Exporter
{
    public function export(array $data): string
    {
        $xml = new \SimpleXMLElement('<root/>');
        array_walk_recursive($data, function($value, $key) use ($xml) {
            $xml->addChild($key, htmlspecialchars($value));
        });
        return $xml->asXML();
    }
}
