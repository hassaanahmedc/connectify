<aside class="hidden md:block w-64 xl:w-72 bg-white border-r">
    <div class="sticky top-16 py-4 h-[calc(100vh-64px)]">
        <div class="h-full flex flex-col justify-between">
            <div>

                {{-- Profile Section --}}
                <div class="flex items-center px-6 mb-6 gap-3">
                    <img src="{{ Auth::user()->avatar_url }}" 
                        class="w-12 h-12 object-cover rounded-full shadow-sm shrink-0" alt="">
                    <div class="flex flex-col justify-center overflow-hidden">
                        <span class="font-bold text-sm text-gray-900 truncate leading-tight">
                            {{ Auth::user()->fname . ' ' . Auth::user()->lname }}</span>
                        <div class="flex flex-col text-xs text-gray-500 font-medium leading-normal mt-0.5">
                            <span>105 Followers</span>
                            <span>241 Following</span>
                        </div>
                    </div>
                </div>

                {{-- Action Button --}}
                <div class="px-4 mb-8">
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
                    <a href="{{ route('profile.view', auth()->user()->id) }}"
                         class="flex items-center px-4 py-3 gap-4 text-sm font-medium text-gray-600 
                            hover:bg-blue-50 hover:text-lightMode-blueHighlight cursor-pointer 
                            rounded-xl transition-all duration-200 group">
                        <x-svg-icons.user-icon class="group-hover:text-lightMode-blueHighlight w-6 h-auto" />
                        <span>My Profile</span>
                    </a>
                    <a class="flex items-center px-4 py-3 gap-4 text-sm font-medium text-gray-600 
                            hover:bg-blue-50 hover:text-lightMode-blueHighlight cursor-pointer 
                            rounded-xl transition-all duration-200 group">
                        <x-svg-icons.user-plus class="group-hover:text-lightMode-blueHighlight w-6 h-auto" />
                        <span>Following</span>
                    </a>
                    <a class="flex items-center px-4 py-3 gap-4 text-sm font-medium text-gray-600 
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