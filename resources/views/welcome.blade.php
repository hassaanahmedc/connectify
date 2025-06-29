
<x-app-layout>
    <div class="flex flex-col md:flex-row relative">
        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="fixed top-16 md:top-20 right-2 md:right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded z-50 shadow-lg max-w-[90vw] md:max-w-md" role="alert">
                <strong class="font-bold text-sm">Success!</strong>
                <span class="block sm:inline text-xs sm:text-sm">{{ session('success') }}</span>
                <button class="absolute top-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                    <svg class="h-4 w-4 fill-current" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </button>
            </div>
        @endif
        
        @if (session('error'))
            <div class="fixed top-16 md:top-20 right-2 md:right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded z-50 shadow-lg max-w-[90vw] md:max-w-md" role="alert">
                <strong class="font-bold text-sm">Error!</strong>
                <span class="block sm:inline text-xs sm:text-sm">{{ session('error') }}</span>
                <button class="absolute top-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                    <svg class="h-4 w-4 fill-current" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </button>
            </div>
        @endif

        {{-- Left Side (Desktop) --}}
        <aside class="hidden md:block md:w-1/4 lg:w-1/5 px-4 md:px-8 py-4 md:py-12 bg-white">
            <div class="md:sticky md:top-20">
                <div id="links">
                    <div class="flex gap-3 text-sm sm:text-base lg:text-base font-semibold mb-4 min-h-[44px] items-center">
                        <a href="" class="min-w-[44px] min-h-[44px] flex items-center">
                            <img src="{{ Vite::asset('/public/svg-icons/feed.svg') }}" class="w-5 h-auto" alt="">
                        </a>
                        <a href="" class="min-h-[44px] flex items-center"><span>News Feed</span></a>
                    </div>

                    <div class="flex gap-3 text-sm sm:text-base lg:text-base font-semibold mb-4 min-h-[44px] items-center">
                        <a href="" class="min-w-[44px] min-h-[44px] flex items-center">
                            <img src="{{ Vite::asset('/public/svg-icons/friends.svg') }}" class="w-5 h-auto" alt="">
                        </a>
                        <a href="" class="min-h-[44px] flex items-center"><span>Friends</span></a>
                    </div>

                    <div class="flex gap-3 text-sm sm:text-base lg:text-base font-semibold mb-4 min-h-[44px] items-center">
                        <a href="" class="min-w-[44px] min-h-[44px] flex items-center">
                            <img src="{{ Vite::asset('/public/svg-icons/calender.svg') }}" class="w-5 h-auto" alt="">
                        </a>
                        <a href="" class="min-h-[44px] flex items-center"><span>Events</span></a>
                    </div>

                    <div class="flex gap-3 text-sm sm:text-base lg:text-base font-semibold mb-4 min-h-[44px] items-center">
                        <a href="" class="min-w-[44px] min-h-[44px] flex items-center">
                            <img src="{{ Vite::asset('/public/svg-icons/marketplace.svg') }}" class="w-5 h-auto" alt="">
                        </a>
                        <a href="" class="min-h-[44px] flex items-center"><span>Marketplace</span></a>
                    </div>

                    <div class="flex gap-3 text-sm sm:text-base lg:text-base font-semibold mb-4 min-h-[44px] items-center">
                        <a href="" class="min-w-[44px] min-h-[44px] flex items-center">
                            <img src="{{ Vite::asset('/public/svg-icons/orders.svg') }}" class="w-5 h-auto" alt="">
                        </a>
                        <a href="" class="min-h-[44px] flex items-center"><span>Orders and Payment</span></a>
                    </div>
                </div>

                <div class="mt-8 md:mt-12">
                    <span class="text-xs sm:text-sm lg:text-base font-bold text-zinc-400">PAGES YOU LIKE</span>
                </div>
            </div>
        </aside>

        {{-- Center (News Feed) --}}
        <section class="w-full md:w-3/4 lg:w-5/12 mt-4 md:mt-12 px-4">
            <div class="bg-white px-4 py-2 rounded-xl">
                <div class="flex gap-4 md:gap-6"> 
                    <div class="flex-shrink-0">
                        <img src="https://placewaifu.com/image/200" class="bg-gray-200 w-9 h-auto rounded-full object-cover" alt="">
                    </div>
                    <div x-data="{ create_post: false }" 
                        x-on:close-modal.window="if ($event.detail.modal === 'create_post') create_post = false"
                        class="w-full">
                        <div 
                            class="relative flex items-center justify-end cursor-pointer"
                            @click="create_post = true">
                            <div
                                class="bg-lightMode-background rounded-full border border-zinc-200 w-full text-xs sm:text-sm py-2 px-4 text-gray-500">
                                Share something...
                            </div>
                            <img src="{{ Vite::asset('/public/svg-icons/smiley.svg') }}"
                                class="ml-2 px-2 absolute right-2"
                                alt="">
                        </div>
                        
                        <!-- Post Creation Modal -->
                        @include('posts.create', [
                            'showVariable' => 'create_post',    
                        ])
                        
                        <div class="hidden sm:flex justify-around md:flex-nowrap items-center gap-4 md:gap-8 mt-2">
                            <div
                                @click="create_post = true"
                                class="flex items-center gap-2 text-xs sm:text-sm lg:text-base font-semibold cursor-pointer hover:text-lightMode-primary transition-colors min-h-[44px]">
                                <img src="{{ Vite::asset('/public/svg-icons/photos.svg') }}"
                                    class="w-6 h-auto"
                                    alt=""> <span>Image</span>
                            </div>

                            <div
                                @click="create_post = true"
                                class="flex items-center gap-2 text-xs sm:text-sm lg:text-base font-semibold cursor-pointer hover:text-lightMode-primary transition-colors min-h-[44px]">
                                <img src="{{ Vite::asset('/public/svg-icons/videocam.svg') }}"
                                    class="w-6 h-auto"
                                    alt=""> <span>Video</span>
                            </div>

                            <div
                                @click="create_post = true"
                                class="flex items-center gap-2 text-xs sm:text-sm lg:text-base font-semibold cursor-pointer hover:text-lightMode-primary transition-colors min-h-[44px]">
                                <img src="{{ Vite::asset('/public/svg-icons/poll.svg') }}"
                                    class="w-6 h-auto"
                                    alt=""> <span>Poll</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('posts.index')
        
        </section>
        
        {{-- Right Side (Desktop) --}}
        <aside class="hidden lg:block lg:w-1/4 px-4 md:px-8 py-4 md:py-12 bg-white">
            <div class="mb-4 lg:sticky lg:top-20">
                <span class="text-xs sm:text-sm lg:text-base font-bold text-zinc-400">FRIENDS</span>
            </div>
        </aside>
    </div>
</x-app-layout>