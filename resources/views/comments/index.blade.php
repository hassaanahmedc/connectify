@forelse($comments as $comment)
    <div class="mt-2 pt-2">
        <div class="flex gap-2">
            <div class="w-8 h-8 flex-shrink-0">
                <img src="https://placewaifu.com/image/200"
                    class="bg-gray-200 rounded-full object-cover w-full h-full"
                    loading="lazy"
                    alt="">
            </div>
            <div class="flex-1 bg-gray-100 rounded-lg px-3 py-1">
                <span class="text-sm font-bold">{{ $comment->user->fname }}</span>
                <span class="text-sm">{{ $comment->content }}</span>
                <div class="text-xs text-gray-500 mt-1"><span>{{ $comment->created_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>
    </div>    
@empty
    <div>No Comments</div>
@endforelse
