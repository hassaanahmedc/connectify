@extends('layouts.main')

@section('main')
<section class="mx-auto my-0 w-11/12 max-w-md min-w-80 md:w-11/12 lg:w-full lg:max-w-lg xl:max-w-xl py-4">
    <div class="bg-white px-4 py-2 rounded-xl mb-4">
        <div class="flex gap-4 md:gap-6">
            <div class="flex-shrink-0">
                <img src="https://placewaifu.com/image/200" class="bg-gray-200 w-9 h-auto rounded-full object-cover" alt="">
            </div>

            <div x-data="{ create_post: false }" 
                 x-on:close-modal.window="if ($event.detail.modal === 'create_post') create_post = false" 
                 class="flex-1">
                <div class="relative" @click="create_post = true">
                    <div class="rounded-full border px-4 py-2 text-gray-500 cursor-pointer">
                        Share something...
                    </div>
                </div>

                <!-- Post Creation Modal -->
                @include('posts.create', ['showVariable' => 'create_post'])

                <div class="hidden sm:flex justify-around md:flex-nowrap items-center gap-4 md:gap-8 mt-2">
                    <div @click="create_post = true" class="flex items-center gap-2 text-xs sm:text-sm lg:text-base font-semibold cursor-pointer hover:text-lightMode-primary transition-colors min-h-[44px]">
                        <img src="{{ Vite::asset('/public/svg-icons/photos.svg') }}" class="w-6 h-auto" alt=""> 
                        <span>Image</span>
                    </div>

                    <div @click="create_post = true" class="flex items-center gap-2 text-xs sm:text-sm lg:text-base font-semibold cursor-pointer hover:text-lightMode-primary transition-colors min-h-[44px]">
                        <img src="{{ Vite::asset('/public/svg-icons/videocam.svg') }}" class="w-6 h-auto" alt=""> 
                        <span>Video</span>
                    </div>

                    <div @click="create_post = true" class="flex items-center gap-2 text-xs sm:text-sm lg:text-base font-semibold cursor-pointer hover:text-lightMode-primary transition-colors min-h-[44px]">
                        <img src="{{ Vite::asset('/public/svg-icons/poll.svg') }}" class="w-6 h-auto" alt=""> 
                        <span>Poll</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('posts.index')
</section>
@endsection
