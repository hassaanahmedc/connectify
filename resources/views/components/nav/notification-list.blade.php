{{-- 
    This file is an instance of <x-notification-dropdown /> acts as a self contained 
    dropdown for notificationss toggled via x-data 'open' variable from outide.

    It has fetchNotifications() funciton defined on tpggle for making API call to 
    fetch notifications.

 --}}
 
<x-notification-dropdown>
    <x-slot name="trigger">
        <div @click="open = !open; fetchNotifications()">
            <x-svg-icons.bell class="notification-icon relative h-auto w-8" />
            <span class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full bg-red-500" 
                x-show="unreadCount > 0"
                x-transition.opacity.scale.75 ></span>
        </div>
    </x-slot>
    <x-slot name="content">
        <div class="mx-2 py-2">
            <div class="flex justify-between items-center">
                <h5 class="px-4 pb-2 text-lg font-bold">Notifications</h5>
                <span class="px-4 pb-2 font-semibold text-lightMode-primary cursor-pointer hover:underline"
                        x-show="notifications.length > 0"
                        :class="unreadCount === 0 ? 'opacity-40 pointer-events-none' : ''"
                        @click="markAllAsRead()">Mark as read</span>
            </div>
            <div class="divide-y divide-gray-100" id="notification-container-mobile">
                <template x-if="isLoading">
                    <x-svg-icons.loading class="w-5 h-auto p-5" />
                </template>
                <template :key="notification.id" x-for="notification in notifications">
                    <a :href="notification.data.link"
                        :class="notification.read_at ? 'opacity-70' : 'bg-blue-50'"
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
                <template x-if="!isLoading && notifications.length == 0">
                    <div class="flex flex-col justify-center items-center py-12 px-4 text-center">
                        <div class="bg-gray-100 p-2 rounded-full mb-4">
                            <x-svg-icons.bell class="w-8 h-auto" />
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900 ">No notifications yet.</h3>
                        <p class="text-xs text-gray-500">When you get notifications, they'll show up here.</p>
                    </div>
                </template>
            </div>
        </div>
    </x-slot>
</x-notification-dropdown>
