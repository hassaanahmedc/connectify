<div class="fixed left-0 top-0 flex h-screen w-screen items-center justify-center bg-black/80" x-cloak
    x-show="editProfileModal">

    <section class="relative mx-4 w-1/4 min-w-[350px] max-w-screen-md rounded-lg bg-white px-8 py-5">
        <h2 class="mb-8 text-center text-xl font-bold">Upload Profile Picture</h2>

        <!-- Close button -->
        <svg @click="editProfileModal=false" class="absolute right-4 top-8 cursor-pointer" height="32"
            viewBox="0 0 512 512" width="32">
            <polygon
                points="400 145.49 366.51 112 256 222.51 145.49 112 112 145.49 222.51 256 112 366.51 145.49 400 256 289.49 366.51 400 400 366.51 289.49 256 400 145.49" />
        </svg>
        <div>
            <figure class="my-4 w-full rounded-full">
                <img :src="previewUrl" alt="profile picture" class="mb-1 max-h-[300px] w-full rounded-full"
                    id="upload-profile-preview" x-show="previewUrl && !errors">
                <div aria-live="assertive" class="mb-3 text-sm text-red-500" id="profile-error" role="alert"
                    x-text="errors"></div>
            </figure>
            <!-- inside modal next to preview -->
            <div class="flex w-full flex-wrap gap-2 text-center text-sm sm:flex-nowrap md:text-base lg:text-base">
                <button @click="editProfileModal=false"
                    class="w-full rounded-lg bg-gray-200 px-4 py-2 font-semibold text-black"
                    type="button">Cancel</button>
                <button :class="errors ? 'opacity-50 cursor-not-allowed' : ''" :disabled="errors.length > 0"
                    class="w-full rounded-lg bg-lightMode-primary px-4 py-2 font-semibold text-white"
                    id="save-profile-picture" type="submit">Save</button>
            </div>
        </div>

    </section>
</div>
