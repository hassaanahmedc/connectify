@vite('resources/js/features/search/index.js', 'resources/js/components/notifications.js');

<div x-data="{ 
    searchOpen: false,                                         
    leftSidebarOpen: false,                                    
    rightSidebarOpen: false,
    notifications: [],
    open: false,
    error: '',
    isLoading: false,
    hasBeenFetched: false,
    storageBaseUrl: '{{ asset("storage") }}/',

    async fetchNotifications() {
        if (this.hasBeenFetched) return;
        this.isLoading = true;

        try {
            const response = await fetch('/notifications');
            if (!response) this.error = 'HTTP error! status: ${response.status}';

            const data = await response.json();
            this.notifications = data.notifications;
            this.hasBeenFetched = true;

            } catch (error) {
                this.error = 'Error fetching notifications.' ;

            } finally {
                this.isLoading = false;
            }
        } 
    }">
    <nav class="flex justify-between items-center w-full h-16 px-4 bg-white fixed top-0 z-50 sm:px-8 md:px-10">
        <section id="logoSection" class="flex items-center justify-between">
            {{-- Left Sidebar Toggle (Mobile) --}}
            <div class="md:hidden min-w-[44px] min-h-[44px] flex items-center justify-center text-base">
                <button @click="leftSidebarOpen = !leftSidebarOpen" id="notification-icon-mobile" 
                        class="p-2 rounded-full min-w-[44px] min-h-[44px] flex items-center justify-center">

                    <svg x-show="!leftSidebarOpen" xmlns="http://www.w3.org/2000/svg" 
                    class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>

                    <svg x-show="leftSidebarOpen" xmlns="http://www.w3.org/2000/svg" 
                    class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>

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
                <div class="flex items-center gap-4">
                    <x-nav.notification-list />
                    <a href="{{ route('profile.view', $navUser->id) }}">
                        <img class="profile-picture-display w-9 h-auto rounded-full"
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