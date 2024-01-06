<nav class="flex justify-between items-center px-20 py-2 bg-white">
    <div id="navSearch_logo"
        class="flex gap-20">
        <div>
            @include('components.application-logo')
        </div>
        <div class="relative">
            {{-- {{Search bar}} --}}
            <input type="search"
                class=" bg-lightMode-background rounded-xl border-zinc-200 w-80 min-w-full text-sm focus:border-none"
                name="search"
                id="search"
                placeholder="search"
                required>
            {{-- {{Search icon}} --}}
            <img src="{{ Vite::asset('/public/svg-icons/search.svg') }}"
                class="absolute left-72 top-2"
                alt="">
        </div>

    </div>
    <div id="nav_svgs"
        class="flex gap-2">
        <div>
            <a href=""><img class="min-w-8 h-fit"
                    src="{{ Vite::asset('/public/svg-icons/user-plus.svg') }}"
                    alt=""></a>
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
        <div class="flex">
            <a href=""><img class="w-8 h-auto"
                    src="{{ Vite::asset('/public/svg-icons/guest-icon.svg') }}"
                    alt=""></a>
            <a href=""><img class="w-5 h-auto"
                    src="{{ Vite::asset('/public/svg-icons/expand.svg') }}"
                    alt=""></a>

        </div>
    </div>
</nav>
