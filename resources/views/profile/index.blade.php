<x-app-layout>
    <div class="mx-auto my-0 max-w-[1280px]">
        {{-- header --}}
        <div class="">
            <header class="relative h-[50vh] max-h-[480px] w-full">
                <img alt="" class="h-full w-full object-cover" src="{{ Vite::asset('/public/images/user/post/post.jpg') }}">
            </header>
            <section class="bg-white" x-data="{ edit_profile: false }">
                <div class="mb-[-50px] flex translate-y-[-25%] transform flex-col items-center justify-center px-8 md:translate-y-[-50%] md:transform md:flex-row md:items-end md:justify-between">
                    {{-- Profile Picture --}}
                    <div class="flex flex-col items-center gap-2 md:flex-row md:items-end">
                        <figure class="w-[168px] rounded-full bg-white p-1">
                            <img alt="" class="aspect-square h-full w-full rounded-full object-cover" src="https://placewaifu.com/image/200">
                        </figure>
                        <div class="my-2 text-center md:text-start">
                            @auth
                            @if ($user->id === Auth::id())
                            <h1 class="text-3xl font-bold">
                                {{ Auth::user()->fname }}
                                {{ Auth::user()->lname }}</h1>
                            <span class="text-lightMode-text">{{ Auth::user()->email }}</span>
                            @else
                            <h1 class="text-3xl font-bold">
                                {{ $user->fname }}
                                {{ $user->lname }}</h1>
                            <span class="text-lightMode-text">{{ $user->email }}</span>
                            @endif

                            @endauth
                        </div>
                    </div>
                    <div class="relative my-2 flex gap-2 text-sm sm:text-base">
                        @auth
                        @if ($user->id === Auth::id())
                        <a class="flex items-center gap-2 rounded bg-lightMode-primary px-4 py-2 font-semibold text-white">
                            <img alt="Edit Icon" class="text-black" src="{{ Vite::asset('/public/svg-icons/camera.svg') }}">
                            420 Friends
                        </a>
                        <button class="flex items-center gap-2 rounded bg-gray-200 px-4 py-2 font-semibold text-black transition-all hover:bg-gray-300" x-on:click="edit_profile=true">
                            <img alt="Edit Icon" class="text-black" src="{{ Vite::asset('/public/svg-icons/edit.svg') }}">
                            Edit Profile
                        </button>
                        @else
                        <a class="flex items-center gap-2 rounded bg-lightMode-primary px-4 py-2 font-semibold text-white">
                            <img alt="Edit Icon" class="text-black" src="{{ Vite::asset('/public/svg-icons/camera.svg') }}">
                            Follow
                        </a>
                        <a class="flex items-center gap-2 rounded bg-gray-200 px-4 py-2 font-semibold text-black transition-all hover:bg-gray-300" href="{{ route('profile.edit') }}">
                            <img alt="Edit Icon" class="text-black" src="{{ Vite::asset('/public/svg-icons/edit.svg') }}">
                            Message
                        </a>
                        @endif

                        @endauth
                    </div>
                </div>
                @include('profile.edit-profile-modal')
                <script></script>
            </section>
        </div>
        {{-- Main content --}}
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="mx-auto my-0 flex min-w-[360px] max-w-5xl flex-col gap-6 px-6 md:flex-row md:px-0" x-data="{ edit_bio: false, create_post: false }">

            <section class="mt-16 h-fit rounded-lg md:sticky md:top-0 md:w-2/5">
                <div class="bg-white p-4 px-6 shadow-[0px_10px_34px_-15px_rgba(0,0,0,0.10)]">
                    <h1 class="mb-2 font-montserrat text-xl font-bold">Bio</h1>
                    <span class="font-roboto">{{ $user->bio }}</span>
                    <div class="mt-2 flex gap-1">
                        <img alt="" src="{{ Vite::asset('/public/svg-icons/location.svg') }}">
                        <span>From <span class="font-semibold">{{ $user->location }}</span></span>
                    </div>

                    <div class="mt-2 w-full cursor-pointer rounded bg-gray-200 py-2 text-center transition-all hover:bg-gray-300" x-on:click="edit_bio = true">
                        <span class="font-semibold">Edit Bio</span>
                    </div>

                    @include('profile.edit-bio', ['user' => $user])
                </div>
                <div class="mt-8 bg-white p-4 px-6 shadow-[0px_10px_34px_-15px_rgba(0,0,0,0.10)]">
                    <h1 class="mb-2 font-montserrat text-xl font-bold">chem</h1>
                    <span class="font-roboto">Lorem, ipsum dolor sit amet
                        consectetur adipisicing elit. Delectus eaque
                        eligendi
                        deleniti quisquam, blanditiis sunt ratione maxime
                        magni
                        repudiandae sit nesciunt porro quaerat quod et
                        culpa,
                        amet ad vero quo? Voluptatibus beatae assumenda id
                        temporibus nostrum excepturi quo esse
                        molestias?</span>
                    <div class="mt-2 flex gap-1">
                        <img alt="" src="{{ Vite::asset('/public/svg-icons/location.svg') }}">
                        <span>From <span class="font-semibold">Sukkur</span></span>
                    </div>
                </div>

                <div class="mt-8 bg-white p-4 px-6 shadow-[0px_10px_34px_-15px_rgba(0,0,0,0.10)]">
                    <h1 class="mb-2 font-montserrat text-xl font-bold">SST</h1>
                    <span class="font-roboto">Lorem, ipsum dolor sit amet
                        consectetur adipisicing elit. Delectus eaque
                        eligendi
                        deleniti quisquam, blanditiis sunt ratione maxime
                        magni
                        repudiandae sit nesciunt porro quaerat quod et
                        culpa,
                        amet ad vero quo? Voluptatibus beatae assumenda id
                        temporibus nostrum excepturi quo esse
                        molestias?</span>
                    <div class="mt-2 flex gap-1">
                        <img alt="" src="{{ Vite::asset('/public/svg-icons/location.svg') }}">
                        <span>From <span class="font-semibold">Sukkur</span></span>
                    </div>
                </div>

                <div class="mt-8 bg-white p-4 px-6 shadow-[0px_10px_34px_-15px_rgba(0,0,0,0.10)]">
                    <h1 class="mb-2 font-montserrat text-xl font-bold">Physiscs
                    </h1>
                    <span class="font-roboto">Lorem, ipsum dolor sit amet
                        consectetur adipisicing elit. Delectus eaque
                        eligendi
                        deleniti quisquam, blanditiis usnt ratione maxime
                        magni
                        repudiandae sit nesciunt porro quaerat quod et
                        culpa,
                        amet ad vero quo? Voluptatibus beatae assumenda id
                        temporibus nostrum excepturi quo esse
                        molestias?</span>
                    <div class="mt-2 flex gap-1">
                        <img alt="" src="{{ Vite::asset('/public/svg-icons/location.svg') }}">
                        <span>From <span class="font-semibold">Sukkur</span></span>
                    </div>
                </div>


            </section>

            <section class="mt-16 rounded-lg md:w-3/5">
                <div class="rounded-xl bg-white p-4 shadow-[0px_10px_34px_-15px_rgba(0,0,0,0.10)]">
                    <div class="flex gap-4">
                        <div class="w-10">
                            <img alt="" class="h-10 w-10 rounded-full bg-gray-200" src="https://placewaifu.com/image/200">
                        </div>
                        <div x-data="{ create_post: false }" 
                        x-on:close-modal.window="if ($event.detail.modal === 'create_post') create_post = false"
                        class="w-full">
                        <div 
                            class="relative flex items-center justify-end cursor-pointer"
                            @click="create_post = true">
                            <div
                                class="bg-lightMode-background rounded-full border border-zinc-200 w-full text-sm py-2 px-4 text-gray-500">
                                Share something...
                            </div>
                            <img src="{{ Vite::asset('/public/svg-icons/smiley.svg') }}"
                                class="ml-2 px-2 absolute right-2"
                                alt="">
                        </div>
                            {{-- Post Modal --}}
                            @include('posts.create', [
                            'showVariable' => 'create_post',    
                            ])
                            <div class="mt-4 flex items-center justify-around gap-8 sm:justify-around">
                                <div @click="create_post = true" class="flex cursor-pointer items-center gap-2 text-base font-semibold transition-colors hover:text-lightMode-primary">
                                    <img alt="" class="h-auto w-7" src="{{ Vite::asset('/public/svg-icons/photos.svg') }}">
                                    <span>Image</span>
                                </div>

                                <div @click="create_post = true" class="flex cursor-pointer items-center gap-2 text-base font-semibold transition-colors hover:text-lightMode-primary">
                                    <img alt="" class="h-auto w-7" src="{{ Vite::asset('/public/svg-icons/videocam.svg') }}">
                                    <span>Video</span>
                                </div>

                                <div @click="create_post = true" class="hidden cursor-pointer text-base font-semibold transition-colors hover:text-lightMode-primary sm:flex">
                                    <img alt="" class="h-auto w-7" src="{{ Vite::asset('/public/svg-icons/poll.svg') }}">
                                    <span>Poll</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="newsfeed" class="flex flex-col">
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
</x-app-layout>
