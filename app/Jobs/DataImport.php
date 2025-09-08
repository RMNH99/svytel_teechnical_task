<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\User;
use App\Services\Importers\CsvImporter;
use App\Services\Importers\JsonImporter;

use Illuminate\Support\Facades\Storage;

class DataImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $filePath;
    protected string $format;

    public function __construct(string $filePath, string $format)
    {
        $this->filePath = $filePath;
        $this->format = strtolower($format);
    }

    public function handle()
    {
        $fullPath = Storage::path($this->filePath);

        $importer = match ($this->format) {
            'csv' => new CsvImporter(),
            'json' => new JsonImporter(),
            default => throw new \Exception("Unsupported import format: {$this->format}"),
        };

        $records = $importer->import($fullPath);

        foreach ($records as $record) {
            
            if (isset($record['password'])) {
                $record['password'] = bcrypt($record['password']);
            }


            User::updateOrCreate(
                ['email' => $record['email']],
                $record
            );
        }
    }
}
