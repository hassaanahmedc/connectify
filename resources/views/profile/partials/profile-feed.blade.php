<div class="w-full max-w-2xl px-4 md:w-1/2 md:px-0 lg:w-2/4">

    <section class="">

        <div class="w-full rounded-t-lg border-b-2 border-b-lightMode-primary bg-white py-2 text-center">
            <span class="text-lg font-semibold md:text-xl lg:text-xl">Posts</span>
        </div>

        <div class="pt-2" x-data="{ create_post: false }">
            <x-post-creation :user=$user />
        </div>

        <div class="flex flex-col" id="newsfeed">
            @if ($user->post->count())
                @foreach ($user->post as $post)
                    @include('posts.feed-card', [
                        'profileUrl' => route('profile.view', $post->user->id),
                        'profileImageUrl' => !empty($post->user->avatar)
                            ? asset('storage/' . $post->user->avatar)
                            : 'https://placewaifu.com/image/200',
                        'postId' => $post->id,
                        'userName' => $user->fname . ' ' . $user->lname,
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
</div>
