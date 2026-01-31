<x-dropdown contentClasses="bg-white" width="48">
    <x-slot name="trigger">
        <img alt="" class="h-auto w-5" src="{{ Vite::asset('/public/svg-icons/expand.svg') }}">
    </x-slot>
    <x-slot name="content">
        @auth
            <x-dropdown-link :href="route('profile.edit')">
                {{ __('Edit Profile') }}
            </x-dropdown-link>

            <x-dropdown-link :href="route('profile.view', $user->id)">
                {{ __(optional($user)->fname) }}
            </x-dropdown-link>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); 
                    this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-dropdown-link>
            </form>
        @endauth

        @guest
            <x-dropdown-link :href="route('login')">
                {{ __('Log in') }}
            </x-dropdown-link>
        @endguest
    </x-slot>
</x-dropdown>
