@props(['media'])
<li class="relative">
    <button type="button" wire:click="mountAction('showMedia', { ulid: '{{ $media->ulid }}' })"
        class="group block w-full text-left focus:outline-none">
        <div class="block w-full overflow-hidden rounded-lg bg-gray-100 ring-2 ring-indigo-500 ring-offset-2">
            <img src="{{ $media->src }}" alt="" class="pointer-events-none aspect-[10/7] object-cover">
        </div>
        <p class="pointer-events-none mt-2 block truncate text-sm font-medium text-gray-900">
            {{ $media->filename }}
        </p>
        <p class="pointer-events-none block text-sm font-medium text-gray-500">
            {{ $media->humanReadableSize }}
        </p>
    </button>
</li>
