<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\DataExport;
use App\Jobs\DataImport;
use Illuminate\Support\Facades\Storage;

class DataController extends Controller
{
    public function export(Request $request)
    {
        $request->validate(['format' => 'required|string|in:csv,json,xml']);
        DataExport::dispatch($request->format);

        return redirect()->back()->with('success', 'Data Exported successfully!');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'format' => 'required|string|in:csv,json'
        ]);

        $path = $request->file('file')->store('imports');

        DataImport::dispatch($path, $request->format);

        return redirect()->back()->with('success', 'Data Imported successfully!');
    }
}
