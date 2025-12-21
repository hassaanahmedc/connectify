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
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/components/follow.js', 'resources/js/features/profile/profileImages.js', 'resources/js/components/locations.js'])
</head>

<body class="light bg-lightMode-background">
    <header>
        <x-custom-nav />
    </header>

    <div class="mx-auto max-w-[1600px]">

        <div class="flex h-[calc(100vh-4rem)] flex-col">
            <header class="relative max-h-96 w-full min-w-96 opacity-85">
                <img alt="" class="h-full w-full object-cover"
                    src="{{ Vite::asset('/public/images/user/post/post.jpg') }}">
                <div class="absolute bottom-0 left-0 h-24 w-full bg-gradient-to-b from-transparent to-white md:hidden">
                </div>
            </header>

            <div class="flex flex-col items-center gap-5 md:flex-row md:items-start md:justify-center">
                <div class="z-10 -mt-20 w-11/12 md:w-1/3 lg:w-1/3 xl:w-1/4" id="user-profile-card">

                    <section class="flex flex-col items-center justify-center rounded-lg bg-white px-5 py-4 shadow-md">

                        <div x-data="{ editProfilePicture: false, editProfileModal: false, previewUrl: '' }"
                                @profile-image-selected.window="
                                previewUrl = $event.detail.previewImage;
                                editProfileModal = true;"
                                @close-profile-modal.window="editProfileModal = false;">
                            <figure class="relative w-36 rounded-full bg-black">
                                @auth
                                    @if ($user->id === Auth::id())
                                        <img @click="editProfilePicture = true" alt="" id="profile-picture"
                                            class="aspect-square h-full w-full cursor-pointer rounded-full object-cover transition-opacity ease-in-out hover:opacity-70"
                                            src="{{ asset('storage/' . $user->avatar) }}">
                                    @else
                                        <img alt="" class="aspect-square h-full w-full rounded-full object-cover"
                                            src="{{ asset('storage/' . $user->avatar) }}">
                                    @endif
                                @endauth
                            </figure>
                            <ul @click.outside="editProfilePicture = false"
                                class="absolute mt-1 rounded-lg border bg-white shadow-md" x-cloak
                                x-show="editProfilePicture">
                                <li class="m-2 cursor-pointer px-4 py-1 hover:bg-gray-100" id="upload-profile-picture">
                                    Upload new photo</li>
                                <input hidden id="select-profile-picture" type="file">
                                <li class="m-2 cursor-pointer px-4 py-1 hover:bg-gray-100" id="remove-profile-picture">
                                    Remove photo</li>
                                <li class="m-2 cursor-pointer px-4 py-1 hover:bg-gray-100" id="view-profile-picture">
                                    View photo</li>
                            </ul>
                            @include('profile.upload-profile-img')
                        </div>

                        <div class="text-center">
                            <h1 class="my-3 font-semibold md:text-2xl lg:text-3xl">
                                {{ $user->fname }}
                                {{ $user->lname }}</h1>
                            @if ($user->bio !== null)
                                <span
                                    class="text-sm text-lightMode-text md:text-base lg:text-base">{{ $user->bio }}</span><br>
                            @endif
                            @if ($user->location !== null)
                                <div class="my-3 text-lightMode-text">
                                    <span class="">From <span
                                            class="font-semibold">{{ $user->location }}</span></span>

                                </div>
                            @endif
                        </div>

                        <div class="my-2 flex w-full flex-wrap gap-2 text-center text-sm md:text-base lg:flex-nowrap lg:text-base"
                            x-data="{ edit_profile_details: false }">
                            @auth
                                @if ($user->id === Auth::id())
                                    <a class="w-full rounded-lg bg-lightMode-primary px-4 py-2 font-semibold text-white">
                                        420 Followers
                                    </a>
                                    <button class="w-full rounded-lg bg-gray-200 px-4 py-2 font-semibold text-black"
                                        x-on:click="edit_profile_details=true">
                                        Edit Profile
                                    </button>
                                @else
                                    <button
                                        class="w-full cursor-pointer rounded bg-lightMode-primary px-4 py-2 font-semibold text-white"
                                        type="button">
                                        <span data-user-id="{{ $user->id }}"
                                            id="follow-btn">{{ $user->followed ? 'Unfollow' : 'Follow' }}</span>

                                    </button>

                                    <a class="w-full rounded bg-gray-200 px-4 py-2 font-semibold text-black transition-all hover:bg-gray-300"
                                        href="{{ route('profile.edit') }}">
                                        Message
                                    </a>
                                @endif

                            @endauth
                            @include('profile.edit-profile-modal')
                        </div>
                    </section>

                    <section class="my-4 rounded-lg bg-white px-5 py-4 shadow-md">
                        <h6 class="text-lg font-semibold md:text-xl lg:text-xl">Interests</h6>
                        <ul class="mt-4 flex flex-wrap items-center gap-2 text-sm md:text-base lg:text-base">
                            <li class="rounded-full border border-gray-400 px-3 py-1.5 shadow-sm">Gaming</li>
                            <li class="rounded-full border border-gray-400 px-3 py-1.5 shadow-sm">Coding</li>
                            <li class="rounded-full border border-gray-400 px-3 py-1.5 shadow-sm">Anime</li>
                            <li class="rounded-full border border-gray-400 px-3 py-1.5 shadow-sm">Video Editting</li>
                            <li class="rounded-full border border-gray-400 px-3 py-1.5 shadow-sm">Music Desgin</li>
                            <li class="rounded-full border border-gray-400 px-3 py-1.5 shadow-sm">Software Engineer
                            </li>
                        </ul>
                    </section>

                    <section class="rounded-lg bg-white px-5 py-4 shadow-md">
                        <h6 class="text-lg font-semibold md:text-xl lg:text-xl">About {{ $user->fname }}</h6>
                        <ul class="my-4 text-sm md:text-base lg:text-base">
                            <li>Occupation <span class="font-semibold">Software Engineer</span></li>
                            <li>Joined <span class="font-semibold">September 2025</span></li>
                            <li>From <span class="font-semibold">{{ $user->location }}</span></li>
                        </ul>
                        <div class="">
                            <div class="mr-4 inline">
                                <span class="font-bold" id="follower-count"> {{ $user->followers_count }}</span>
                                <span class="text-sm font-normal">Followers</span>
                            </div>
                            <div class="inline">
                                <span class="font-bold" id="following-count"
                                    id="following-count">{{ $user->following_count }}</span>
                                <span class="text-sm font-normal">Following</span>
                            </div>
                        </div>
                    </section>

                </div>

                <div class="w-11/12 md:w-1/2 lg:w-2/4 xl:w-2/5">
                    <section class="">
                        <div
                            class="w-full rounded-t-lg border-b-2 border-b-lightMode-primary bg-white py-2 text-center">
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
            </div>
        </div>
    </div>

    <script>
        window.threeDotsSvg = "{{ Vite::asset('public/svg-icons/3dots.svg') }}";
    </script>
</body>

</html>
