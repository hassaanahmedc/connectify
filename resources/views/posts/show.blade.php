@extends('layouts.main')

@section('main')
<section class="w-full">
    <div id="post-wrapper" class="mx-auto my-0 w-11/12 max-w-md min-w-80 md:w-11/12 lg:w-full lg:max-w-lg xl:max-w-xl py-4  ">
        <div id="post-container">
            @include('posts.feed-card', [
            'post' => $posts,
            'profileImageUrl' => !empty($post->user->avatar)
            ? $post->user->avatar
            : 'https://placewaifu.com/image/200',
            'profileUrl' => route('profile.view', $posts->user->id),
            'postId' => $posts->id,
            'userName' => $posts->user->fname . ' ' . $posts->user->lname,
            'postTime' => $posts->created_at->diffForHumans(),
            'postContent' => $posts->content,
            'postImages' => $posts->postImages,
            'comments' => $posts->limited_comments,
            'showFullContent' => true,
            'showComments' => true,
            ])
        </div>
    </div>
</section>
@endsection



