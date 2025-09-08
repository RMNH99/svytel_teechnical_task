@extends('layouts.master')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-md-6">
        <h3>Export Users</h3>
        <form id="exportForm" method="POST" action="{{ route('export') }}">
            @csrf
            <div class="mb-3">
                <label for="exportFormat" class="form-label">Select Format</label>
                <select class="form-select" id="exportFormat" name="format" required>
                    <option value="" disabled selected>Select one</option>
                    <option value="csv">CSV</option>
                    <option value="json">JSON</option>
                    <option value="xml">XML</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Export</button>
        </form>
    </div>

    <div class="col-md-6">
        <h3>Import Users</h3>
        <form id="importForm" method="POST" action="{{ route('import') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="importFile" class="form-label">Select File</label>
                <input class="form-control" type="file" id="importFile" name="file" required>
            </div>
            <div class="mb-3">
                <label for="importFormat" class="form-label">Select Format</label>
                <select class="form-select" id="importFormat" name="format" required>
                    <option value="" disabled selected>Select one</option>
                    <option value="csv">CSV</option>
                    <option value="json">JSON</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Import</button>
        </form>
    </div>
</div>

@endsection
