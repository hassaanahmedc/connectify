<div class="my-2">
    <div class="flex items-center">
        <div>
            <img src="{{ Auth::user()->avatar_url }}"
                class="w-8 h-8 rounded-full"
                alt="">
        </div>
        <div class="w-full px-2">
            <textarea
                class="w-full text-sm min-h-8 max-h-36 p-2 border border-gray-300 rounded-lg resize-none overflow-y-auto px-2"
                name="comment"
                id="comment"
                x-model="content"
                placeholder="Add a Comment"
                x-init="$el.style.height = '32px';"
                @input="$el.style.height = 'auto'; $el.style.height = ($el.scrollHeight) + 'px';"
                style="height: 32px;"></textarea>
        </div>
        <div>
            <button @click="createComment" class="text-lightMode-primary text-sm font-bold 
                         shadow-sm transition-all" 
                        :disabled="loading || (content.trim().length === 0)"
                        :class="loading || (content.trim().length === 0) 
                            ? 'opacity-50 cursor-not-allowed' 
                            : ''">
                Post</button>
        </div>
    </div>
</div>
