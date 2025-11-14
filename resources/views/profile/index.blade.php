{{-- @dd($user) --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="{{ csrf_token() }}" name="csrf-token">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Roboto&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/components/follow.js'])
</head>

<body class="light bg-lightMode-background">
    <header>
        <x-custom-nav />
    </header>

    <div class="mx-auto my-0">

        <div class="flex h-[calc(100vh-4rem)] flex-col">
            <header class="relative max-h-96 w-screen min-w-96 opacity-85">
                <img alt="" class="h-full w-full object-cover"
                    src="{{ Vite::asset('/public/images/user/post/post.jpg') }}">
                <div class="absolute bottom-0 left-0 h-24 w-full bg-gradient-to-b from-transparent to-white"></div>
            </header>

            <div class="wrapper flex flex-col items-center">
                <div class="container w-11/12 min-w-80 max-w-lg -mt-20 flex flex-col justify-between gap-5 relative z-20"
                    id="user-profile-card">

                    <section class="flex flex-col items-center justify-center rounded-lg bg-white px-5 py-4 shadow-md"
                        x-data="{ edit_profile: false, edit_bio: false, create_post: false }">


                        <figure class="w-36 rounded-full">
                            <img alt="" class="aspect-square h-full w-full rounded-full object-cover"
                                src="https://placewaifu.com/image/200">
                        </figure>

                        <div class="text-center">
                            <h1 class="my-3 text-xl font-semibold">
                                {{ $user->fname }}
                                {{ $user->lname }}</h1>
                            <span class="text-sm text-lightMode-text">{{ $user->bio }}</span><br>
                            <div class="my-3 text-lightMode-text">
                                <span class="">From <span
                                        class="font-semibold">{{ $user->location }}</span></span>
                            </div>
                        </div>

                        <div class="my-2 flex gap-2 text-sm sm:text-base">
                            @auth
                                @if ($user->id === Auth::id())
                                    <a
                                        class="flex items-center gap-2 rounded-lg bg-lightMode-primary px-4 py-2 font-semibold text-white">
                                        420 Followers
                                    </a>
                                    <button
                                        class="flex items-center gap-2 rounded-lg bg-gray-200 px-4 py-2 font-semibold text-black"
                                        x-on:click="edit_profile=true">
                                        Edit Profile
                                    </button>
                                @else
                                    <span id="follower-count">{{ $user->followers_count }}</span>
                                    <button
                                        class="flex cursor-pointer items-center gap-2 rounded bg-lightMode-primary px-4 py-2 font-semibold text-white"
                                        type="button">
                                        <span data-user-id="{{ $user->id }}"
                                            id="follow-btn">{{ $user->followed ? 'Unfollow' : 'Follow' }}</span>

                                    </button>

                                    <a class="flex items-center gap-2 rounded bg-gray-200 px-4 py-2 font-semibold text-black transition-all hover:bg-gray-300"
                                        href="{{ route('profile.edit') }}">
                                        Message
                                    </a>
                                @endif

                            @endauth
                            @include('profile.edit-profile-modal')
                        </div>
                    </section>

                    <section class="rounded-lg bg-white px-5 py-4 shadow-md">
                        <h6 class="text-lg font-semibold">Interests</h6>
                        <ul class="mt-4 flex flex-wrap items-center gap-2 text-sm">
                            <li class="rounded-full border border-gray-400 px-3 py-1.5 shadow-sm">Gaming</li>
                            <li class="rounded-full border border-gray-400 px-3 py-1.5 shadow-sm">Coding</li>
                            <li class="rounded-full border border-gray-400 px-3 py-1.5 shadow-sm">Anime</li>
                            <li class="rounded-full border border-gray-400 px-3 py-1.5 shadow-sm">Video Editting</li>
                            <li class="rounded-full border border-gray-400 px-3 py-1.5 shadow-sm">Music Desgin</li>
                            <li class="rounded-full border border-gray-400 px-3 py-1.5 shadow-sm">Software Engineer</li>
                        </ul>
                    </section>

                    <section class="rounded-lg bg-white px-5 py-4 shadow-md">
                        <h6 class="text-lg font-semibold">About {{ $user->fname }}</h6>
                        <ul class="my-4 text-sm">
                            <li>Occupation <span class="font-semibold">Software Engineer</span></li>
                            <li>From <span class="font-semibold">{{ $user->location }}</span></li>
                            <li>Joined <span class="font-semibold">September 2025</span></li>
                        </ul>
                        <div>
                            <span class="font-bold"> 101 <span class="text-sm font-normal">Followers</span> </span>
                            <span class="font-bold"> 254 <span class="text-sm font-normal">Following</span> </span>
                        </div>
                    </section>

                </div>

                <div class="container w-11/12 max-w-lg mt-6 relative z-10" id="user-profile-data">
                    <section class="">
                    <div class="w-full bg-white border-b-2 border-b-lightMode-primary text-center py-2 rounded-t-lg">
                        <span class="font-semibold">Posts</span>
                    </div>
                    <div class="pt-2">
                        <x-post-creation />
                    </div>
                        <div class="flex flex-col" id="newsfeed">
                            @if ($user->post->count())
                                @foreach ($user->post as $post)
                                    @php
                                        $profileImageUrl = !empty($user->avatar)
                                            ? $user->avatar
                                            : 'https://placewaifu.com/image/200';
                                    @endphp
                                    @include('posts.feed-card', [
                                        'profileUrl' => route('profile.view', $post->user->id),
                                        'postId' => $post->id,
                                        'userName' => $user->fname . ' ' . $user->lname,
                                        'postTime' => $post->created_at->diffForHumans(),
                                        'postContent' => $post->content,
                                        'postImages' => $post->postImages,
                                        'comments' => $post->limited_comments,
                                    ])
                                @endforeach
                            @endif
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.threeDotsSvg = "{{ Vite::asset('public/svg-icons/3dots.svg') }}";
    </script>
</body>

</html>
