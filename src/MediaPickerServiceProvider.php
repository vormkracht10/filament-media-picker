<?php

namespace Vormkracht10\MediaPicker;

use Filament\Support\Assets\Js;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Asset;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;
use Spatie\LaravelPackageTools\Package;
use Filament\Support\Facades\FilamentIcon;
use Vormkracht10\MediaPicker\Models\Media;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Assets\AlpineComponent;
use Livewire\Features\SupportTesting\Testable;
use Vormkracht10\MediaPicker\MediaPickerPlugin;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Vormkracht10\MediaPicker\Testing\TestsMediaPicker;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Vormkracht10\MediaPicker\Commands\MediaPickerCommand;

class MediaPickerServiceProvider extends PackageServiceProvider
{
    public static string $name = 'media-picker';

    public static string $viewNamespace = 'filament-media-picker';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('vormkracht10/filament-media-picker');
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void {}

    public function boot(): void
    {
        // Allow setting tenant relationship and model
        MediaPickerPlugin::configureTenantUsing(function ($tenantRelationship, $tenantModel) {
            Config::set('media-picker.tenant_relationship', $tenantRelationship);
            Config::set('media-picker.tenant_model', $tenantModel);
        });
    }

    public function packageBooted(): void
    {
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/filament-media-picker/{$file->getFilename()}"),
                ], 'filament-media-picker-stubs');
            }
        }

        // Testing
        Testable::mixin(new TestsMediaPicker);
    }

    protected function getAssetPackageName(): ?string
    {
        return 'vormkracht10/filament-media-picker';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('filament-media-picker', __DIR__ . '/../resources/dist/components/filament-media-picker.js'),
            // Css::make('filament-media-picker-styles', __DIR__ . '/../resources/dist/filament-media-picker.css'),
            // Js::make('filament-media-picker-scripts', __DIR__ . '/../resources/dist/filament-media-picker.js'),
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            MediaPickerCommand::class,
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            'create_media_table',
            'add_tenant_aware_column_to_media_table',
        ];
    }
}
