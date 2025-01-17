<?php

namespace Vormkracht10\MediaPicker;

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Storage;
use Vormkracht10\MediaPicker\Models\Media;

class MediaPicker
{
    public static function create(array|string $data): array
    {
        $media = [];

        if (is_string($data)) {
            $data = [$data];
        }

        foreach ($data as $file) {
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

            $media[] = Media::updateOrCreate([
                'site_ulid' => Filament::getTenant()->ulid,
                'disk' => config('media-picker.disk'),
                'original_filename' => pathinfo($filename, PATHINFO_FILENAME),
                'checksum' => md5_file($fullPath),
            ], [
                'filename' => $filename,
                'uploaded_by' => auth()->user()->id,
                'extension' => $extension,
                'mime_type' => $mimeType,
                'size' => $fileSize,
                'width' => $fileInfo['width'] ?? null,
                'height' => $fileInfo['height'] ?? null,
                'public' => config('media-picker.visibility') === 'public',
            ]);
        }

        return $media;
    }
}