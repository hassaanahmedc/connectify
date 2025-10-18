@php
    $limit = 3;
    $user_results = $results->where('type', 'user');
    $post_resutls = $results->where('type', 'post');
@endphp
@extends('layouts.main')

@section('main')
    <section class="mx-auto my-0 w-11/12 min-w-80 max-w-md py-4 md:w-11/12 lg:w-full lg:max-w-lg xl:max-w-xl">
        @if ($user_results->isNotEmpty())
            <div class="rounded-xl bg-white shadow-md" id="user-container">
                <div class="flex flex-col justify-center">
                    <h3 class="border-b px-3 py-2 text-lg font-semibold sm:px-5">People</h3>
                    @foreach ($user_results->take($limit) as $user)
                            @include('profile.user-card', [
                                'user' => $user,
                                'profileImageUrl' => !empty($user->user->avatar)
                                    ? $user->user->avatar
                                    : 'https://placewaifu.com/image/200',
                                'profileUrl' => $user->url,
                                'userName' => $user->fname . ' ' . $user->lname,
                                'userBio' => $user->bio,
                                'userLocation' => $user->location,
                            ])
                       
                    @endforeach
                    @if ($user_results->count() > $limit)
                        <span class="border-t px-3 py-2 hover:text-lightMode-blueHighlight sm:px-5"><a href="See all">View
                                more</a></span>
                    @endif
                </div>
            </div>
        @endif
        @if ($results && count($results))
            <div id="post-wrapper">
                @foreach ($results as $result)
                    @if ($result->type === 'post')
                        <div id="post-container">
                            @include('posts.feed-card', [
                                'post' => $result,
                                'profileImageUrl' => !empty($result->user->avatar)
                                    ? $result->user->avatar
                                    : 'https://placewaifu.com/image/200',
                                'profileUrl' => $result->url,
                                'postId' => $result->id,
                                'userName' => $result->user->fname . ' ' . $result->user->lname,
                                'postTime' => $result->created_at->diffForHumans(),
                                'postContent' => $result->content,
                                'postImages' => $result->postImages,
                                'comments' => $result->limited_comments,
                                'showFullContent' => false,
                                'showComments' => false,
                            ])
                        </div>
                    @endif
                @endforeach
            @else
                <span class="mx-auto my-10 text-lg font-semibold text-gray-500">No results found</span>
            </div>
        @endif
    </section>
@endsection

@section('append-data-to-rightSidebar')
    <x-right-sidebar-filters />
@endsection
