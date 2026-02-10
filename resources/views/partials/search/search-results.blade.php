@php
    $limit = 3;
    $user_results = $results->where('type', 'user');
    $post_results = $results->where('type', 'post');
@endphp
<div class="max-w-3xl mx-auto space-y-10 pb-10" >

    {{-- People Section --}}
    @if ($user_results->isNotEmpty())
        <section aria-labelledby="people-heading" >
            <div class="flex items-center justify-between bg-white mt-6 px-6 py-4 rounded-t-xl text-sm 
                        font-bold uppercase tracking-widest text-gray-500 border-x border-t shadow-md">
                <h3 id="people-heading" class="">People</h3>
                @if ($user_results->count() > $limit)
                    <a href="#" class="text-xs font-bold text-lightMode-primary hover:underline">View All</a>
                @endif
            </div>

            <div class="overflow-hidden border border-gray-100 shadow-md bg-white">
                @foreach ($user_results->take($limit) as $user)
                    @include('profile.user-card', [
                       'user' => $user,
                       'profileImageUrl' => $user->avatar_url,
                       'profileUrl' => route('profile.view', $user->id),
                       'userName' => $user->fname . ' ' . $user->lname,
                       'userBio' => $user->bio,
                       'userLocation' => $user->location,
                    ])
                @endforeach
            </div>
        </section>
    @endif

    {{-- Posts Section --}}
    @if ($post_results->isNotEmpty())
        <section aria-labelledby="posts-heading">
            <h3 id="posts-heading" class="bg-white mt-6 px-6 py-4 rounded-t-xl text-sm 
                        font-bold uppercase tracking-widest text-gray-500 border-x border-t shadow-md">Posts</h3>
            
            <div id="post-wrapper" class="flex flex-col gap-y-1">
                @foreach ($post_results as $post)
                    <article class="w-full">
                        @include('posts.feed-card', [
                            'post' => $post,
                            'profileImageUrl' => $post->user->avatar_url,
                            'profileUrl' => $post->url,
                            'postId' => $post->id,
                            'userName' => $post->user->fname . ' ' . $post->user->lname,
                            'postTime' => $post->created_at->diffForHumans(),
                            'postContent' => $post->content,
                            'postImages' => $post->postImages,
                            'comments' => $post->limited_comments,
                            'showFullContent' => false,
                            'showComments' => false,
                            'isLiked' => $post->isLiked ?? false,
                        ])
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Empty State --}}
    @if($user_results->isEmpty() && $post_results->isEmpty())
        <div class="flex flex-col items-center justify-center rounded-3xl border-2 border-dashed 
                border-gray-200 bg-white p-16 text-center">
            <div class="mb-4 rounded-full bg-gray-50 p-4">
                <x-svg-icons.search class="h-8 w-8 text-gray-400" />
            </div>
            <h3 class="text-lg font-bold text-gray-900">No results found</h3>
            <p class="mt-1 text-sm text-gray-500">Try adjusting your keywords or filters to find what you're looking for.</p>
        </div>
    @endif

</div>