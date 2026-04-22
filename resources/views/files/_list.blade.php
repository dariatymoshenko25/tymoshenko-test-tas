<div id="filesContainer">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
            <tr>
                <th>File name</th>
                <th>Size</th>
                <th>Loaded</th>
                <th>Will be deleted after</th>
                <th class="text-end">Actions</th>
            </tr>
            </thead>
            <tbody id="filesTable">
            @forelse($files as $file)
                <tr data-id="{{ $file->id }}">
                    <td>{{ $file->original_name }}</td>
                    <td>{{ number_format($file->size / 1024, 1) }} KB</td>
                    <td>{{ $file->created_at->format('d.m.Y H:i') }}</td>
                    <td>
                        <span class="badge bg-warning text-dark">
                            {{ $file->expires_at->format('d.m.Y H:i') }}
                        </span>
                    </td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-danger delete-btn" data-id="{{ $file->id }}">
                            Delete
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No files</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $files->links() }}
</div>
