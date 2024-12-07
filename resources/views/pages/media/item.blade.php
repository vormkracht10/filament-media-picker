@props(['media'])
<li class="relative" :class="{ 'ring-2 ring-primary-500 ring-offset-2': selectedMedia === '{{ $media->ulid }}' }">
    <button type="button" wire:click="mountAction('showMedia', { ulid: '{{ $media->ulid }}' })"
        @click="selectedMedia = selectedMedia === '{{ $media->ulid }}' ? null : '{{ $media->ulid }}'"
        class="group block w-full text-left focus:outline-none">
        <div class="block w-full overflow-hidden rounded-lg bg-gray-100">
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
