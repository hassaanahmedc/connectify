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
            <div class="flex gap-3 text-sm sm:text-base font-semibold mb-4 min-h-[44px] items-center">
                <a href="" class="min-w-[44px] min-h-[44px] flex items-center">
                    <img src="{{ Vite::asset('/public/svg-icons/feed.svg') }}" class="w-5 h-auto" alt="">
                </a>
                <a href="" class="min-h-[44px] flex items-center"><span>News Feed</span></a>
            </div>
            <div class="flex gap-3 text-sm sm:text-base font-semibold mb-4 min-h-[44px] items-center">
                <a href="" class="min-w-[44px] min-h-[44px] flex items-center">
                    <img src="{{ Vite::asset('/public/svg-icons/friends.svg') }}" class="w-5 h-auto" alt="">
                </a>
                <a href="" class="min-h-[44px] flex items-center"><span>Friends</span></a>
            </div>
            <div class="flex gap-3 text-sm sm:text-base font-semibold mb-4 min-h-[44px] items-center">
                <a href="" class="min-w-[44px] min-h-[44px] flex items-center">
                    <img src="{{ Vite::asset('/public/svg-icons/calender.svg') }}" class="w-5 h-auto" alt="">
                </a>
                <a href="" class="min-h-[44px] flex items-center"><span>Events</span></a>
            </div>
            <div class="flex gap-3 text-sm sm:text-base font-semibold mb-4 min-h-[44px] items-center">
                <a href="" class="min-w-[44px] min-h-[44px] flex items-center">
                    <img src="{{ Vite::asset('/public/svg-icons/marketplace.svg') }}" class="w-5 h-auto" alt="">
                </a>
                <a href="" class="min-h-[44px] flex items-center"><span>Marketplace</span></a>
            </div>
            <div class="flex gap-3 text-sm sm:text-base font-semibold mb-4 min-h-[44px] items-center">
                <a href="" class="min-w-[44px] min-h-[44px] flex items-center">
                    <img src="{{ Vite::asset('/public/svg-icons/orders.svg') }}" class="w-5 h-auto" alt="">
                </a>
                <a href="" class="min-h-[44px] flex items-center"><span>Orders and Payment</span></a>
            </div>
        </div>
        <div class="mt-8">
            <span class="text-sm font-bold text-zinc-400">PAGES YOU LIKE</span>
        </div>
    </aside>
</div>