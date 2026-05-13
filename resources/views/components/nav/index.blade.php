<div x-data="notifications">
    <nav class="flex justify-between items-center w-full h-16 px-4 bg-white fixed top-0 z-50 sm:px-8 md:px-10">
        <section id="logoSection" class="flex items-center justify-between gap-2">
            {{-- Left Sidebar Toggle (Mobile) --}}
            <div class="md:hidden flex justify-center items-center">
                <button id="notification-icon-mobile" @click="leftSidebarOpen = !leftSidebarOpen">
                    <x-svg-icons.hamburger-menu class="w-6 h-6" x-show="!leftSidebarOpen" />
                    <x-svg-icons.cross-mark class="w-6 h-6" x-show="leftSidebarOpen" />
                </button>
            </div>
            {{-- Logo --}}
            <x-application-logo />            
        </section>

        <section id="searchSection">
            {{-- Search Bar (Desktop) --}}
            <x-nav.search-form />
        </section>

        <section id="iconSection">
            <div class="flex">
                <div class="flex items-center gap-5">
                    <x-nav.notification-list />
                    <a href="{{ route('profile.view', $navUser->id) }}">
                        <img class="profile-picture-display w-9 h-9 rounded-full"
                            src="{{ $navUser->avatar_url }}"
                            alt="">
                    </a>
                </div>
                <x-nav.profile-dropdown :user="$navUser" />
            </div>
        </section>
    </nav>

    {{-- Left Sidebar for Mobile (Moved from welcome.blade.php) --}}
    <x-nav.mobile-sidebar />
</div>