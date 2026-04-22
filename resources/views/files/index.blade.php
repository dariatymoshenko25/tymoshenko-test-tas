@extends('layouts.app')

@section('title', 'File management')

@section('content')
    <h2 class="mb-4">File management</h2>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">PDF/DOCX upload (up to 10MB)</h5>
            <div id="upload-area">
                <p class="mb-0">Drag and drop file here or <strong>click to select</strong></p>
                <input type="file" id="fileInput" accept=".pdf,.docx" class="d-none">
            </div>
            <div class="progress mt-3 d-none" id="progressWrapper">
                <div class="progress-bar" id="progressBar" role="progressbar" style="width: 0%"></div>
            </div>
            <div id="uploadStatus" class="mt-2 text-muted small"></div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Uploaded files</h5>
            @include('files._list', ['files' => $files])
        </div>
    </div>
@endsection
