<nav
    class="flex justify-between items-center px-20 py-2 bg-white sticky top-0 w-full z-50">
    <section id="searchSection"
        class="flex items-center justify-between gap-16 w-2/5">
        <div>
            @include('components.application-logo')
        </div>
        <div class="relative min-w-[250px] flex items-center justify-end w-full">
            <input type="search"
                class="bg-lightMode-background rounded-xl border-zinc-200 w-full text-sm focus:border-none"
                name="search"
                id="search"
                placeholder="search"
                required>
            <a href=""
                class="ml-2 px-2 absolute"><img
                    src="{{ Vite::asset('/public/svg-icons/search.svg') }}"
                    alt=""></a>
        </div>


    </section>
    <section id="iconSection"
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

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')"
                        class="dark:text-black dark:hover:bg-lightMode-background">
                        {{ __('Profile') }}
                    </x-dropdown-link>
                    @auth
                        <x-dropdown-link :href="route('profile.edit')"
                            class="dark:text-black dark:hover:bg-lightMode-background">
                            {{ __(optional(Auth::user())->fname) }}
                        </x-dropdown-link>
                    @endauth


                    <!-- Authentication -->
                    @auth
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
