<?php

namespace Vormkracht10\MediaPicker\Resources\MediaResource;

use Filament\Resources\Pages\CreateRecord;
use Vormkracht10\MediaPicker\MediaPickerPlugin;

class CreateMedia extends CreateRecord
{
    public static function getResource(): string
    {
        return MediaPickerPlugin::get()->getResource();
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $data;
    }
}
