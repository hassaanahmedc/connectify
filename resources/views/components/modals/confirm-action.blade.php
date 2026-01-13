<x-modal :show="false" focusable name="confirm-action-modal">
    <div class="p-6" x-data="{
        title: 'Are you sure?',
        message: 'This action cannot be undone once you proceed.',
        actionType: null,
        itemId: null,
        confirmButtonText: 'Confirm',
    }"
        x-on:open-modal.window="
            if ($event.detail.name === 'confirm_action') {
                console.log('modal triggered');
                show = true;
                title = $event.detail.title;
                message = $event.detail.message;
                actionType = $event.detail.actionType;
                itemId = $event.detail.itemId;
                confirmButtonText = $event.detail.confirmButtonText;
            }
    ">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100" x-text="title"></h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400" x-text="message"></p>

        <div class="mt-6 flex justify-end gap-2">

            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('cancel') }}
            </x-secondary-button>
            <x-primary-button id="confirm-delete"
                x-on:click="
                    $dispatch('execute-confirmed-action', { actionType: actionType, itemId: itemId });
                    $dispatch('close');"
                x-text="confirmButtonText">                
            </x-primary-button>
        </div>
        
    </div>
</x-modal>