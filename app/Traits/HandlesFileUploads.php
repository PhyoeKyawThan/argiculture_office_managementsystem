<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HandlesFileUploads
{
    /**
     * Upload a file to a specified disk and directory.
     *
     * @param UploadedFile $file The file object from the request
     * @param string $folder The destination folder (e.g., 'avatars')
     * @param string $disk The storage disk (default: 'public')
     * @param string|null $filename Optional custom filename (without extension)
     * @return string|null The stored file path, or null on failure
     */
    public function uploadFile(UploadedFile $file, string $folder, string $disk = 'public', ?string $filename = null): ?string
    {
        if (!$file->isValid()) {
            return null;
        }

        // Generate a secure, unique filename if one isn't provided
        $name = $filename 
            ? Str::slug($filename) . '_' . time() . '.' . $file->getClientOriginalExtension()
            : Str::random(25) . '.' . $file->getClientOriginalExtension();

        // Store the file and return the path
        return $file->storeAs($folder, $name, $disk);
    }

    /**
     * Delete an existing file from storage.
     *
     * @param string|null $path The file path stored in the database
     * @param string $disk The storage disk (default: 'public')
     * @return bool
     */
    public function deleteFile(?string $path, string $disk = 'public'): bool
    {
        if ($path && Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }

        return false;
    }
}