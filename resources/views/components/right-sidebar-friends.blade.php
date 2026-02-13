<div id="friends-container">
    <div class="flex items-center justify-between">
        <h5 class="mb-2 px-4 text-xs font-extrabold uppercase tracking-widest text-zinc-400">Suggested for you</h5>
        <span class="cursor-pointer px-4 pb-2 font-semibold text-lightMode-primary hover:underline">See all</span>
    </div>
    <div>
        @foreach ($suggestions as $user)
            <div class="mt-1 flex cursor-pointer items-center gap-2 rounded-xl px-4 py-3 transition-all 
                    duration-200 hover:cursor-pointer hover:bg-blue-50 hover:text-lightMode-blueHighlight"
                x-data="followButton({{ $user->id }}, {{ Auth::user()->isFollowing($user) ? 'true' : 'false' }})">

                <img alt="" class="h-auto w-9 rounded-full object-cover" src="https://placewaifu.com/image/200">
                <div class="flex w-full min-w-0 items-center justify-between">

                    <div class="flex min-w-0 flex-col">
                        <a class="block truncate text-sm font-bold leading-tight text-gray-900 hover:underline"
                            href="{{ route('profile.view', $user->id) }}">
                            {{ $user->fname . ' ' . $user->lname }}
                        </a>
                        <span class="mt-0.5 text-xs leading-tight text-gray-400">{{ $user->location }}</span>
                    </div>

                    <div class="ml-2 flex-shrink-0">
                        <button
                            :class="loading ? 'opacity-50 cursor-not-allowed' :
                                (isFollowing ?
                                    (isHovering ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-700') :
                                    'bg-lightMode-primary text-white')"
                            :disabled="loading" @click="toggleFollow()" @mouseenter="isHovering = true"
                            @mouseleave="isHovering = false"
                            class="rounded-lg px-3 py-1.5 text-xs font-bold transition-all duration-200 active:scale-95"
                            x-text="loading ? 'working...' :
                                    (isFollowing 
                                        ? (isHovering ? 'Unfollow' : 'Following')
                                        : 'Follow')">
                        </button>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
</div>
<hr>
