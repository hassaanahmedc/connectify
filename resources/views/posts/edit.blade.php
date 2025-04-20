<!-- Edit Post Modal -->
<div class="fixed inset-0 z-50 overflow-y-auto"
     x-cloak
     x-show="{{ $showVariable }}"
     x-on:keydown.escape.window="{{ $showVariable }} = false"
     @close-modal.window="{{ $showVariable }} = false">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
         x-show="{{ $showVariable }}"
         x-on:click="{{ $showVariable }} = false"></div>

    <!-- Modal Container -->
    <div class="flex min-h-full items-center justify-center p-4 text-center"
         x-on:click.stop>
        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all w-full max-w-3xl"
             x-data="editPostModal({{ json_encode($postImages->map(function($img) {
                 return ['id' => $img->id, 'url' => asset('storage/' . $img->path)];
             })) }})">
            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold leading-6 text-gray-900">Edit Post</h3>
                    <button type="button"
                            class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none"
                            @click="closeModal()">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form id="postForm-edit-{{ $post->id }}"
                      action="{{ route('post.update', $post->id) }}"
                      @submit.prevent="submitForm"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="removed_images-{{ $post->id }}"
                           name="removed_images" value="[]">

                    <div class="space-y-4">
                        <!-- Post Content Textarea -->
                        <div>
                            <textarea class="w-full border-0 focus:ring-0 text-lg resize-none"
                                      id="content-edit-{{ $post->id }}"
                                      name="content"
                                      rows="4"
                                      placeholder="What's on your mind?">{{ $post->content ?? '' }}</textarea>
                        </div>

                        <!-- Image Upload and Preview Section -->
                        <div class="flex flex-col space-y-4">
                            <label for="image-upload-edit-{{ $post->id }}"
                                   class="flex items-center space-x-2 cursor-pointer hover:text-blue-600 transition-colors group p-2 rounded-lg hover:bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-6 w-6 text-blue-500 group-hover:text-blue-600 transition-colors"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-gray-700 font-medium group-hover:text-blue-600 transition-colors">Add Photos</span>
                                <input type="file"
                                       id="image-upload-edit-{{ $post->id }}"
                                       class="hidden"
                                       @change="addNewImages"
                                       multiple
                                       accept="image/*">
                            </label>

                            <!-- Image Previews -->
                            <div id="image-preview-edit-{{ $post->id }}"
                                 class="grid grid-cols-2 md:grid-cols-3 gap-3 mt-2">
                                <template x-for="image in [...existingImages, ...newImages]" :key="image.id || image.url">
                                    <div class="image-container relative group transform transition-transform hover:scale-[1.02] duration-200">
                                        <img :src="image.url" class="w-full aspect-square object-cover rounded-xl shadow-sm" alt="Post image">
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

                    <!-- Form Actions -->
                    <div class="mt-5 flex justify-end space-x-3">
                        <button type="button"
                                class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                                @click="closeModal()">
                            Cancel
                        </button>
                        <button type="submit"
                                class="rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                            Update Post
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Alpine.js Component Logic -->
<script>
    function editPostModal(initialImages) {
        return {
            // State
            existingImages: initialImages, // Array of {id, url} from backend
            newImages: [], // Array of {file, url, isNew} for new uploads
            removedImages: [], // Array of IDs to delete

            // Add New Images
            addNewImages(event) {
                const files = Array.from(event.target.files);
                files.forEach(file => {
                    const url = URL.createObjectURL(file);
                    this.newImages.push({ file, url, isNew: true });
                });
                event.target.value = ''; // Clear input for re-selection
            },

            // Remove Images (Existing or New)
            removeImage(image) {
                if (image.isNew) {
                    this.newImages = this.newImages.filter(img => img.url !== image.url);
                    URL.revokeObjectURL(image.url);
                } else {
                    this.removedImages.push(image.id);
                    this.existingImages = this.existingImages.filter(img => img.id !== image.id);
                }
            },

            // Submit Form
            submitForm(event) {
                event.preventDefault();
                // Update hidden input with removed image IDs
                document.getElementById('removed_images-{{ $post->id }}').value = JSON.stringify(this.removedImages);
                const form = document.getElementById('postForm-edit-{{ $post->id }}');
                const formData = new FormData(form);

                // Append new images to FormData
                this.newImages.forEach((image, index) => {
                    formData.append(`images[]`, image.file);
                });

                // Submit via fetch
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                }).then(response => {
                    if (response.ok) {
                        window.location.reload(); // Refresh page on success
                    } else {
                        console.error('Error updating post');
                    }
                });
            },

            closeModal() {
                console.log('Edit post modal: Closing modal');
                try {
                    // Clean up any new image ObjectURLs
                    this.newImages.forEach(image => {
                        if (image.url && typeof URL !== 'undefined') {
                            URL.revokeObjectURL(image.url);
                        }
                    });
                    
                    // Dispatch a window-level event that the parent component listens for
                    window.dispatchEvent(new CustomEvent('close-modal'));
                } catch (error) {
                    console.error('Edit post modal: Error closing modal', error);
                }
            }
        }
    }
</script>