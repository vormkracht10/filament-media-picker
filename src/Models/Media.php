<?php

namespace Vormkracht10\MediaPicker\Models;

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Media extends Model
{
    use HasUlids;
    use SoftDeletes;

    protected $primaryKey = 'ulid';

    protected $guarded = [];

    protected $casts = [
        'width' => 'integer',
        'height' => 'integer',
        'size' => 'integer',
        'public' => 'boolean',
    ];

    protected $appends = [
        'humanReadableSize',
        'src',
    ];

    public function getRouteKeyName(): string
    {
        return 'ulid';
    }

    protected static function booted(): void
    {
        static::creating(function ($model) {
            $tenantRelationship = Config::get('media-picker.tenant_relationship');
            $tenantModel = Config::get('media-picker.tenant_model');

            if ($tenantRelationship && class_exists($tenantModel)) {
                $currentTenant = Filament::getTenant();

                if ($currentTenant) {
                    $model->{$tenantRelationship . '_ulid'} = $currentTenant->ulid;
                }
            }
        });
    }

    public function user(): ?BelongsTo
    {
        return $this->belongsTo(Config::get('media-picker.user_model'));
    }

    public function tenant(): ?BelongsTo
    {
        $tenantRelationship = Config::get('media-picker.tenant_relationship');
        $tenantModel = Config::get('media-picker.tenant_model');

        if ($tenantRelationship && class_exists($tenantModel)) {
            return $this->belongsTo(
                $tenantModel,
                $tenantRelationship . '_ulid'
            );
        }

        return null;
    }

    public function getHumanReadableSizeAttribute(): string
    {
        $bytes = $this->size;

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getSrcAttribute(): string
    {
        $disk = Config::get('media-picker.disk', 'public');
        $directory = Config::get('media-picker.directory', 'media');

        return Storage::disk($disk)->url($directory . '/' . $this->filename);
    }

    public function download(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $disk = Config::get('media-picker.disk', 'public');
        $directory = Config::get('media-picker.directory', 'media');

        return Storage::disk($disk)->download($directory . '/' . $this->filename);
    }
}