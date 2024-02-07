<div class="flex flex-col bg-white p-6 rounded-xl mt-8">
    <div class="flex justify-between items-center">
        <div class="flex items-center gap-4">
            <a href="{{ route("userProfile") }}"><img src="{{ Vite::asset('/public/images/user/profile/profile.jpg') }}"
                class="bg-gray-200 w-10 rounded-full"
                alt=""></a>
            <div>
                <span
                    class="font-bold/[1px] text-base/[1rem] font-montserrat block"><a href="{{ route("userProfile") }}">Hassaan
                    Ahmed</a></span>
                <span class="text-gray-400 text-sm inline">12 minutes ago</span>
            </div>
        </div>
        <div>
            <img src="{{ Vite::asset('/public/svg-icons/3dots.svg') }}"
                alt="">
        </div>
    </div>
    <div class="my-4">
        <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui rem
            molestiae illo dolorem quaerat quisquam error itaque maiores cum
            nemo
            esse sit, similique autem perspiciatis consequuntur. Quas
            perferendis
            facere dolor molestias itaque minus facilis. Ipsa ut soluta veniam
            atque
            culpa?
        </p>
    </div>
    <div>
        <img src="{{ Vite::asset('/public/images/user/post/post.jpg') }}"
            class="w-full h-full object-cover"
            alt="">
    </div>
</div>
