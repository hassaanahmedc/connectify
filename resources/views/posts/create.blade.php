<!-- resources/views/post/create.blade.php -->
<div class="fixed inset-0 z-50 overflow-y-auto"
     x-cloak
     x-show="{{ $showVariable }}"
     x-on:keydown.escape.window="{{ $showVariable }} = false">

    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
         x-show="{{ $showVariable }}"
         x-on:click="{{ $showVariable }} = false"></div>

    <!-- Modal Container -->
    <div class="flex min-h-full items-center justify-center p-4 text-center"
         x-on:click.stop>
        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all w-full max-w-3xl"
             x-data="createPostModal">
            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold leading-6 text-gray-900" id="createPostModalLabel">
                        Create Post
                    </h3>
                    <button type="button"
                            class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none"
                            @click="{{ $showVariable }} = false">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <div>
                        <textarea class="w-full border-0 focus:ring-0 text-lg resize-none"
                                  id="content-create"
                                  x-model="content"
                                  rows="4"
                                  placeholder="What's on your mind?"></textarea>
                    </div>
                    <div class="flex flex-col space-y-4">
                        <label for="image-upload-create"
                               class="flex items-center space-x-2 cursor-pointer hover:text-blue-600 transition-colors group p-2 rounded-lg hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6 text-blue-500 group-hover:text-blue-600 transition-colors"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-gray-700 font-medium group-hover:text-blue-600 transition-colors">Add Photos</span>
                            <input type="file"
                                   id="image-upload-create"
                                   class="hidden"
                                   @change="addImages"
                                   multiple
                                   accept="image/*">
                        </label>
                        <div id="image-preview-create"
                             class="grid grid-cols-2 md:grid-cols-3 gap-3 mt-2">
                            <template x-for="image in images" :key="image.url">
                                <div class="image-container relative group transform transition-transform hover:scale-[1.02] duration-200">
                                    <img :src="image.url"
                                         class="w-full aspect-square object-cover rounded-xl shadow-sm"
                                         alt="Post image">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-200 rounded-xl flex items-center justify-center">
                                        <button type="button"
                                                @click="removeImage(image)"
                                                class="remove-image opacity-0 group-hover:opacity-100 transition-opacity duration-200 bg-red-500 hover:bg-red-600 text-white rounded-full p-1.5 z-10 transform hover:scale-110">
                                            <svg class="h-5 w-5 pointer-events-none" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                      d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 0 010-1.414z"
                                                      clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="mt-5 flex justify-end space-x-3">
                    <button type="button"
                            class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                            @click="{{ $showVariable }} = false">
                        Cancel
                    </button>
                    <button type="button"
                            x-bind:disabled="isSubmitting"
                            @click="submit()"
                            class="rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600"
                            :class="{ 'opacity-50 cursor-not-allowed': isSubmitting }">
                        <span x-show="!isSubmitting">Post</span>
                        <span x-show="isSubmitting">Posting...</span>
                    </button>
                </div>
                <div x-text="error" class="text-red-500 mt-2"></div>
            </div>
        </div>
    </div>
</div>

@vite(['resources/js/app.js'])

<script>
document.addEventListener('alpine:init', () => {
    console.log('Create post modal: Initializing createPostModal');
    Alpine.data('createPostModal', () => ({
        content: '',
        images: [], // Array of {file, url}
        error: '',
        isSubmitting: false,

        addImages(event) {
            console.log('Create post modal: Adding images');
            try {
                const files = Array.from(event.target.files);
                files.forEach(file => {
                    if (!file.type.startsWith('image/')) return;
                    const url = URL.createObjectURL(file);
                    this.images.push({ file, url });
                });
                event.target.value = ''; // Clear input
            } catch (error) {
                console.error('Create post modal: Error adding images', error);
            }
        },

        removeImage(image) {
            console.log('Create post modal: Removing image', image);
            try {
                this.images = this.images.filter(img => img.url !== image.url);
                URL.revokeObjectURL(image.url);
            } catch (error) {
                console.error('Create post modal: Error removing image', error);
            }
        },

        closeModal() {
            console.log('Create post modal: Closing modal');
            try {
                this.images.forEach(image => URL.revokeObjectURL(image.url));
                this.images = [];
                this.content = '';
                this.error = '';
                this.isSubmitting = false;
                this.$dispatch('close-create-modal');
            } catch (error) {
                console.error('Create post modal: Error closing modal', error);
            }
        },

        async submit() {
            console.log('Create post modal: Submitting form');
            if (!this.content && this.images.length === 0) {
                this.error = 'Please add content or images';
                return;
            }
            if (this.isSubmitting) return;
            this.isSubmitting = true;
            this.error = '';

            const formData = new FormData();
            formData.append('content', this.content);
            this.images.forEach((image, i) => {
                console.log(`Image ${i}:`, {
                    name: image.file.name,
                    type: image.file.type,
                    size: image.file.size
                    });
                formData.append(`images[${i}]`, image.file);
            });
            try {
                const response = await fetch('/post/store', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                });
                const text = await response.text();
                console.log('Raw response:', text);
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}, Response: ${text}`);
                }
                const data = JSON.parse(text);
                const newsfeed = document.querySelector('#newsfeed');
                const newCard = document.createElement('div');
                newCard.innerHTML = data.postHtml;
                newsfeed.prepend(newCard.firstChild);
                this.closeModal();
            } catch (error) {
                this.error = error.message || 'Failed to create post';
                console.error('Submit error:', error);
            } finally {
                this.isSubmitting = false;
            }
        },
    }));
});
</script>