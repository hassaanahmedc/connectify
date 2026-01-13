<x-modal :show="false" focusable name="image-upload-preview"
    x-on:close-modal.window="$event.detail == 'image-upload-preview' ? show = false : null">

    <div class="p-6" x-data="{
        previewUrl: '',
        profileErrors: [],
        title: 'Upload Preview',
        previewClass: 'w-64 h-64',
        tryAgainId: '',
    
        handleTryAgain() {
            if (this.tryAgainId === 'try-again-button-profile') {
                document.getElementById('select-profile-picture').click();
    
            } else if (this.tryAgainId === 'try-again-button-cover') {
                document.getElementById('select-cover-picture').click();
            }
        }
    }"
        x-on:open-image-preview.window="
                previewUrl = $event.detail.previewUrl;
                profileErrors = $event.detail.profileErrors;
                title = $event.detail.title;
                previewClass = $event.detail.previewClass;
                tryAgainId = $event.detail.tryAgainId;
            ">

        <h2 class="text-center text-lg font-semibold text-gray-900 dark:text-gray-100" x-text="title"></h2>
        <div>
            <figure class="my-4 flex w-full justify-center" id="image-upload-preview-container"
                x-show="profileErrors.length === 0">

                <img :class="previewClass" :src="previewUrl" alt="profile picture"
                    class="aspect-square h-64 w-64 object-contain" id="image-upload-preview" x-show="previewUrl">

            </figure>
            <div class="text-center" id="error-container" x-cloak x-show="profileErrors.length > 0" x-transition>
                <div aria-live="assertive"
                    class="flex items-start gap-3 rounded-lg border border-red-200 bg-red-50 p-4 shadow-sm"
                    id="profile-error" role="alert">

                    <ul class="flex flex-col gap-1">
                        <template :key="error" x-for="error in profileErrors">
                            <li class="list-none text-sm font-medium leading-relaxed text-red-800" x-text="error">
                            </li>
                        </template>
                    </ul>
                </div>
                <button :id="tryAgainId"
                    class="my-4 w-full rounded-lg bg-lightMode-primary px-4 py-2 font-semibold text-white"
                    x-on:click="handleTryAgain()">
                    Select a Different File</button>
            </div>
            <!-- inside modal next to preview -->
            <div class="flex w-full flex-wrap gap-2 text-center text-sm sm:flex-nowrap md:text-base lg:text-base">

                <button class="w-full rounded-lg bg-gray-200 px-4 py-2 font-semibold text-black" type="button"
                    x-on:click="$dispatch('close')">Cancel</button>
                <button class="w-full rounded-lg bg-lightMode-primary px-4 py-2 font-semibold text-white"
                    id="save-upload-button" type="submit" x-show="profileErrors.length === 0">Save</button>
            </div>
        </div>
    </div>
</x-modal>
