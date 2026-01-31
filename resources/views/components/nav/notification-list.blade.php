{{-- 
    This file is an instance of <x-notification-dropdown /> acts as a self contained 
    dropdown for notificationss toggled via x-data 'open' variable from outide.

    It has fetchNotifications() funciton defined on tpggle for making API call to 
    fetch notifications.

 --}}
 
<x-notification-dropdown>
    <x-slot name="trigger">
        <div @click="open = !open; fetchNotifications()">
            <img alt="Notifications" class="notification-icon h-auto w-8"
                src="{{ Vite::asset('/public/svg-icons/notification.svg') }}">
        </div>
    </x-slot>
    <x-slot name="content">
        <div class="py-2">
            <h5 class="px-4 pb-2 text-lg font-bold">Notifications</h5>
            <div class="divide-y divide-gray-100" id="notification-container-mobile">
                <template x-if="isLoading">
                    <div class="p-4 text-center text-gray-500">Loading...</div>
                </template>
                <template :key="notification.id" x-for="notification in notifications">
                    <a :href="notification.data.link"
                        class="block p-3 transition duration-150 ease-in-out hover:bg-gray-50">
                        <div class="flex items-start gap-3 text-sm">
                            <img :src="storageBaseUrl + notification.data.user_avatar" alt=""
                                class="h-12 w-12 shrink-0 rounded-full object-cover shadow-sm">
                            <div class="flex-1 pt-0.5">
                                <p class="leading-snug text-gray-800">
                                    <strong class="font-bold text-black" x-text="notification.data.user_name"></strong>
                                    <span x-text="notification.data.message"></span>
                                </p>
                                <span class="mt-1 block text-xs font-medium text-blue-600">2m
                                    ago</span>
                            </div>
                        </div>
                    </a>
                </template>
                <template x-if="error">
                    <div class="p-4 text-center text-red-500" x-text="error"></div>
                </template>
            </div>
        </div>
    </x-slot>
</x-notification-dropdown>
