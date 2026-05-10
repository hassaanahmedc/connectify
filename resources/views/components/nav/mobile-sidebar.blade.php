{{-- 
    This file contains markup for Left sode bar on mobile screens.
    'leftSidebarOpen' variable defined in this file will be triggered from outside.     
 --}}
 
<div x-cloak 
     x-show="leftSidebarOpen" 
     @click.away="leftSidebarOpen = false"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform -translate-x-full"
     x-transition:enter-end="opacity-100 transform translate-x-0"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="opacity-100 transform translate-x-0"
     x-transition:leave-end="opacity-0 transform -translate-x-full"
     class="fixed inset-0 z-40 bg-black bg-opacity-50 md:hidden">
    
    <aside class="w-3/4 h-full overflow-y-auto bg-white px-4 py-4 shadow-xl">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Menu</h2>
            <button @click="leftSidebarOpen = false" class="min-w-[44px] min-h-[44px] flex items-center justify-center">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div id="mobile-links">
            <a href="{{ route('home') }}" 
                        class="flex items-center px-4 py-3 gap-4 text-sm font-medium cursor-pointer rounded-xl 
                            transition-all duration-200 group {{ request()->routeIs('home') 
                                ? 'text-lightMode-blueHighlight bg-blue-50' 
                                : 'text-gray-600 hover:bg-blue-50 hover:text-lightMode-blueHighlight' }}">
                        <x-svg-icons.newsfeed class="group-hover:text-lightMode-blueHighlight w-6 h-auto" />
                        <span>News Feed</span>
                    </a>
                    <a href="{{ route('profile.view', Auth::user()->id) }}"
                        class="flex items-center px-4 py-3 gap-4 text-sm font-medium text-gray-600 
                            hover:bg-blue-50 hover:text-lightMode-blueHighlight cursor-pointer 
                            rounded-xl transition-all duration-200 group">
                        <x-svg-icons.user-icon class="group-hover:text-lightMode-blueHighlight w-6 h-auto" />
                        <span>My Profile</span>
                    </a>
                    <a href="{{ route('profile.following', Auth::user()->id) }}" 
                        class="flex items-center px-4 py-3 gap-4 text-sm font-medium text-gray-600 
                            hover:bg-blue-50 hover:text-lightMode-blueHighlight cursor-pointer 
                            rounded-xl transition-all duration-200 group">
                        <x-svg-icons.user-plus class="group-hover:text-lightMode-blueHighlight w-6 h-auto" />
                        <span>Following</span>
                    </a>
                    <a href="{{ route('profile.followers', Auth::user()->id) }}" 
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
            <div class="mt-auto pt-10 pb-4 text-[11px] text-gray-400 px-3 text-center">
                <p>Privacy · Terms · Connectify © 2026</p>
            </div>
    </aside>
</div>