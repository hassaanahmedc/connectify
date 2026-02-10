<div class="w-full px-4 py-4 transition duration-200 hover:bg-gray-50 border-x border-b sm:px-6">
    <div class="flex items-center justify-between gap-4" x-data="
    followButton({{$user->id}}, {{Auth::user()->isFollowing($user) ? 'true' : 'false'}} )">
        
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
            <button 
                @click="toggleFollow()"
                :disabled="loading"
                @mouseenter="isHovering = true"
                @mouseleave="isHovering = false"
                :class="loading ? 'opacity-50 cursor-not-allowed' :
                    (isFollowing 
                        ? (isHovering ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-700' )
                        : 'bg-lightMode-primary text-white')"
                x-text="loading ? 'working...' :
                    (isFollowing 
                        ? (isHovering ? 'Unfollow' : 'Following')
                        : 'Follow')"
                class="px-4 py-2 rounded-lg text-sm font-bold transition-all duration-200 active:scale-95">
            </button>
        </div>
    </div>
</div> 