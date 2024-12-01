<?php

namespace Vormkracht10\MediaPicker\Models;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

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

    public function getRouteKeyName()
    {
        return 'ulid';
    }

    protected static function booted()
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

    // Dynamic tenant relationship method
    public function tenant()
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
}