<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    /**
     * Upload a file to the specified disk and directory.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string $disk
     * @return string The path to the uploaded file
     */
    public function upload(UploadedFile $file, string $directory = 'uploads', string $disk = 'public'): string
    {
        $filename = $this->generateUniqueFilename($file);
        $path = $file->storeAs($directory, $filename, $disk);

        return $path;
    }

    /**
     * Delete a file from the specified disk.
     *
     * @param string|null $path
     * @param string $disk
     * @return bool
     */
    public function delete(?string $path, string $disk = 'public'): bool
    {
        if (!$path || !Storage::disk($disk)->exists($path)) {
            return false;
        }

        return Storage::disk($disk)->delete($path);
    }

    /**
     * Generate a unique filename for the uploaded file.
     *
     * @param UploadedFile $file
     * @return string
     */
    private function generateUniqueFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $uniqueId = Str::random(8);

        return "{$filename}-{$uniqueId}.{$extension}";
    }

    /**
     * Get the public URL for a file.
     *
     * @param string|null $path
     * @param string $disk
     * @return string|null
     */
    public function getUrl(?string $path, string $disk = 'public'): ?string
    {
        if (!$path) {
            return null;
        }

        return Storage::disk($disk)->url($path);
    }

    /**
     * Validate if the file is an image.
     *
     * @param UploadedFile $file
     * @return bool
     */
    public function isImage(UploadedFile $file): bool
    {
        return str_starts_with($file->getMimeType(), 'image/');
    }
}

