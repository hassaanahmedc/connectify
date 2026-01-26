<div class="mb-2 rounded-xl bg-white px-4 py-2 shadow-sm">
    <div class="flex gap-4 md:gap-6">
        <div class="flex-shrink-0">
            <img alt="" class="h-auto w-9 rounded-full bg-gray-200 object-cover"
                src="{{  asset('storage/' . Auth::user()->avatar ) ??  Vite::asset('/public/svg-icons/guest-icon.svg') }}">
        </div>

        <div class="flex-1" x-data="{ create_post: false }"
            x-on:close-modal.window="if ($event.detail.modal === 'create_post') create_post = false">
            <div @click="create_post = true">
                <div class="cursor-pointer rounded-full border px-4 py-2 text-gray-500">
                    Share something...
                </div>
            </div>

            <!-- Post Creation Modal -->
            @include('posts.create', ['showVariable' => 'create_post'])

        </div>
    </div>
</div>
