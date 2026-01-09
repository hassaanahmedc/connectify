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
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/components/follow.js', 'resources/js/features/profile/profileImages.js', 'resources/js/components/locations.js', 'resources/js/features/profile/profileImageDeleter.js', 'resources/js/features/profile/coverImage.js'])
</head>

<body class="light bg-lightMode-background">
    {{-- Toast Notification Component --}}
    <x-notification />
    <header>
        <x-custom-nav />
    </header>
    <div class="mx-auto mt-16 max-w-[1600px]">

        <div class="h-[calc(100vh-4rem)] xl:mx-auto xl:my-0 xl:w-4/5">
            {{-- Cover Image --}}
            <header class="relative max-h-96 min-w-96 bg-black opacity-85 xl:rounded-b-lg" x-data="{ editCoverPicture: false, addCoverModal: false, cuurentPreview: '' }">
                @auth
                    @if ($user->id === Auth::id())
                        <img alt=""
                            class="profile-cover-display h-80 w-full cursor-pointer object-cover transition-opacity ease-in-out hover:opacity-70 xl:rounded-b-lg hover:shadow-lg"
                            id="cover-picture" src="{{ $user->cover_url }}">
                    @else
                        <img alt="" class="ah-full w-full object-cover xl:rounded-b-lg"
                            src="{{ $user->cover_url }}">
                    @endif
                @endauth
                {{-- Drop Shadow on Mobile Screens --}}
                <div class="absolute bottom-0 left-0 h-24 w-full bg-gradient-to-b from-transparent to-white md:hidden">
                </div>
                {{-- Cover Image Dropdown --}}

                <button @click="editCoverPicture = true"
                    class="absolute bottom-4 right-4 hidden rounded-lg bg-gray-200 px-4 py-2 font-semibold text-black shadow-md md:block"
                    id="uplaod-cover-picture" type="button">Edit Cover</button>
                <ul @click.outside="editCoverPicture = false"
                    class="bottom-0- absolute right-4 mt-1 rounded-lg border bg-white shadow-md" x-cloak
                    x-show="editCoverPicture">
                    
                    <li class="m-2 cursor-pointer px-4 py-1 hover:bg-gray-100" id="upload-cover-picture">
                        Upload new photo</li>
                    <input hidden id="select-cover-picture" type="file">
                    @if ($user->avatar)
                        <li class="m-2 cursor-pointer px-4 py-1 hover:bg-gray-100" id="remove-cover-picture"
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-picture-deletion')">
                            Remove photo</li>
                    @endif
                    <li class="m-2 cursor-pointer px-4 py-1 hover:bg-gray-100" id="view-cover-picture"
                        x-on:click.stop="
                                        $dispatch('open-image-viewer', { currentImageUrl: '{{ $user->cover_url }}' });
                                        $nextTick(() => editCoverPicture = false);">
                        View photo</li>
                </ul>
            </header>

            <div class="flex w-full flex-col items-center gap-5 md:flex-row md:items-start md:justify-center">
                <div class="z-10 -mt-20 w-full max-w-md px-4 md:w-1/3 md:px-0 lg:w-1/3">

                    <section class="flex flex-col items-center justify-center rounded-lg bg-white px-5 py-4 shadow-md"
                        id="user-profile-card">

                        <div @close-profile-modal.window="editProfileModal = false;"
                            @profile-image-selected.window="
                                previewUrl = $event.detail.previewImage;
                                editProfileModal = true;"
                            x-data="{ editProfilePicture: false, editProfileModal: false, previewUrl: '' }">
                            <figure class="relative w-36 rounded-full bg-black">
                                @auth
                                    @if ($user->id === Auth::id())
                                        <img @click="editProfilePicture = true" alt=""
                                            class="profile-picture-display aspect-square h-full w-full cursor-pointer rounded-full object-cover transition-opacity ease-in-out hover:opacity-70"
                                            id="profile-picture" src="{{ $user->avatar_url }}">
                                    @else
                                        <img alt="" class="aspect-square h-full w-full rounded-full object-cover"
                                            src="{{ $user->avatar_url }}">
                                    @endif
                                @endauth
                            </figure>
                            <ul @click.outside="editProfilePicture = false"
                                class="absolute mt-1 rounded-lg border bg-white shadow-md" x-cloak
                                x-show="editProfilePicture">
                                <li class="m-2 cursor-pointer px-4 py-1 hover:bg-gray-100" id="upload-profile-picture">
                                    Upload new photo</li>
                                <input hidden id="select-profile-picture" type="file">
                                @if ($user->avatar)
                                    <li class="m-2 cursor-pointer px-4 py-1 hover:bg-gray-100"
                                        id="remove-profile-picture"
                                        x-on:click.prevent="$dispatch('open-modal', 'confirm-picture-deletion')">
                                        Remove photo</li>
                                @endif
                                <li class="m-2 cursor-pointer px-4 py-1 hover:bg-gray-100" id="view-profile-picture"
                                    x-on:click.stop="
                                        $dispatch('open-image-viewer', { currentImageUrl: '{{ $user->avatar_url }}' });
                                        $nextTick(() => editProfilePicture = false);">
                                    View photo</li>
                            </ul>
                            @include('profile.upload-profile-img', [
                                'toggleVariable' => 'editProfileModal',
                                'previewUrl' => 'previewUrl',
                            ])
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

                <div class="w-full max-w-2xl px-4 md:w-1/2 md:px-0 lg:w-2/4">
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

    <x-image-viewer />
    {{-- Modal for uploading Cover Image  --}}
    <x-modal :show="false" name="image-upload-preview" 
        x-on:close-modal.window="$event.detail == 'image-upload-preview' ? show = false : null"  focusable>

        <div class="p-6" x-data="{ previewUrl: '', profileErrors: [], title: 'Upload Preview', previewClass: 'w-64 h-64' }"
            x-on:open-image-preview.window="
                previewUrl = $event.detail.previewUrl;
                profileErrors = $event.detail.profileErrors;
                title = $event.detail.title;
                previewClass = $event.detail.previewClass;
                ">

            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 text-center" x-text="title"></h2>
            <div>
                <figure class="my-4 flex justify-center w-full" id="image-upload-preview-container" 
                        x-show="profileErrors.length === 0">

                    <img :src="previewUrl" :class="previewClass" alt="profile picture" 
                        class="w-64 h-64 object-contain aspect-square"
                        id="image-upload-preview" x-show="previewUrl">

                </figure>
                <div id="error-container" class="text-center" x-cloak x-transition x-show="profileErrors.length > 0">
                    <div aria-live="assertive" role="alert" id="profile-error"
                         class="flex items-start gap-3 rounded-lg border border-red-200 bg-red-50 p-4 shadow-sm">

                         <ul class="flex flex-col gap-1">
                            <template x-for="error in profileErrors" :key="error">
                                <li x-text="error" class="text-sm font-medium leading-relaxed text-red-800 list-none"></li>
                            </template>
                         </ul>
                    </div>
                    <button id="try-again-button" 
                        class="my-4 w-full rounded-lg bg-lightMode-primary px-4 py-2 font-semibold text-white">
                        Select a Different File</button>
                </div>
                <!-- inside modal next to preview -->
                <div class="flex w-full flex-wrap gap-2 text-center text-sm sm:flex-nowrap md:text-base lg:text-base">

                    <button x-on:click="$dispatch('close')"
                        class="w-full rounded-lg bg-gray-200 px-4 py-2 font-semibold text-black"
                        type="button">Cancel</button>
                    <button x-show="profileErrors.length === 0" 
                        class="w-full rounded-lg bg-lightMode-primary px-4 py-2 font-semibold text-white"
                        id="save-upload-button" type="submit">Save</button>
                </div>
            </div>
        </div>
    </x-modal>
    {{-- Confirm Profile Picture Deletion Modal --}}
    <x-modal :show="false" focusable name="confirm-picture-deletion">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Are you sure?</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">This action cannot be undone. Your picture will be
                replaced by default avatar</p>
            <div class="mt-6 flex justify-end gap-2">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('cancel') }}
                </x-secondary-button>

                <x-primary-button id="comfirm-delete-"
                    x-on:click="$dispatch('confirm-picture-deletion'); $dispatch('close')">
                    {{ __('Confirm Delete') }}
                </x-primary-button>
            </div>
        </div>
    </x-modal>

    <script>
        window.threeDotsSvg = "{{ Vite::asset('public/svg-icons/3dots.svg') }}";
    </script>
</body>

</html>
