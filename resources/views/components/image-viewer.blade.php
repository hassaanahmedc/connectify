<div x-data="{
    imageShow: false,
    currentImageUrl: '',
    init() {
        this.$watch('imageShow', value => {
            if (value) {
                document.body.classList.add('overflow-y-hidden');
            } else {
                document.body.classList.remove('overflow-y-hidden');
            }
        });
    }
}" x-on:keydown.escape.window="imageShow = false"
    x-on:open-image-viewer.window="
        currentImageUrl = $event.detail.currentImageUrl;
        console.log('inside the image-viewer', currentImageUrl)
        imageShow = true;">
    <template x-if="imageShow">
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75"
            x-on:click.self="imageShow = false" x-transition>

            <img :src="currentImageUrl" alt="" class="max-h-full max-w-full">
            <button class="absolute right-0 top-0 m-4 text-3xl text-white"
                x-on:click="imageShow = false">&times;</button>
        </div>
    </template>

</div>
