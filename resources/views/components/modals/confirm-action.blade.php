<x-modal :show="false" focusable name="confirm-action-modal">
    <div class="p-6" 
        x-data="{
            title: 'Are you sure?',
            message: 'This action cannot be undone once you proceed.',
            actionType: null,
            itemId: null,
            loading: false,
            confirmButtonText: 'Confirm',
            errorMessage: null,
        }"
        x-on:open-modal.window="
            if ($event.detail.name === 'confirm_action') {
                loading = false;
                errorMessage = null;
                show = true;
                title = $event.detail.title;
                message = $event.detail.message;
                actionType = $event.detail.actionType;
                itemId = $event.detail.itemId;
                confirmButtonText = $event.detail.confirmButtonText;
            }
        "
        x-on:action-failed.window="
            console.log($event.detail.itemId);
            if(String($event.detail.itemId) === String(itemId)) {
                loading = false;
                errorMessage = $event.detail.message;
            }
        "
    >
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100" x-text="title"></h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400" x-text="message"></p>

        {{-- Error Messages Displau --}}
        <div x-cloak x-show="errorMessage" x-transition class="mt-4">
            <ul class="list-disc list-inside text-sm font-semibold text-red-600 px-4 italic">
                <li x-text="errorMessage"></li>
            </ul>
        </div>

        {{-- Buttons Container --}}
        <div class="mt-6 flex justify-end gap-2">
            <x-secondary-button x-on:click="$dispatch('close')" x-show="!loading">
                {{ __('cancel') }}
            </x-secondary-button>
            <x-primary-button x-bind:disabled="loading"
                    x-on:click="loading = true;
                    errorMessage = null;
                    $dispatch('execute-confirmed-action', { actionType: actionType, itemId: itemId });
                    ">
                <span x-show="!loading" x-text="confirmButtonText"></span>
                <span x-cloak x-show="loading">Processing...</span>              
            </x-primary-button>
        </div>
        
    </div>
</x-modal>