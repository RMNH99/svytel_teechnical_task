<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\User;
use App\Services\Exporters\CsvExporter;
use App\Services\Exporters\JsonExporter;
use App\Services\Exporters\XmlExporter;

use Illuminate\Support\Facades\Storage; // <-- Add this line

class DataExport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $format;

    public function __construct(string $format)
    {
        $this->format = strtolower($format);
    }

    public function handle()
    {
        $data = User::all()->toArray();

        $exporter = match($this->format) {
            'csv' => new CsvExporter(),
            'json' => new JsonExporter(),
            'xml' => new XmlExporter(),
            default => throw new \Exception("Unsupported export format: {$this->format}"),
        };

        $content = $exporter->export($data);
        $filename = "exports/users_export_" . now()->format('Ymd_His') . ".{$this->format}";

        Storage::makeDirectory('exports');
        $check = Storage::put($filename, $content);

        if (!$check) {
            \Log::error("Failed to write export file: {$filename}");
        } else {
            \Log::info("Export file created: {$filename}");
        }
    }
}
