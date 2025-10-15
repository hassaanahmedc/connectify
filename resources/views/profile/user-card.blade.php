<div class="w-full pt-2 bg-white px-3 py-5 transition duration-200 hover:bg-gray-50 sm:px-5">
    <div class="flex min-w-0 gap-3">
        <a aria-label="View profile of Hassaam Ahmed"
            class="h-11 w-11 flex-shrink-0 overflow-hidden rounded-full" href="{{ $profileUrl }}">
            <img alt="{{ $userName }}'s profile photo" class="h-full w-full object-cover"
                src="{{ $profileImageUrl }}">
        </a>
        <div class="flex w-full min-w-0 flex-col justify-between">
            <div>
                <a class="block break-words font-semibold leading-tight hover:underline" href="{{ $profileUrl }}">
                    {{ $userName }}                                                                     
                </a>
                <span class="my-2 block text-sm text-gray-700">{{ $userBio }}</span>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <span class="mb-1 block text-sm text-gray-700">482 Followers</span>
                    <span class="block text-sm text-gray-700">{{ $userLocation }}</span>
                </div>
                <x-primary-button class="bg-lightMode-primary hover:bg-lightMode-blueHighlight">
                    {{ __('Follow') }}
                </x-primary-button>
            </div>
        </div>
    </div>
</div>
