<x-app-layout>
    <div class="bg-white max-w-[1280px] w-full mx-auto my-0">
        <header class="relative w-full max-h-[480px] h-[50vh]">
            <img src="{{ Vite::asset('/public/images/user/post/post.jpg') }}"
                class="w-full h-full object-cover"
                alt="">
        </header>
        <section>
            <div
                class="flex items-end justify-between mb-[-50px] px-8 transform translate-y-[-50%]">
                {{-- Profile Picture --}}
                <div class="flex gap-8 items-end">
                    <figure class="w-[168px] rounded-full p-1 bg-white">
                        <img src="https://placewaifu.com/image/200"
                            class="w-full h-full object-cover rounded-full aspect-square"
                            alt="">
                    </figure>
                    <div class="my-4">
                        <h1 class="font-bold text-3xl">Hassaan Ahmed</h1>
                        <span class="text-lightMode-text">420 Friends</span>
                    </div>
                </div>
                <div class="my-4 flex gap-8">
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
</x-app-layout>
