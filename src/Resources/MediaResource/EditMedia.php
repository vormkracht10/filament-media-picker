<?php

namespace Vormkracht10\MediaPicker\Resources\MediaResource;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Vormkracht10\MediaPicker\MediaPickerPlugin;

class EditMedia extends EditRecord
{
    public static function getResource(): string
    {
        return MediaPickerPlugin::get()->getResource();
    }

    public function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->action('save')
                ->label(__('Save')),
            Action::make('preview')
                ->label(__('Preview'))
                ->color('gray')
                ->url($this->record->url, shouldOpenInNewTab: true),
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // 
    }
}