<div class="flex flex-col" id="newsfeed">
    @if ($posts->count())
        @foreach ($posts as $post)
            @php
                $profileImageUrl = !empty($post->user->avatar)
                    ? $post->user->avatar
                    : 'https://placewaifu.com/image/200';
            @endphp
            @include('posts.feed-card', [
                'profileUrl' => route('profile.view', $post->user->id),
                'postId' => $post->id,
                'userName' =>
                    $post->user->fname . ' ' . $post->user->lname,
                'postTime' => $post->created_at->diffForHumans(),
                'postContent' => $post->content,
                'postImages' => $post->postImages,
                'comments' => $post->limited_comments,
            ])
        @endforeach
    @endif
</div>
