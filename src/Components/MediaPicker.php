<?php

namespace Vormkracht10\MediaPicker\Components;

use Filament\Forms\Components\FileUpload;

class MediaPicker extends FileUpload
{
    public static function make(string $name = 'media'): static
    {
        return parent::make($name)
            ->label(__('File(s)'))
            ->disk(config('media-picker.disk'))
            ->directory(config('media-picker.directory'))
            ->preserveFilenames(config('media-picker.should_preserve_filenames'))
            ->visibility(config('media-picker.visibility'))
            ->acceptedFileTypes(config('media-picker.accepted_file_types'))
            ->multiple()
            ->columnSpanFull();
    }
}
