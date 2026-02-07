<div class="w-full px-4 py-4 transition duration-200 hover:bg-gray-50 border-x border-b sm:px-6">
    <div class="flex items-center justify-between gap-4">
        
        {{-- Left Side: Avatar and Info --}}
        <div class="flex min-w-0 gap-4">
            {{-- Avatar --}}
            <a href="{{ $profileUrl }}" class="h-12 w-12 flex-shrink-0 overflow-hidden rounded-full">
                <img src="{{ $profileImageUrl }}" alt="{{ $userName }}" class="h-full w-full object-cover">
            </a>

            {{-- Text Content --}}
            <div class="flex min-w-0 flex-col justify-center">
                <a href="{{ $profileUrl }}" class="block truncate font-semibold text-gray-900 hover:underline leading-tight">
                    {{ $userName }}
                </a>
                
                @if($userBio)
                    <p class="text-sm text-gray-600 line-clamp-1 mt-0.5">
                        {{ $userBio }}
                    </p>
                @endif

                <div class="mt-1 flex items-center gap-2 text-[12px] text-gray-500 font-medium">
                    <span>482 Followers</span>
                    @if($userLocation)
                        <span class="text-gray-300">•</span>
                        <span class="truncate">{{ $userLocation }}</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right Side: Action Button --}}
        <div class="flex-shrink-0">
        @if(Auth::user()->isFollowing($user))
            <button data-user-id="{{ $user->id }}" id="follow-btn" 
                    class="group fflex items-center gap-2 rounded-lg bg-gray-100 px-4 py-2 text-sm 
                        font-bold text-gray-700 transition hover:bg-red-50 hover:text-red-600 shadow-sm">
                <span class="group-hover:hidden">Following</span>
                <span class="hidden group-hover:inline">Unfollow</span>
            </button>
        @else
            <button data-user-id="{{ $user->id }}" id="follow-btn"  
                class="flex items-center gap-2 rounded-lg bg-lightMode-primary px-4 py-2 text-sm font-bold 
                text-white transition hover:bg-lightMode-primary">
                <x-svg-icons.user-plus class="w-5 h-auto" />
                Follow
            </button>
        @endif
        </div>

    </div>
</div> {{-- This is the critical closing tag --}}