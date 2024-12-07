@props(['media'])
<div class="space-y-6 pb-16">
    <div>
        <img src="{{ $media->src }}" alt="" class="block aspect-[10/7] w-3/4 rounded-lg object-cover mx-auto">
        <div class="mt-4 flex items-start justify-between">
            <div>
                <h2 class="text-lg font-medium text-gray-900"><span class="sr-only">Details for
                    </span>{{ $media->filename }}</h2>
                <p class="text-sm font-medium text-gray-500">
                    {{ $media->humanReadableSize }}
                </p>
            </div>
        </div>
    </div>
    <div>
        <h3 class="font-medium text-gray-900">Information</h3>
        <dl class="mt-2 divide-y divide-gray-200 border-b border-t border-gray-200">
            <div class="flex justify-between py-3 text-sm font-medium">
                <dt class="text-gray-500">Created</dt>
                <dd class="whitespace-nowrap text-gray-900">{{ $media->created_at }}</dd>
            </div>
            <div class="flex justify-between py-3 text-sm font-medium">
                <dt class="text-gray-500">Last modified</dt>
                <dd class="whitespace-nowrap text-gray-900">{{ $media->updated_at }}</dd>
            </div>
            <div class="flex justify-between py-3 text-sm font-medium">
                <dt class="text-gray-500">Dimensions</dt>
                <dd class="whitespace-nowrap text-gray-900">{{ $media->width }} x {{ $media->height }}</dd>
            </div>
            <div class="flex justify-between py-3 text-sm font-medium">
                <dt class="text-gray-500">Uploaded by</dt>
                <dd class="whitespace-nowrap text-gray-900">{{ $media->user->name ?? 'N/A' }}</dd>
            </div>
        </dl>
    </div>
</div>
