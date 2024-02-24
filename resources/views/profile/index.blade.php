<x-app-layout>
    <div class="max-w-[1280px] mx-auto my-0">
        {{-- header --}}
        <div class="">
            <header class=" relative w-full max-h-[480px] h-[50vh]">
                <img src="{{ Vite::asset('/public/images/user/post/post.jpg') }}"
                    class="w-full h-full object-cover"
                    alt="">
            </header>
            <section class="bg-white">
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
                            <h1 class="font-bold text-3xl">Hassaan Ahmed</h1>
                            <span class="text-lightMode-text">420 Friends</span>
                        </div>
                    </div>
                    <div class="my-2 flex gap-2 text-sm sm:text-base">
                        <button
                            class="flex items-center gap-2 px-4 py-2 font-semibold rounded bg-lightMode-primary text-white">
                            <img src="{{ Vite::asset('/public/svg-icons/camera.svg') }}"
                                class="text-black"
                                alt="Edit Icon">
                            Profile Picture
                        </button>
                        <button
                            class="flex items-center gap-2 px-4 py-2 font-semibold rounded bg-gray-200 text-black">
                            <img src="{{ Vite::asset('/public/svg-icons/edit.svg') }}"
                                class="text-black"
                                alt="Edit Icon">
                            Edit Profile
                        </button>
                    </div>
                </div>
            </section>
        </div>
        {{-- Main content --}}
        <div
            class=" min-w-[360px] max-w-5xl flex flex-col mx-auto my-0 px-6 gap-6 md:flex-row md:px-0">

            <section
                class="md:sticky md:top-0  mt-16 h-fit rounded-lg md:w-2/5">
                <div
                    class="shadow-[0px_10px_34px_-15px_rgba(0,0,0,0.10)] bg-white p-4 px-6">
                    <h1 class="font-bold text-xl mb-2 font-montserrat">Bio</h1>
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
                    <h1 class="font-bold text-xl mb-2 font-montserrat">Physiscs</h1>
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


            </section>

            <section class="mt-16 rounded-lg md:w-3/5">
                <div
                    class="bg-white p-4 rounded-xl shadow-[0px_10px_34px_-15px_rgba(0,0,0,0.10)]">
                    <div class="flex gap-4 ">
                        <div class=" w-10">
                            <img src="{{ Vite::asset('/public/images/user/profile/profile.jpg') }}"
                                class="bg-gray-200 w-10 rounded-full"
                                alt="">
                        </div>
                        <div class="w-full md:h-[10vh]">
                            <div class="relative flex items-center justify-end">
                                <input type="search"
                                    name=""
                                    class="bg-lightMode-background rounded-full border-zinc-200 w-full text-sm focus:border-none"
                                    placeholder="Share Something..."
                                    id="">
                                <img src="{{ Vite::asset('/public/svg-icons/smiley.svg') }}"
                                    class="ml-2 px-2 absolute"
                                    alt="">
                            </div>
                            <div
                                class="flex items-center justify-around gap-8 mt-4 sm:justify-around">
                                <div
                                    class="flex items-center gap-2 text-base font-semibold">
                                    <img src="{{ Vite::asset('/public/svg-icons/photos.svg') }}"
                                        class="w-7 h-auto"
                                        alt=""> <span>Image</span>
                                </div>

                                <div
                                    class="flex items-center gap-2 text-base font-semibold">
                                    <img src="{{ Vite::asset('/public/svg-icons/videocam.svg') }}"
                                        class="w-7 h-auto"
                                        alt=""> <span>Video</span>
                                </div>

                                <div
                                    class="text-base font-semibold hidden sm:flex">
                                    <img src="{{ Vite::asset('/public/svg-icons/poll.svg') }}"
                                        class="w-7 h-auto"
                                        alt=""> <span>Poll</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col">
                    <x-feed-card />
                    <x-feed-card />
                    <x-feed-card />
                    <x-feed-card />
                </div>
            </section>
        </div>
    </div>

</x-app-layout>
