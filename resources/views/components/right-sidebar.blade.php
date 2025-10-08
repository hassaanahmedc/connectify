<aside class="hidden lg:block w-80 bg-white border-l overflow-y-auto">
    <div class="py-4">
        {{-- Dynamic container for Online friends or Search Filters based on page--}}
        {{ $upperContainer }}
        {{-- Static container for trending topics --}}
        <div id="trending-container" class=" overflow-y-auto">
            <div>
                <h4 class="text-xs sm:text-sm lg:text-base font-bold text-zinc-400 px-4 mb-2">What's Trending?</h4>
                <div class="flex flex-col justify-between hover:bg-lightMode-background hover:cursor-pointer px-4 py-2 border-b">
                    <span class="font-semibold">Sukkur</span>
                    <span class="text-sm">1028 searches</span>
                </div>
                <div class="flex flex-col justify-between hover:bg-lightMode-background hover:cursor-pointer px-4 py-2 border-b">
                    <span class="font-semibold">Quetta</span>
                    <span class="text-sm">809 searches</span>
                </div>
                <div class="flex flex-col justify-between hover:bg-lightMode-background hover:cursor-pointer px-4 py-2 border-b">
                    <span class="font-semibold">Pechawar</span>
                    <span class="text-sm">495 searches</span>
                </div>
                <div class="flex flex-col justify-between hover:bg-lightMode-background hover:cursor-pointer px-4 py-2 border-b">
                    <span class="font-semibold">Islamabad</span>
                    <span class="text-sm">216 searches</span>
                </div>
                <div class="flex flex-col justify-between hover:bg-lightMode-background hover:cursor-pointer px-4 py-2 border-b">
                    <span class="font-semibold">Lahore</span>
                    <span class="text-sm">85 searches</span>
                </div>
                <div class="hover:bg-lightMode-background hover:cursor-pointer px-4 py-1">
                    <a href="" class="w-full text-lightMode-blueHighlight "><span>see more</span></a>
                </div>
            </div>
        </div>
    </div>
</aside>
