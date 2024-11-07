<div class="p-2">
    <div class="flex items-center">
        <div>
            <img src="{{ Vite::asset('/public/svg-icons/smiley.svg') }}"
                class="ml-2 px-2"
                alt="">
        </div>
        <div class="w-full">
            <textarea
                class="comment-textarea w-full text-sm h-8 max-h-36 min-h-8 border-none focus:border-none focus:ring-0 resize-none overflow-y-auto"
                name=""
                id=""
                placeholder="Add a Comment"></textarea>
        </div>
        <div>
            <button
                class="postButton text-gray-400 hover:text-lightMode-primary cursor-pointer font-semibold">
                Post</button>
        </div>
    </div>
</div>
