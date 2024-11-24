<?php

namespace Vormkracht10\MediaPicker\Commands;

use Illuminate\Console\Command;

class MediaPickerCommand extends Command
{
    public $signature = 'filament-media-picker';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
