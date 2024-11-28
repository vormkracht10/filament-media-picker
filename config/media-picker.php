<?php

return [
    'accepted_file_types' => [
        'image/jpeg',
        'image/png',
        'image/webp',
        'image/svg+xml',
        'application/pdf',
    ],

    'directory' => 'media',

    'disk' => env('FILAMENT_FILESYSTEM_DISK', 'public'),

    'is_tenant_aware' => true,

    'tenant_ownership_relationship_name' => 'tenant',

    'model' => \Vormkracht10\MediaPicker\Models\Media::class,

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

    'should_preserve_filenames' => false,

    'should_register_navigation' => true,

    'visibility' => 'public',
];
