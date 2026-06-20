<?php

namespace App\Services;

use App\Models\StorageFile;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class StorageService
{
    private string $disk = 'minio';

    public function upload(
        UploadedFile $file,
        string $path,
        string $visibility = 'private',
        Model|array|null $related = null,
        ?User $actor = null,
        ?array $metadata = null,
    ): StorageFile {
        $storedPath = Storage::disk($this->disk)->putFile($path, $file, $visibility);
        $relatedType = $related instanceof Model ? $related->getMorphClass() : ($related['type'] ?? null);
        $relatedId = $related instanceof Model ? $related->getKey() : ($related['id'] ?? null);

        return StorageFile::create([
            'user_id' => $actor?->id,
            'related_type' => $relatedType,
            'related_id' => $relatedId,
            'disk' => $this->disk,
            'bucket' => config('filesystems.disks.minio.bucket'),
            'path' => $storedPath,
            'filename' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType() ?: 'application/octet-stream',
            'size' => $file->getSize(),
            'visibility' => $visibility,
            'metadata' => $metadata,
        ]);
    }

    public function delete(int $fileId, User $actor): void
    {
        $file = StorageFile::findOrFail($fileId);
        $this->authorize($file, $actor);

        Storage::disk($file->disk)->delete($file->path);
        $file->delete();
    }

    public function url(int $fileId, int $expiresIn, User $actor): string
    {
        $file = StorageFile::findOrFail($fileId);
        $this->authorize($file, $actor);

        return Storage::disk($file->disk)->temporaryUrl($file->path, now()->addSeconds($expiresIn));
    }

    public function findByRelated(string $type, int $id, User $actor)
    {
        $query = StorageFile::query()
            ->where('related_type', $type)
            ->where('related_id', $id);

        if (! $actor->isAdmin()) {
            $query->where('user_id', $actor->id);
        }

        return $query->latest()->get();
    }

    public function userFiles(User $actor)
    {
        return StorageFile::query()
            ->where('user_id', $actor->id)
            ->latest()
            ->paginate(15);
    }

    public function authorize(StorageFile $file, User $actor): void
    {
        if ($actor->isAdmin()) {
            return;
        }

        abort_if(! $file->user_id || $file->user_id !== $actor->id, 403);

        if ($file->related && Gate::getPolicyFor($file->related)) {
            $response = Gate::inspect('view', $file->related);
            abort_if($response->denied(), 403);
        }
    }
}
