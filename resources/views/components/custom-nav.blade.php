@vite('resources/js/features/search/index.js')

<div x-data="{ searchOpen: false, leftSidebarOpen: false, rightSidebarOpen: false }" x-init="$watch('leftSidebarOpen', value => console.log('Sidebar state:', value))">
    <nav class="flex justify-between items-center px-4 sm:px-8 md:px-12 lg:px-20 py-2 bg-white sticky top-0 w-full z-50">
        <section id="searchSection"
            class="flex items-center justify-between gap-4 md:gap-8 lg:gap-16 w-full md:w-2/5">
            {{-- Left Sidebar Toggle (Mobile) --}}
            <div class="md:hidden min-w-[44px] min-h-[44px] flex items-center justify-center text-base">
                <button @click="leftSidebarOpen = !leftSidebarOpen" class="p-2 rounded-full min-w-[44px] min-h-[44px] flex items-center justify-center">
                    <svg x-show="!leftSidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="leftSidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            {{-- Logo --}}
            <div x-show="!searchOpen || window.innerWidth >= 768" class="flex-shrink-0">
                @include('components.application-logo')
            </div>
            
            {{-- Search Bar (Desktop) --}}
            <div class="hidden md:flex relative min-w-[250px] items-center justify-end w-full">
                <input type="search"
                    class="bg-lightMode-background rounded-xl border-zinc-200 w-full text-sm focus:border-none"
                    name="search"
                    id="search-nav-desktop"
                    placeholder="search"
                    required>
                <a href=""
                    class="ml-2 px-2 absolute right-0"><img
                        src="{{ Vite::asset('/public/svg-icons/search.svg') }}"
                        alt="" class="w-5 h-5"></a>
                <div id="search-results-desktop" 
                    class="hidden absolute w-full top-full left-0 mt-2 bg-white border-zinc-200 rounded-xl shadow-xl">
                    <ul class="divide-y divide-grey-200 text-sm max-h-60 overflow-y-auto"></ul>
                </div>

            </div>
            
            {{-- Search Icon (Mobile) --}}
            <div class="md:hidden ml-auto">
                <button @click="searchOpen = !searchOpen" class="mr-2 flex items-center justify-center">
                    <img src="{{ Vite::asset('/public/svg-icons/search.svg') }}" alt="" class="w-6 h-6">
                </button>
            </div>
            
            {{-- Search Bar (Mobile) --}}
            <div x-show="searchOpen" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 class="absolute left-0 top-0 w-full bg-white p-2 flex items-center z-50 md:hidden">
                <button @click="searchOpen = false" class="p-2 min-w-[44px] min-h-[44px] flex items-center justify-center">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <div class="relative flex-1 mx-2">
                    <input type="search"
                        class="bg-lightMode-background rounded-xl border-zinc-200 w-full text-sm focus:border-none"
                        name="search-nav-mobile"
                        id="search-nav-mobile"
                        placeholder="search"
                        required
                        @keydown.escape="searchOpen = false">
                    <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2">
                        <img src="{{ Vite::asset('/public/svg-icons/search.svg') }}" alt="" class="w-8 h-auto">
                    </button>
                    <div id="search-results-mobile"
                        class="hidden absolute top-full left-0 w-full mt-2 bg-white border rounded-lg shadow-lg z-50">
                        <ul class="divide-y divide-gray-200 text-sm max-h-60 overflow-y-auto"></ul>
                    </div>
                </div>
            </div>
        </section>

        <section id="iconSection"
            class="flex gap-2" x-show="!searchOpen || window.innerWidth >= 768">
            <div id=desktop-icons class=hidden>
                <div>
                    <a href="">
                        <img class="min-w-8 h-fit"
                            src="{{ Vite::asset('/public/svg-icons/user-plus.svg') }}"
                            alt="">
                    </a>
                </div>
                <div>
                    <a href=""><img class="w-8 h-fit"
                            src="{{ Vite::asset('/public/svg-icons/message.svg') }}"
                            alt=""></a>
                </div>
                <div>
                    <a href=""><img class="w-8 h-auto"
                            src="{{ Vite::asset('/public/svg-icons/notification.svg') }}"
                            alt=""></a>
                </div>
            </div>
            {{-- Nav Dropdown {Mobile}--}}
            <div class="flex">
                <a href=""><img class="w-8 h-auto"
                        src="{{ Vite::asset('/public/svg-icons/guest-icon.svg') }}"
                        alt=""></a>
                <x-dropdown align="right"
                    width="48"
                    contentClasses="bg-white">
                    <x-slot name="trigger">
                        <div class="ms-1">
                            <img class="w-5 h-auto"
                                src="{{ Vite::asset('/public/svg-icons/expand.svg') }}"
                                alt="">
                        </div>
                    </x-slot>
                    {{-- Nav Dropdown Links {Mobile}--}}
                    <x-slot name="content">
                        @auth
                            <x-dropdown-link
                                class="dark:text-black dark:hover:bg-lightMode-background">
                                {{ __('Friend Requests') }}
                            </x-dropdown-link>

                            <x-dropdown-link
                                class="dark:text-black dark:hover:bg-lightMode-background">
                                {{ __('Messages') }}
                            </x-dropdown-link>

                            <x-dropdown-link 
                                class="dark:text-black dark:hover:bg-lightMode-background">
                                {{ __('Notification') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('profile.edit')"
                                class="dark:text-black dark:hover:bg-lightMode-background">
                                {{ __('Edit Profile') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('profile.view', Auth::id())"
                                class="dark:text-black dark:hover:bg-lightMode-background">
                                {{ __(optional(Auth::user())->fname) }}
                            </x-dropdown-link>

                            <form method="POST" 
                                action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    class="dark:text-black dark:hover:bg-lightMode-background"
                                    onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        @endauth

                        @guest
                            <x-dropdown-link :href="route('login')"
                                class="dark:text-black dark:hover:bg-lightMode-background">
                                {{ __('Log in') }}
                            </x-dropdown-link>
                        @endguest
                    </x-slot>
                </x-dropdown>
            </div>
        </section>
    </nav>

    {{-- Left Sidebar for Mobile (Moved from welcome.blade.php) --}}
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
</div>