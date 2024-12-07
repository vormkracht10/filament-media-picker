<?php

namespace Vormkracht10\MediaPicker;

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Storage;
use Vormkracht10\MediaPicker\Models\Media;

class MediaPicker
{
    public static function create(array $data): array
    {
        $media = [];

        foreach ($data['media'] as $file) {
            // Get the full path on the configured disk
            $fullPath = Storage::disk(config('media-picker.disk'))->path($file);

            $filename = basename($file);

            $mimeType = Storage::disk(config('media-picker.disk'))->mimeType($file);

            $fileSize = Storage::disk(config('media-picker.disk'))->size($file);

            $extension = pathinfo($filename, PATHINFO_EXTENSION);

            // Additional file information
            $fileInfo = [
                'full_path' => $fullPath,
                'filename' => $filename,
                'extension' => $extension,
                'mime_type' => $mimeType,
                'file_size' => $fileSize,
            ];

            if (str_starts_with($mimeType, 'image/')) {
                try {
                    $imageSize = getimagesize($fullPath);
                    $fileInfo += [
                        'width' => $imageSize[0] ?? null,
                        'height' => $imageSize[1] ?? null,
                        'image_type' => $imageSize[2] ?? null,
                    ];
                } catch (\Exception $e) {
                    // Log or handle image size extraction error
                }
            }

            $media[] = Media::create([
                'site_ulid' => Filament::getTenant()->ulid,
                'disk' => config('media-picker.disk'),
                'uploaded_by' => auth()->id(),
                'filename' => $filename,
                'extension' => $extension,
                'mime_type' => $mimeType,
                'size' => $fileSize,
                'width' => $fileInfo['width'] ?? null,
                'height' => $fileInfo['height'] ?? null,
                'checksum' => md5_file($fullPath),
                'public' => config('media-picker.visibility') === 'public', // TODO: Should be configurable in the form itself
            ]);
        }

        return $media;
    }
}