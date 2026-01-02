@props(['type' => 'success'])

<div 
    x-data="{ notificationShow: false, notificationMessage: '', notificationType: '{{ $type }}' }"
    x-on:show-notification.window="
        notificationMessage = $event.detail.message;
        notificationType = $event.detail.type || 'success';
        notificationShow = true;
        setTimeout(() => notificationShow = false, 5000);"

    x-transition:enter="transform ease-out duration-300 transition"
    x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
    x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    x-show="notificationShow"
    x-cloak
    :class="{
      'bg-green-600': notificationType === 'success',
      'bg-red-600': notificationType === 'error',
      'bg-blue-500': notificationType === 'info'
    }"
    class="fixed top-20 right-5 w-full max-w-xs rounded-lg shadow-lg text-white z-50">
    
 <p class="text-sm px-2 py-4 font-medium" x-text="notificationMessage"></p>
</div>