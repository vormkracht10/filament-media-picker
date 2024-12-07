<x-filament::page>
    <div class="flex flex-row relative">
        <div class="mr-2 flex-grow">
            <section class="mt-8 pb-16" aria-labelledby="gallery-heading">
                <ul role="list" x-data="{ selectedMedia: null }"
                    class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 md:grid-cols-4 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                    @foreach ($media as $m)
                        @include('filament-media-picker::pages.media.item', ['media' => $m])
                    @endforeach
                </ul>
            </section>
        </div>
    </div>
</x-filament::page>
