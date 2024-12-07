@props(['media'])
<li class="relative">
    <button type="button" wire:click="mountAction('showMedia', { ulid: '{{ $media->ulid }}' })"
        class="group block w-full text-left focus:outline-none">
        <div class="block w-full overflow-hidden rounded-lg bg-gray-100 ring-2 ring-indigo-500 ring-offset-2">
            <div class="aspect-square overflow-hidden flex items-center justify-center">
                <img src="{{ $media->src }}" alt="" class="w-full h-full object-cover object-center">
            </div>
        </div>
        <p class="pointer-events-none mt-2 block truncate text-sm font-medium text-gray-900">
            {{ $media->filename }}
        </p>
        <p class="pointer-events-none block text-sm font-medium text-gray-500">
            {{ $media->humanReadableSize }}
        </p>
    </button>
</li>
