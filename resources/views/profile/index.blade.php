<x-app-layout>
    @vite(['resources/js/imageUpload.js'])
    <div class="max-w-[1280px] mx-auto my-0">
        {{-- header --}}
        <div class="" >
            <header class=" relative w-full max-h-[480px] h-[50vh]">
                <img src="{{ Vite::asset('/public/images/user/post/post.jpg') }}"
                    class="w-full h-full object-cover"
                    alt="">
            </header>
            <section x-data="{ edit_profile: false }" class="bg-white">
                <div 
                    class="flex flex-col items-center justify-center mb-[-50px] px-8 transform translate-y-[-25%] md:transform md:translate-y-[-50%] md:flex-row md:justify-between md:items-end">
                    {{-- Profile Picture --}}
                    <div
                        class="flex flex-col gap-2 items-center md:flex-row  md:items-end">
                        <figure class="w-[168px] rounded-full p-1 bg-white">
                            <img src="https://placewaifu.com/image/200"
                                class="w-full h-full object-cover rounded-full aspect-square"
                                alt="">
                        </figure>
                        <div class="my-2 text-center md:text-start">
                            @auth
                                @if ($user->id === Auth::id())
                                    <h1 class="font-bold text-3xl">
                                        {{ Auth::user()->fname }}
                                        {{ Auth::user()->lname }}</h1>
                                    <span
                                        class="text-lightMode-text">{{ Auth::user()->email }}</span>
                                @else
                                    <h1 class="font-bold text-3xl">
                                        {{ $user->fname }}
                                        {{ $user->lname }}</h1>
                                    <span
                                        class="text-lightMode-text">{{ $user->email }}</span>
                                @endif

                            @endauth
                        </div>
                    </div>
                    <div class="relative my-2 flex gap-2 text-sm sm:text-base">
                        @auth
                            @if ($user->id === Auth::id())
                                <a
                                    class="flex items-center gap-2 px-4 py-2 font-semibold rounded bg-lightMode-primary text-white">
                                    <img src="{{ Vite::asset('/public/svg-icons/camera.svg') }}"
                                        class="text-black"
                                        alt="Edit Icon">
                                    420 Friends
                                </a>
                                <button x-on:click="edit_profile=true" 
                                    class="flex items-center gap-2 px-4 py-2 font-semibold rounded bg-gray-200 hover:bg-gray-300 transition-all text-black">
                                    <img src="{{ Vite::asset('/public/svg-icons/edit.svg') }}"
                                        class="text-black"
                                        alt="Edit Icon">
                                    Edit Profile
                                </button>
                                    
                            @else
                                <a
                                    class="flex items-center gap-2 px-4 py-2 font-semibold rounded bg-lightMode-primary text-white">
                                    <img src="{{ Vite::asset('/public/svg-icons/camera.svg') }}"
                                        class="text-black"
                                        alt="Edit Icon">
                                    Follow
                                </a>
                                <a href="{{ route('profile.edit') }}"
                                    class="flex items-center gap-2 px-4 py-2 font-semibold rounded bg-gray-200 hover:bg-gray-300 transition-all text-black">
                                    <img src="{{ Vite::asset('/public/svg-icons/edit.svg') }}"
                                        class="text-black"
                                        alt="Edit Icon">
                                    Message
                                </a>
                            @endif

                        @endauth
                    </div>
                </div>
                @include('profile.edit-profile-modal')
                <script>
                
                </script>
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

        <div x-data="{ edit_bio: false, create_post: false }"
            class=" min-w-[360px] max-w-5xl flex flex-col mx-auto my-0 px-6 gap-6 md:flex-row md:px-0">

            <section
                class="md:sticky md:top-0  mt-16 h-fit rounded-lg md:w-2/5">
                <div
                    class="shadow-[0px_10px_34px_-15px_rgba(0,0,0,0.10)] bg-white p-4 px-6">
                    <h1 class="font-bold text-xl mb-2 font-montserrat">Bio</h1>
                    <span class="font-roboto">{{ $user->bio }}</span>
                    <div class="flex gap-1 mt-2">
                        <img src="{{ Vite::asset('/public/svg-icons/location.svg') }}"
                            alt="">
                        <span>From <span
                                class="font-semibold">{{ $user->location }}</span></span>
                    </div>

                    <div x-on:click="edit_bio = true"
                        class="w-full py-2 mt-2 bg-gray-200 hover:bg-gray-300 transition-all rounded text-center cursor-pointer">
                        <span class="font-semibold">Edit Bio</span>
                    </div>

                    @include('profile.edit-bio', ['user' => $user])
                </div>
                <div
                    class="shadow-[0px_10px_34px_-15px_rgba(0,0,0,0.10)] mt-8 bg-white p-4 px-6">
                    <h1 class="font-bold text-xl mb-2 font-montserrat">chem</h1>
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
                    <div class="flex gap-1 mt-2">
                        <img src="{{ Vite::asset('/public/svg-icons/location.svg') }}"
                            alt="">
                        <span>From <span
                                class="font-semibold">Sukkur</span></span>
                    </div>
                </div>

                <div
                    class="shadow-[0px_10px_34px_-15px_rgba(0,0,0,0.10)] mt-8 bg-white p-4 px-6">
                    <h1 class="font-bold text-xl mb-2 font-montserrat">SST</h1>
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
                    <div class="flex gap-1 mt-2">
                        <img src="{{ Vite::asset('/public/svg-icons/location.svg') }}"
                            alt="">
                        <span>From <span
                                class="font-semibold">Sukkur</span></span>
                    </div>
                </div>

                <div
                    class="shadow-[0px_10px_34px_-15px_rgba(0,0,0,0.10)] mt-8 bg-white p-4 px-6">
                    <h1 class="font-bold text-xl mb-2 font-montserrat">Physiscs
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
                    <div class="flex gap-1 mt-2">
                        <img src="{{ Vite::asset('/public/svg-icons/location.svg') }}"
                            alt="">
                        <span>From <span
                                class="font-semibold">Sukkur</span></span>
                    </div>
                </div>


            </section>

            <section class="mt-16 rounded-lg md:w-3/5">
                <div
                    class="bg-white p-4 rounded-xl shadow-[0px_10px_34px_-15px_rgba(0,0,0,0.10)]">
                    <div class="flex gap-4 ">
                        <div class=" w-10">
                            <img src="https://placewaifu.com/image/200"
                                class="bg-gray-200 w-10 h-10 rounded-full"
                                alt="">
                        </div>
                        <div x-data="{ create_post: false }"
                            class="w-full">
                            <div 
                                class="relative flex items-center justify-end cursor-pointer"
                                @click="create_post = true">
                                <div
                                    class="bg-lightMode-background rounded-full border border-zinc-200 w-full text-sm py-2 px-4 text-gray-500">
                                    Share something...
                                </div>
                            </div>
                            {{-- Post Modal --}}
                            @include('posts.create', [
                                'isEdit' => false,
                                'showVariable' => 'create_post',
                                'postUrl' => route('post.store'),
                            ])
                            <div
                                class="flex items-center justify-around gap-8 mt-4 sm:justify-around">
                                <div
                                    @click="create_post = true"
                                    class="flex items-center gap-2 text-base font-semibold cursor-pointer hover:text-lightMode-primary transition-colors">
                                    <img src="{{ Vite::asset('/public/svg-icons/photos.svg') }}"
                                        class="w-7 h-auto"
                                        alt=""> <span>Image</span>
                                </div>

                                <div
                                    @click="create_post = true"
                                    class="flex items-center gap-2 text-base font-semibold cursor-pointer hover:text-lightMode-primary transition-colors">
                                    <img src="{{ Vite::asset('/public/svg-icons/videocam.svg') }}"
                                        class="w-7 h-auto"
                                        alt=""> <span>Video</span>
                                </div>

                                <div
                                    @click="create_post = true"
                                    class="text-base font-semibold hidden sm:flex cursor-pointer hover:text-lightMode-primary transition-colors">
                                    <img src="{{ Vite::asset('/public/svg-icons/poll.svg') }}"
                                        class="w-7 h-auto"
                                        alt=""> <span>Poll</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col">
                    {{-- @forelse ($posts as $post) --}}
                    @if ($user->post->count())
                        @foreach ($user->post as $post)
                            @php
                                $profileImageUrl = !empty($user->avatar)
                                    ? $user->avatar
                                    : 'https://placewaifu.com/image/200';
                            @endphp
                            @include('posts.feed-card', [
                                'profileUrl' => route(
                                    'profile.view',
                                    $post->user->id),
                                'postId' => $post->id,
                                'userName' =>
                                    $user->fname . ' ' . $user->lname,
                                'postTime' => $post->created_at->diffForHumans(),
                                'postContent' => $post->content,
                                'postImages' => $post->postImages,
                            ])
                        @endforeach

                    @endif

                </div>
            </section>
        </div>
    </div>

</x-app-layout>
