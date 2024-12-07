# Filament Media Picker

[![Latest Version on Packagist](https://img.shields.io/packagist/v/vormkracht10/filament-media-picker.svg?style=flat-square)](https://packagist.org/packages/vormkracht10/filament-media-picker)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/vormkracht10/filament-media-picker/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/vormkracht10/filament-media-picker/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/vormkracht10/filament-media-picker/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/vormkracht10/filament-media-picker/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/vormkracht10/filament-media-picker.svg?style=flat-square)](https://packagist.org/packages/vormkracht10/filament-media-picker)

## Nice to meet you, we're [Vormkracht10](https://vormkracht10.nl)

Hi! We are a web development agency from Nijmegen in the Netherlands and we use Laravel for everything: advanced websites with a lot of bells and whitles and large web applications.

## About the package

This package is a media picker and library for Filament. It allows you to easily add a media picker to your Filament forms and use it to select images, videos, and other media files from your media library. It also provides a media library that you can use to manage your media files.

## Installation

You can install the package via composer:

```bash
composer require vormkracht10/filament-media-picker
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="media-picker-migrations"
```

> [!NOTE]
> When you are making use of tenancy, make sure to run the migrations **after** configuring the package using the config file. This will create the media table in your database with the correct columns.

You can publish the config file with:

```bash
php artisan vendor:publish --tag="media-picker-config"
```

This is the contents of the published config file:

```php
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

    'should_preserve_filenames' => false,

    'should_register_navigation' => true,

    'visibility' => 'public',

    // Tenancy
    'is_tenant_aware' => true,
    'tenant_ownership_relationship_name' => 'tenant',
    'tenant_relationship' => 'tenant',
    // 'tenant_model' => \App\Models\Tenant::class,

    // Model and resource
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
```

After publishing the config file and running the migrations you should add the following code to your `PanelServiceProvider` to include the media picker in your Filament application:

```php

use Filament\Support\Assets\Css;
use Vormkracht10\MediaPicker\MediaPicker;
use Filament\Support\Facades\FilamentAsset;

public function panel(Panel $panel): Panel
{
    // ...

    FilamentAsset::register([
        Css::make('filament-media-picker', __DIR__ . '/../vendor/vormkracht10/filament-media-picker/resources/css/filament-media-picker.css'),
    ], package: 'vormkracht10/filament-media-picker');

    // ...

    return $panel
        ->plugins([
            MediaPickerPlugin::make()
                ->configureTenant('site', Site::class), // Optional
        ]);
}
```

## Usage

### Tenancy

If you are using tenancy, you can set the `is_tenant_aware` config option to `true` and set the `tenant_ownership_relationship_name` and `tenant_relationship` config options to the names of the relationships on the media model and the tenant model, respectively. You can also set the `tenant_model` config option to the fully qualified class name of the tenant model.

### File upload

If you want to be able to setup a relationship between a model and a media file, you can add the model to the `models` array in the `file_upload` config option. This will add a select field to the media form that allows you to select the model that the media file belongs to. You can then use the `Vormkracht10\MediaPicker\Traits\HasMedia` trait on the model to setup the relationship.

### Manually define the relationship between a model and a media file

Use the `Vormkracht10\MediaPicker\Traits\HasMedia` trait on the model to setup the relationship between the model and the media file. You can then use the following methods to define the relationship:

```php
$model->attachMedia($mediaUlid);

// or with meta data
$model->attachMedia($mediaUlid, [
    'position' => 1,
    'meta' => ['description' => 'Profile picture']
]);
```

### Media Picker component

You can use the `MediaPicker` component in your forms to add a media picker to your Filament forms. The `MediaPicker` component is a `FileUpload` field that respects the `media-picker` config file.

```php
use Vormkracht10\MediaPicker\Components\MediaPicker;

MediaPicker::make('media'),

```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Baspa](https://github.com/vormkracht10)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
