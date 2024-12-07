<?php

return [
    /*
    |--------------------------------------------------------------------------
    | File upload
    |--------------------------------------------------------------------------
    |
    */
    'accepted_file_types' => [
        'image/jpeg',
        'image/png',
        'image/webp',
        'image/svg+xml',
        'application/pdf',
    ],

    'directory' => 'media',

    'disk' => env('FILAMENT_FILESYSTEM_DISK', 'public'),

    'should_preserve_filenames' => false,

    'should_register_navigation' => true,

    'visibility' => 'public',

    /*
    |--------------------------------------------------------------------------
    | Tenancy
    |--------------------------------------------------------------------------
    |
    */
    'is_tenant_aware' => true,
    'tenant_ownership_relationship_name' => 'tenant',
    'tenant_relationship' => 'tenant',
    // 'tenant_model' => \App\Models\Tenant::class,

    /*
    |--------------------------------------------------------------------------
    | Model and resource
    |--------------------------------------------------------------------------
    |
    */
    'model' => \Vormkracht10\MediaPicker\Models\Media::class,

    // 'user_model' => \App\Models\User::class,

    'resources' => [
        'label' => 'Media',
        'plural_label' => 'Media',
        'navigation_group' => null,
        'navigation_label' => 'Media',
        'navigation_icon' => 'heroicon-o-photo',
        'navigation_sort' => null,
        'navigation_count_badge' => false,
        'resource' => \Vormkracht10\MediaPicker\Resources\MediaResource::class,
    ],

    'file_upload' => [
        'models' => [
            // App\Models\User::class,
            // App\Models\Blog::class,
        ],
    ],
];