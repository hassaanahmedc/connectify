@extends('layouts.main')

@section('main')
    <section class="mx-auto my-0 w-11/12 min-w-80 max-w-md md:w-11/12 lg:w-full lg:max-w-lg lg:px-5 xl:px-0 xl:max-w-xl">
        <div class="mb-2 rounded-xl bg-white px-4 py-2 shadow-sm">
            <div class="flex gap-4 md:gap-6">
                <div class="flex-shrink-0">
                    <img alt="" class="h-auto w-9 rounded-full bg-gray-200 object-cover"
                        src="{{  asset('storage/' . Auth::user()->avatar ) ??  Vite::asset('/public/svg-icons/guest-icon.svg') }}">
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

                </div>
            </div>
        </div>

        <div class="flex flex-col" id="newsfeed">
            @if ($posts->count())
                @foreach ($posts as $post)
                    @include('posts.feed-card', [
                        'showComments' => false,
                        'profileUrl' => route('profile.view', $post->user->id),
                        'profileImageUrl' => !empty($post->user->avatar)
                            ? asset('storage/' . $post->user->avatar)
                            : 'https://placewaifu.com/image/200',
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
