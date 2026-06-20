<?php

namespace App\Http\Controllers;

use App\Services\StorageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StorageController extends Controller
{
    public function upload(Request $request, StorageService $storage): JsonResponse
    {
        $data = $request->validate([
            'file' => ['required', 'file', 'max:51200'],
            'path' => ['required', 'string', 'max:255'],
            'visibility' => ['required', Rule::in(['public', 'private'])],
            'related_type' => ['nullable', 'string', 'max:255'],
            'related_id' => ['nullable', 'integer'],
            'metadata' => ['nullable', 'array'],
        ]);

        $file = $storage->upload(
            $data['file'],
            trim($data['path'], '/'),
            $data['visibility'],
            isset($data['related_type'], $data['related_id'])
                ? ['type' => $data['related_type'], 'id' => $data['related_id']]
                : null,
            $request->user(),
            $data['metadata'] ?? null,
        );

        return response()->json(['data' => $file], 201);
    }

    public function files(Request $request, StorageService $storage): JsonResponse
    {
        return response()->json(['data' => $storage->userFiles($request->user())]);
    }

    public function url(Request $request, int $id, StorageService $storage): JsonResponse
    {
        $data = $request->validate([
            'expires_in' => ['nullable', 'integer', 'min:60', 'max:86400'],
        ]);

        return response()->json([
            'url' => $storage->url($id, $data['expires_in'] ?? 300, $request->user()),
        ]);
    }

    public function destroy(Request $request, int $id, StorageService $storage): JsonResponse
    {
        $storage->delete($id, $request->user());

        return response()->json(['deleted' => true]);
    }
}
