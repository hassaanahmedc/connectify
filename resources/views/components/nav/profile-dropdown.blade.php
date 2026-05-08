<x-dropdown contentClasses="bg-white" width="48">
    <x-slot name="trigger">
        <x-svg-icons.chevron-down class="w-5 h-auto cursor-pointer" />
    </x-slot>
    <x-slot name="content">
        <div class="w-48 flex flex-col absolute right-0 top-0 bg-white shadow-xl border 
            border-gray-100 rounded-xl z-10 p-1.5">
            @auth
                <x-dropdown-link :href="route('profile.edit')"  
                    class="w-full flex items-center gap-3 px-3 py-2 text-sm font-medium text-gray-700 
                        hover:bg-blue-50 rounded-lg transition-colors">
                    <x-svg-icons.pencil-square class="w-5 h-5 text-gray-500" />
                    {{ __('Edit Profile') }}
                </x-dropdown-link>

                <x-dropdown-link :href="route('profile.view', $user->id)" 
                    class="w-full flex items-center gap-3 px-3 py-2 text-sm font-medium text-gray-700 
                        hover:bg-blue-50 rounded-lg transition-colors">
                    <x-svg-icons.user-icon class="w-5 h-5 text-gray-500" />
                    {{ __(optional($user)->fname) }}
                </x-dropdown-link>

                <form action="{{ route('logout') }}" method="POST" >
                    @csrf
                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); 
                        this.closest('form').submit();" 
                            class="w-full flex items-center gap-3 px-3 py-2 text-sm font-medium text-red-600 
                                hover:bg-red-50 rounded-lg transition-colors">
                        <x-svg-icons.logout class="w-5 h-5 text-red-500" />
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            @endauth

            @guest
                <x-dropdown-link :href="route('login')"
                    class="w-full flex items-center gap-3 px-3 py-2 text-sm font-medium text-gray-700 
                            hover:bg-blue-50 rounded-lg transition-colors">
                    {{ __('Log in') }}
                </x-dropdown-link>
            @endguest

    </div>
    </x-slot>
</x-dropdown>
