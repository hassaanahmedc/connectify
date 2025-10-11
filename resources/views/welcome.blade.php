@extends('layouts.main')

@section('main')
    <section class="mx-auto my-0 w-11/12 min-w-80 max-w-md py-4 md:w-11/12 lg:w-full lg:max-w-lg xl:max-w-xl">
        <div class="mb-4 rounded-xl bg-white px-4 py-2">
            <div class="flex gap-4 md:gap-6">
                <div class="flex-shrink-0">
                    <img alt="" class="h-auto w-9 rounded-full bg-gray-200 object-cover"
                        src="https://placewaifu.com/image/200">
                </div>

                <div class="flex-1" x-data="{ create_post: false }"
                    x-on:close-modal.window="if ($event.detail.modal === 'create_post') create_post = false">
                    <div @click="create_post = true" class="relative">
                        <div class="cursor-pointer rounded-full border px-4 py-2 text-gray-500">
                            Share something...
                        </div>
                    </div>

                    <!-- Post Creation Modal -->
                    @include('posts.create', ['showVariable' => 'create_post'])

                    <div class="mt-2 hidden items-center justify-around gap-4 sm:flex md:flex-nowrap md:gap-8">
                        <div @click="create_post = true"
                            class="flex min-h-[44px] cursor-pointer items-center gap-2 text-xs font-semibold transition-colors hover:text-lightMode-primary sm:text-sm lg:text-base">
                            <img alt="" class="h-auto w-6" src="{{ Vite::asset('/public/svg-icons/photos.svg') }}">
                            <span>Image</span>
                        </div>

                        <div @click="create_post = true"
                            class="flex min-h-[44px] cursor-pointer items-center gap-2 text-xs font-semibold transition-colors hover:text-lightMode-primary sm:text-sm lg:text-base">
                            <img alt="" class="h-auto w-6"
                                src="{{ Vite::asset('/public/svg-icons/videocam.svg') }}">
                            <span>Video</span>
                        </div>

                        <div @click="create_post = true"
                            class="flex min-h-[44px] cursor-pointer items-center gap-2 text-xs font-semibold transition-colors hover:text-lightMode-primary sm:text-sm lg:text-base">
                            <img alt="" class="h-auto w-6" src="{{ Vite::asset('/public/svg-icons/poll.svg') }}">
                            <span>Poll</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col" id="newsfeed">
            @if ($posts->count())
                @foreach ($posts as $post)
                    @php
                        $profileImageUrl = !empty($post->user->avatar)
                            ? $post->user->avatar
                            : 'https://placewaifu.com/image/200';
                    @endphp
                    @include('posts.feed-card', [
                        'showComments' => false,
                        'profileUrl' => route('profile.view', $post->user->id),
                        'postId' => $post->id,
                        'userName' => $post->user->fname . ' ' . $post->user->lname,
                        'postTime' => $post->created_at->diffForHumans(),
                        'postContent' => $post->content,
                        'postImages' => $post->postImages,
                        'comments' => $post->limited_comments,
                    ])
                @endforeach
            @else
                <span class="mx-auto my-10 text-lg font-semibold text-gray-500">No Posts</span>
            @endif
        </div>

    </section>
@endsection
