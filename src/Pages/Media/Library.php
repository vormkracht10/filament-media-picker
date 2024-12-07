<?php

namespace Vormkracht10\MediaPicker\Pages\Media;

use Filament\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Vormkracht10\MediaPicker\MediaPickerPlugin;
use Vormkracht10\MediaPicker\Models\Media;
use Vormkracht10\MediaPicker\Resources\MediaResource;
use Vormkracht10\MediaPicker\Resources\MediaResource\CreateMedia;

class Library extends Page implements HasForms
{
    use InteractsWithForms;
    use WithPagination;

    protected static ?string $navigationGroup = 'Media';

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?int $navigationSort = 0;

    protected static string $view = 'filament-media-picker::pages.media.library';

    protected static ?string $slug = 'media-library';

    public ?Media $selectedMedia = null;

    public ?Collection $media = null;

    public function getHeading(): string
    {
        return __('Media Library');
    }

    public function mount(): void
    {
        $this->loadMedia();
    }

    public function loadMedia(): void
    {
        // $startDate = $this->filters['startDate'] ?? null;
        // $endDate = $this->filters['endDate'] ?? null;

        $query = Media::orderBy('created_at', 'desc');

        // if ($startDate && $endDate) {
        //     $query->whereBetween('created_at', [$startDate, $endDate]);
        // }

        $media = $query->get();

        $this->media = $media;
    }

    protected function getActions(): array
    {
        return [
            Action::make('upload')
                ->label(__('Upload'))
                ->form(function (Form $form) {
                    return MediaResource::form($form);
                })
                ->action(function (array $data) {
                    $createMedia = new CreateMedia;
                    $createMedia->handleRecordCreation($data);

                    $this->loadMedia();

                    Notification::make()
                        ->title(__('Uploaded media'))
                        ->success()
                        ->send();
                })
                ->modal()
                ->icon('heroicon-o-arrow-up-tray'),
        ];
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

    public function setMedia(string $mediaId): void
    {
        $media = Media::find($mediaId);

        if ($media) {
            $this->selectedMedia = $media;
        }
    }

    public function showMediaAction(): Action
    {
        return Action::make('showMedia')
            ->label(__('Show'))
            ->modalContent(function (array $arguments) {
                $this->setMedia($arguments['ulid']);

                return view('filament-media-picker::pages.media.overlay', [
                    'media' => $this->selectedMedia,
                ]);
            })
            ->modalFooterActions([
                $this->downloadAction(),
                $this->deleteAction(),
            ])
            ->slideOver();
    }

    public function downloadAction(): Action
    {
        return Action::make('download')
            ->label(__('Download'))
            ->color('gray')
            ->action(function () {
                if ($this->selectedMedia) {
                    return response()->download($this->selectedMedia->src);
                }
            });
    }

    public function deleteAction(): Action
    {
        return Action::make('delete')
            ->label(__('Delete'))
            ->color('danger')
            ->requiresConfirmation()
            ->action(function () {
                if ($this->selectedMedia) {
                    $this->selectedMedia->delete();

                    $this->loadMedia();

                    Notification::make()
                        ->title(__('Deleted media'))
                        ->success()
                        ->send();
                }
            });
    }
}
