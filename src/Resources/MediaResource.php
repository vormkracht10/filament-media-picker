<?php

namespace Vormkracht10\MediaPicker\Resources;

use Filament\Facades\Filament;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Vormkracht10\MediaPicker\Components\MediaPicker;
use Vormkracht10\MediaPicker\MediaPickerPlugin;

class MediaResource extends Resource
{
    public static function getModel(): string
    {
        return config('media-picker.model');
    }

    public static function isScopedToTenant(): bool
    {
        return config('media-picker.is_tenant_aware') ?? static::$isScopedToTenant;
    }

    public static function getTenantOwnershipRelationshipName(): string
    {
        return config('media-picker.tenant_ownership_relationship_name') ?? Filament::getTenantOwnershipRelationshipName();
    }

    public static function getModelLabel(): string
    {
        return MediaPickerPlugin::get()->getLabel();
    }

    public static function getPluralModelLabel(): string
    {
        return MediaPickerPlugin::get()->getPluralLabel();
    }

    public static function getNavigationLabel(): string
    {
        return MediaPickerPlugin::get()->getNavigationLabel() ?? Str::title(static::getPluralModelLabel()) ?? Str::title(static::getModelLabel());
    }

    public static function getNavigationIcon(): string
    {
        return MediaPickerPlugin::get()->getNavigationIcon();
    }

    public static function getNavigationSort(): ?int
    {
        return MediaPickerPlugin::get()->getNavigationSort();
    }

    public static function getNavigationGroup(): ?string
    {
        return MediaPickerPlugin::get()->getNavigationGroup();
    }

    public static function getNavigationBadge(): ?string
    {
        if (! MediaPickerPlugin::get()->getNavigationCountBadge()) {
            return null;
        }

        if (Filament::hasTenancy() && config('media-picker.is_tenant_aware')) {
            return static::getEloquentQuery()
                ->where(config('media-picker.tenant_relationship') . '_ulid', Filament::getTenant()->id)
                ->count();
        }

        return number_format(static::getModel()::count());
    }

    public static function shouldRegisterNavigation(): bool
    {
        return MediaPickerPlugin::get()->shouldRegisterNavigation();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                MediaPicker::make()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('filename')
                    ->label(__('Filename'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('extension')
                    ->label(__('Extension'))
                    ->searchable()
                    ->sortable(),
                IconColumn::make('public')
                    ->boolean()
                    ->label(__('Public'))
                    ->sortable(),

            ])
            ->actions([
                Tables\Actions\DeleteAction::make()
                    ->hiddenLabel()
                    ->tooltip(__('Delete')),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc')
            ->defaultPaginationPageOption(12)
            ->paginationPageOptions([6, 12, 24, 48, 'all'])
            ->recordUrl(false);
    }

    public static function getPages(): array
    {
        return [
            'index' => MediaResource\ListMedia::route('/'),
            'create' => MediaResource\CreateMedia::route('/create'),
            'edit' => MediaResource\EditMedia::route('/{record}/edit'),
        ];
    }
}
