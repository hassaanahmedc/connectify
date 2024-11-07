<x-app-layout>

    <div class="flex justify-between">
        {{-- Left Side --}}
        <aside class="w-1/5 px-8 py-12 bg-white">
            <div class="fixed">
                <div id="links">
                    <div class="flex gap-3 text-base font-semibold mb-4">
                        <a href=""><img
                                src="{{ Vite::asset('/public/svg-icons/feed.svg') }}"
                                class="w-5 h-auto"
                                alt=""></a>
                        <a href=""><span>News Feed</span></a>
                    </div>

                    <div class="flex gap-3 text-base font-semibold mb-4">
                        <a href=""><img
                                src="{{ Vite::asset('/public/svg-icons/friends.svg') }}"
                                class="w-5 h-auto"
                                alt=""></a>
                        <a href=""><span>Friends</span></a>
                    </div>

                    <div class="flex gap-3 text-base font-semibold mb-4">
                        <a href=""><img
                                src="{{ Vite::asset('/public/svg-icons/calender.svg') }}"
                                class="w-5 h-auto"
                                alt=""></a>
                        <a href=""><span>Events</span></a>
                    </div>

                    <div class="flex gap-3 text-base font-semibold mb-4">
                        <a href=""><img
                                src="{{ Vite::asset('/public/svg-icons/marketplace.svg') }}"
                                class="w-5 h-auto"
                                alt=""></a>
                        <a href=""><span>Marketplace</span></a>
                    </div>

                    <div class="flex gap-3 text-base font-semibold  mb-4">
                        <a href=""><img
                                src="{{ Vite::asset('/public/svg-icons/orders.svg') }}"
                                class="w-5 h-auto"
                                alt=""></a>
                        <a href=""><span>Orders and Payment</span></a>
                    </div>
                </div>

                <div class="mt-12">
                    <span class="text-base font-bold text-zinc-400">PAGES YOU
                        LIKE</span>
                </div>
            </div>
        </aside>
        {{-- Center (News Feed) --}}
        <section class="w-5/12 mt-12">
            <div class="bg-white p-4 rounded-xl">
                <div class="flex gap-6">
                    <div class=" w-10">
                        <img src="https://placewaifu.com/image/200"
                            class="bg-gray-200 w-10 rounded-full"
                            alt="">
                    </div>
                    <div x-data="{ create_post: false, }"
                        class="w-full">
                        <div class="relative flex items-center justify-end">
                            <input type="search"
                                x-on:click = "create_post = true"
                                name=""
                                class="bg-lightMode-background rounded-full border-zinc-200 w-full text-sm focus:border-none"
                                placeholder="Share Something..."
                                id="">
                            @include('posts.create', [
                                'isEdit' => false,
                                'showVariable' => 'create_post',
                                'postUrl' => route('post.store'),
                            ])
                            <img src="{{ Vite::asset('/public/svg-icons/smiley.svg') }}"
                                class="ml-2 px-2 absolute"
                                alt="">
                        </div>
                        <div class="flex items-center gap-8 mt-4">
                            <div
                                class="flex items-center gap-2 text-base font-semibold">
                                <img src="{{ Vite::asset('/public/svg-icons/photos.svg') }}"
                                    class="w-7 h-auto"
                                    alt=""> <span>Image</span>
                            </div>

                            <div
                                class="flex items-center gap-2 text-base font-semibold">
                                <img src="{{ Vite::asset('/public/svg-icons/videocam.svg') }}"
                                    class="w-7 h-auto"
                                    alt=""> <span>Video</span>
                            </div>

                            <div
                                class="flex items-center gap-2 text-base font-semibold">
                                <img src="{{ Vite::asset('/public/svg-icons/poll.svg') }}"
                                    class="w-7 h-auto"
                                    alt=""> <span>Poll</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @include('posts.index')
        
        </section>
        
        {{-- Right Side --}}
        <aside class="w-1/4 px-8 py-12 bg-white relative">
            <div class="mb-4 fixed">
                <span class="font-bold text-zinc-400">FRIENDS</span>
            </div>
        </aside>
    </div>
</x-app-layout>