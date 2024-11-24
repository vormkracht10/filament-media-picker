<?php

namespace Vormkracht10\MediaPicker\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $guarded = [];

    protected $casts = [
        'width' => 'integer',
        'height' => 'integer',
        'size' => 'integer',
    ];

    protected function url(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (Storage::disk($this->disk)->exists($this->path) === false) {
                    return '';
                }

                try {
                    $isPrivate = Storage::disk($this->disk)->getVisibility($this->path) === 'private';
                } catch (\Throwable) {
                    $isPrivate = config(sprintf('filesystems.disks.%s.visibility', $this->disk)) !== 'public';
                }

                return $isPrivate ? Storage::disk($this->disk)->temporaryUrl(
                    $this->path,
                    now()->addMinutes(5)
                ) : Storage::disk($this->disk)->url($this->path);
            },
        );
    }

    protected function fullPath(): Attribute
    {
        return Attribute::make(
            get: fn () => Storage::disk($this->disk)->path($this->directory . '/' . $this->name . '.' . $this->extension),
        );
    }
}
