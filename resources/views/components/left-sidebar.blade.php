<aside x-data class="hidden md:block w-64 xl:w-72 bg-white border-r">
    <div class="sticky py-4">
        <div class="h-full flex flex-col justify-between">
            <div>

                {{-- Profile Section --}}
                <div class="flex items-center px-6 mb-6 gap-3">
                    <img x-on:click.stop="window.location.href='{{ route('profile.view', $sidebarUser->id) }}'"
                        src="{{ Auth::user()->avatar_url }}" 
                        class="w-14 h-14 object-cover rounded-full shadow-sm shrink-0 cursor-pointer 
                            transition-all duration-300 border-2 border-transparent 
                            hover:shadow-md hover:border-gray-800 hover:brightness-105" 
                        alt="{{ Auth::user()->fname . " 's profile Picture" }}">

                    <div class="flex flex-col justify-center overflow-hidden">
                        <span class="font-bold text-sm text-gray-900 truncate leading-tight cursor-pointer hover:underline"
                            x-on:click.stop="window.location.href='{{ route('profile.view', $sidebarUser->id) }}'">
                            {{ $sidebarUser->fname . ' ' . $sidebarUser->lname }}</span>

                        <div class="flex flex-col text-xs text-gray-500 font-medium leading-normal mt-0.5">
                            <div class="hover:underline"
                                x-on:click.stop="
                                window.location.href='{{ route('profile.following', $sidebarUser->id) }}'">
                                <span class="font-semibold cursor-pointer">{{ $sidebarUser->following_count ?? 0 }}</span>
                                <span class="text-xs text-gray-500 cursor-pointer">Following</span>
                            </div>
                            <div class="hover:underline" 
                                x-on:click.stop="
                                    window.location.href='{{ route('profile.followers', $sidebarUser->id) }}'">
                                <span class="font-semibold cursor-pointer">{{ $sidebarUser->followers_count ?? 0 }}</span>
                                <span class="text-xs text-gray-500 cursor-pointer">Followers</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action Button --}}
                <div class="px-4 mb-8" @click="
                    $dispatch('open-modal', 'post-modal');
                    $dispatch('fill-post-data', { isEdit: false });">
                    <div class="rounded-xl shadow-md px-4 py-3 bg-lightMode-primary text-white font-bold 
                                flex items-center justify-center gap-2 cursor-pointer
                                hover:bg-lightMode-blueHighlight active:scale-95 transition-transform"
                            id="">
                        <x-svg-icons.plus class="group-hover:text-lightMode-blueHighlight w-6 h-auto" />
                        <span class="text-sm">Create Post</span>
                    </div>
                </div>

                {{-- Navigation Links --}}
                <div id="links" class="space-y-2 px-4">
                    <a href="{{ route('home') }}" 
                        class="flex items-center px-4 py-3 gap-4 text-sm font-medium cursor-pointer rounded-xl 
                            transition-all duration-200 group {{ request()->routeIs('home') 
                                ? 'text-lightMode-blueHighlight bg-blue-50' 
                                : 'text-gray-600 hover:bg-blue-50 hover:text-lightMode-blueHighlight' }}">
                        <x-svg-icons.newsfeed class="group-hover:text-lightMode-blueHighlight w-6 h-auto" />
                        <span>News Feed</span>
                    </a>
                    <a href="{{ route('profile.view', $sidebarUser->id) }}"
                        class="flex items-center px-4 py-3 gap-4 text-sm font-medium text-gray-600 
                            hover:bg-blue-50 hover:text-lightMode-blueHighlight cursor-pointer 
                            rounded-xl transition-all duration-200 group">
                        <x-svg-icons.user-icon class="group-hover:text-lightMode-blueHighlight w-6 h-auto" />
                        <span>My Profile</span>
                    </a>
                    <a href="{{ route('profile.following', $sidebarUser->id) }}" 
                        class="flex items-center px-4 py-3 gap-4 text-sm font-medium text-gray-600 
                            hover:bg-blue-50 hover:text-lightMode-blueHighlight cursor-pointer 
                            rounded-xl transition-all duration-200 group">
                        <x-svg-icons.user-plus class="group-hover:text-lightMode-blueHighlight w-6 h-auto" />
                        <span>Following</span>
                    </a>
                    <a href="{{ route('profile.followers', $sidebarUser->id) }}" 
                        class="flex items-center px-4 py-3 gap-4 text-sm font-medium text-gray-600 
                            hover:bg-blue-50 hover:text-lightMode-blueHighlight cursor-pointer 
                            rounded-xl transition-all duration-200 group">
                        <x-svg-icons.user-group class="group-hover:text-lightMode-blueHighlight w-6 h-auto" />
                        <span>Followers</span>
                    </a>
                    <a href="{{ route('users.explore') }}" 
                        class="flex items-center px-4 py-3 gap-4 text-sm font-medium cursor-pointer rounded-xl 
                            transition-all duration-200 group {{ request()->routeIs('users.explore') 
                                ? 'text-lightMode-blueHighlight bg-blue-50' 
                                : 'text-gray-600 hover:bg-blue-50 hover:text-lightMode-blueHighlight' }}">
                        <x-svg-icons.magnifying-glass class="group-hover:text-lightMode-blueHighlight w-6 h-auto" />
                        <span>Explore Users</span>
                    </a>
                </div>
            </div>
            
            {{-- Footer --}}
            <div class="mt-auto pt-10 pb-4 text-[11px] text-gray-400 px-3 text-center">
                <p>Privacy · Terms · Connectify © 2026</p>
            </div>
        </div>
    </div>
</aside>