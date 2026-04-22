<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFileRequest;
use App\Models\File;
use App\Services\FileService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class FileController extends Controller
{
    public function __construct(protected FileService $fileService) {}

    public function index(): View
    {
        return view('files.index', [
            'files' => File::latest()->paginate(10),
        ]);
    }

    public function store(StoreFileRequest $request): JsonResponse
    {
        $this->fileService->store($request->validated()['file']);
        return response()->json([
            'success' => true,
            'message' => 'The file has been successfully uploaded.']
        );
    }

    public function destroy(File $file): JsonResponse
    {
        $this->fileService->delete($file);
        return response()->json([
            'success' => true,
            'message' => 'The file has been deleted.']
        );
    }

    public function list(): View
    {
        $files = File::latest()->paginate(10);
        return view('files._list', compact('files'));
    }
}
