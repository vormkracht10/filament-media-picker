<?php

namespace Vormkracht10\MediaPicker;

use Closure;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use Vormkracht10\MediaPicker\Resources\MediaResource;

class MediaPickerPlugin implements Plugin
{
    use EvaluatesClosures;

    protected string | Closure | null $label = null;

    protected string | Closure | null $navigationGroup = null;

    protected string | Closure | null $navigationLabel = null;

    protected string | Closure | null $navigationIcon = null;

    protected int | Closure | null $navigationSort = null;

    protected bool | Closure | null $navigationCountBadge = null;

    protected bool | Closure | null $shouldRegisterNavigation = null;

    protected string | Closure | null $defaultListView = null;

    protected string | Closure | null $pluralLabel = null;

    protected ?string $resource = null;

    public function getId(): string
    {
        return 'filament-media-picker';
    }

    public function register(Panel $panel): void
    {
        //
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }

    public function getResource(): string
    {
        return $this->resource ?? config('media-picker.resources.resource') ?? MediaResource::class;
    }

    public function getLabel(): string
    {
        return $this->evaluate($this->label) ?? config('media-picker.resources.label');
    }

    public function getPluralLabel(): string
    {
        return $this->evaluate($this->pluralLabel) ?? config('media-picker.resources.plural_label');
    }

    public function getNavigationGroup(): ?string
    {
        return $this->evaluate($this->navigationGroup) ?? config('media-picker.resources.navigation_group');
    }

    public function getNavigationLabel(): ?string
    {
        return $this->evaluate($this->navigationLabel) ?? config('media-picker.resources.navigation_label');
    }

    public function getNavigationIcon(): ?string
    {
        return $this->evaluate($this->navigationIcon) ?? config('media-picker.resources.navigation_icon');
    }

    public function getNavigationSort(): ?int
    {
        return $this->evaluate($this->navigationSort) ?? config('media-picker.resources.navigation_sort');
    }

    public function getNavigationCountBadge(): ?bool
    {
        return $this->navigationCountBadge ?? config('media-picker.resources.navigation_count_badge');
    }

    public function shouldRegisterNavigation(): ?bool
    {
        return $this->evaluate($this->shouldRegisterNavigation) ?? config('media-picker.should_register_navigation');
    }

    public function navigationGroup(string | Closure | null $group = null): static
    {
        $this->navigationGroup = $group;

        return $this;
    }

    public function navigationLabel(string | Closure | null $label = null): static
    {
        $this->navigationLabel = $label;

        return $this;
    }

    public function navigationIcon(string | Closure $icon): static
    {
        $this->navigationIcon = $icon;

        return $this;
    }

    public function navigationSort(int | Closure $order): static
    {
        $this->navigationSort = $order;

        return $this;
    }

    public function navigationCountBadge(bool $show = true): static
    {
        $this->navigationCountBadge = $show;

        return $this;
    }

    public function registerNavigation(bool | Closure $condition = true): static
    {
        $this->shouldRegisterNavigation = $condition;

        return $this;
    }

    public function pluralLabel(string | Closure $label): static
    {
        $this->pluralLabel = $label;

        return $this;
    }

    public function resource(string $resource): static
    {
        $this->resource = $resource;

        return $this;
    }

    public function label(string | Closure $label): static
    {
        $this->label = $label;

        return $this;
    }
}
