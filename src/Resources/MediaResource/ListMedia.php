<?php

namespace Vormkracht10\MediaPicker\Resources\MediaResource;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Vormkracht10\MediaPicker\MediaPickerPlugin;

class ListMedia extends ListRecords
{
    public static function getResource(): string
    {
        return MediaPickerPlugin::get()->getResource();
    }

    public function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
