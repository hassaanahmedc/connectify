@extends('layouts.main')

@section('main')
    <section class="w-full">
        <div class="mx-auto my-0 w-11/12 min-w-80 max-w-md py-4 md:w-11/12 lg:w-full lg:max-w-lg xl:max-w-xl"
            id="post-wrapper">
            <div id="post-container">
                @if ($results && count($results))
                    @foreach ($results as $result)
                        @if ($result->type === 'post')
                            @include('posts.feed-card', [
                                'post' => $result,
                                'profileImageUrl' => !empty($result->user->avatar)
                                    ? $result->user->avatar
                                    : 'https://placewaifu.com/image/200',
                                'profileUrl' => route('profile.view', $result->user->id),
                                'postId' => $result->id,
                                'userName' => $result->user->fname . ' ' . $result->user->lname,
                                'postTime' => $result->created_at->diffForHumans(),
                                'postContent' => $result->content,
                                'postImages' => $result->postImages,
                                'comments' => $result->limited_comments,
                                'showFullContent' => false,
                                'showComments' => false,
                            ])
                        @endif
                    @endforeach
                    @else
                        <span class="mx-auto my-10 text-lg font-semibold text-gray-500">No Posts</span>
                @endif
            </div>

        </div>
    </section>
@endsection

@section('append-data-to-rightSidebar')
    <x-right-sidebar-filters />
@endsection
