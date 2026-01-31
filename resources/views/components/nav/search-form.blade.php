<form action="{{ route('search.results') }}" method="GET">
    {{-- Search Bar (Desktop) --}}
    <div class="relative hidden items-center md:flex md:min-w-80 lg:min-w-96">
        <input :disabled="searchOpen"
            class="w-full rounded-xl border-zinc-200 bg-lightMode-background text-sm focus:border-none"
            id="search-nav-desktop" name="q" placeholder="search" type="search"
            value="{{ request('q', '') }}">
        <button class="absolute right-0 ml-2 px-2" type="submit">
            <img alt="" class="h-5 w-5"
                src="{{ Vite::asset('/public/svg-icons/search.svg') }}"></button>
        <div class="absolute left-0 top-full mt-2 hidden w-full rounded-xl border-zinc-200 bg-white shadow-xl"
            id="search-results-desktop">
            <ul class="divide-grey-200 max-h-60 divide-y overflow-y-auto text-sm">
                {{-- Search results preview here (Desktop) --}}
            </ul>
        </div>
    </div>
    {{-- Search Icon (Mobile) --}}
    <div class="ml-auto md:hidden">
        <figure @click="searchOpen = !searchOpen" class="cursor-pointer">
            <img alt="" class="h-6 w-6" src="{{ Vite::asset('/public/svg-icons/search.svg') }}">
        </figure>
    </div>
    {{-- Search Bar (Mobile) --}}
    <div class="absolute left-0 top-0 z-50 flex w-full items-center bg-white p-2 md:hidden"
        x-show="searchOpen" x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter="transition ease-out duration-200"
        x-transition:leave-end="opacity-0 transform scale-95"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-200">
        <figure @click="searchOpen = false"
            class="flex min-h-[44px] min-w-[44px] cursor-pointer items-center justify-center p-2">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2" />
            </svg>
        </figure>
        <div class="relative mx-2 flex-1">
            <input :disabled="!searchOpen" @keydown.escape="searchOpen = false"
                class="w-full rounded-xl border-zinc-200 bg-lightMode-background text-sm focus:border-none"
                id="search-nav-mobile" name="q" placeholder="search" type="search"
                value="{{ request('q', '') }}">
            <button class="absolute right-2 top-1/2 -translate-y-1/2 transform" type="submit">
                <img alt="" class="h-auto w-8"
                    src="{{ Vite::asset('/public/svg-icons/search.svg') }}">
            </button>
            <div class="absolute left-0 top-full z-50 mt-2 hidden w-full rounded-lg border bg-white shadow-lg"
                id="search-results-mobile">
                <ul class="max-h-60 divide-y divide-gray-200 overflow-y-auto text-sm">
                    {{-- Search results preview here (Mobile) --}}
                </ul>
            </div>
        </div>
    </div>
</form>
