<?php

namespace Vormkracht10\MediaPicker\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Vormkracht10\MediaPicker\MediaPicker
 */
class MediaPicker extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Vormkracht10\MediaPicker\MediaPicker::class;
    }
}
