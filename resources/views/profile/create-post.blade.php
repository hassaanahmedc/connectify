<div class="w-screen fixed h-screen bg-black/80 top-0 left-0  flex justify-center items-center z-[100] overflow-y-auto"
    x-cloak
    x-show="create_post">
    <section id="appointmentForm"
        class="relative bg-white max-w-screen-sm bg-base-200 min-w-[350px] py-10 px-10 flex justify-center overflow-y-scroll md:w-3/4">
        {{-- close Modal Button --}}
        <svg class="swap-on fill-current absolute right-4 top-8 cursor-pointer"
            x-on:click="create_post=false"
            xmlns="http://www.w3.org/2000/svg"
            width="32"
            height="32"
            viewBox="0 0 512 512">
            <polygon
                points="400 145.49 366.51 112 256 222.51 145.49 112 112 145.49 222.51 256 112 366.51 145.49 400 256 289.49 366.51 400 400 366.51 289.49 256 400 145.49" />
        </svg>
        <div class="w-full">
            <h2 class="text-3xl font-bold mb-8 text-center">Create Post
            </h2>
            <form action="{{ route('post.store') }}"
                method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="">
                    <div
                        class="flex gap-4 items-center w-10 font-bold/[1px] text-base/[1rem] font-montserrat">
                        <img src="{{ Vite::asset('/public/images/user/profile/profile.jpg') }}"
                            class="bg-gray-200 w-10 rounded-full"
                            alt="">
                        <span class="">{{ Auth::user()->fname }}</span>
                    </div>

                    <textarea
                        class="block mt-2 w-full border-none focus:border-none focus:ring-0 shadow-sm resize-none"
                        name="content"
                        id="content"
                        placeholder="What's happening?..."></textarea>
                    <x-input-error :messages="$errors->get('content')"
                        class="mt-2" />
                </div>
                <div>
                    <x-image-upload />
                </div>
                <div class="flex justify-between mt-8">
                    <button type="submit"
                        class="px-8 py-2 text-lg rounded bg-lightMode-primary text-white">Post</button>
                    <div>
                        <div id="imageSelectorSvg">
                            <x-svg-icons.images />
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
