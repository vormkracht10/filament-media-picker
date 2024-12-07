<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasMedia
{
    /**
     * Get all media associated with the model.
     */
    public function media(): MorphToMany
    {
        return $this->morphToMany(
            config('media-picker.model'),
            'model',
            'media_relationships',
            'model_id',
            'media_ulid'
        )->withPivot('position', 'meta')
            ->orderBy('media_relationships.position');
    }

    /**
     * Attach media to the model.
     *
     * @param  string|array|\Illuminate\Support\Collection  $media
     * @param  array  $options  Additional options for attachment
     */
    public function attachMedia($media, array $options = []): self
    {
        $mediaItems = collect($media);

        $mediaItems->each(function ($mediaItem) use ($options) {
            // Resolve media ULID
            $mediaUlid = $mediaItem instanceof Model
                ? $mediaItem->ulid
                : $mediaItem;

            // Prepare pivot data
            $pivotData = [
                'position' => $options['position']
                    ?? ($this->media()->count() + 1),
                'meta' => $options['meta'] ?? null,
            ];

            // Attach media with pivot data
            $this->media()->attach($mediaUlid, $pivotData);
        });

        return $this;
    }

    /**
     * Detach media from the model.
     *
     * @param  string|array|\Illuminate\Support\Collection  $media
     */
    public function detachMedia($media): self
    {
        $mediaItems = collect($media);

        $mediaItems->each(function ($mediaItem) {
            $mediaUlid = $mediaItem instanceof Model
                ? $mediaItem->ulid
                : $mediaItem;

            $this->media()->detach($mediaUlid);
        });

        return $this;
    }

    /**
     * Sync media attachments.
     *
     * @param  string|array|\Illuminate\Support\Collection  $media
     * @param  array  $options  Sync options
     */
    public function syncMedia($media, array $options = []): self
    {
        // Detach all existing media
        $this->media()->detach();

        // Attach new media if provided
        if ($media) {
            $this->attachMedia($media, $options);
        }

        return $this;
    }

    /**
     * Get the first attached media.
     *
     * @return Model|null
     */
    public function getFirstMediaAttribute()
    {
        return $this->media->first();
    }

    /**
     * Check if the model has any media attached.
     */
    public function hasMedia(): bool
    {
        return $this->media()->exists();
    }
}
