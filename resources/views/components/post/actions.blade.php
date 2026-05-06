{{-- Likes and Comment Buttons: Trigger like action and comment toggle --}}
<div 
    x-data="{
        ...comments({{$post->id}}, {{$post->comment_count ?? 0}}),
        ...shareUrl('{{ route('post.view', $post->id) }}')
    }">
    <div class="flex items-center justify-between px-6 py-2 ">
        <div class="flex gap-8">
            {{-- Like Button --}}
            <button data-post-id="{{ $post->id }}"
                    data-user-id="{{ auth()->id() }}"
                    class="like-btn flex gap-1 p-2 items-center cursor-pointer hover:bg-gray-100 hover:rounded-lg min-h-[44px]">
                <x-svg-icons.heart class=" w-6 h-auto like-icon {{ $post->liked_by_user ? 'liked-icon' : 'default-svg-color' }}" />
                <span class="like-count text-xs sm:text-sm">{{ $post->likes_count ?? 0 }}</span>
            </button>
            {{-- Comments Button --}}
            <button @click="showComments = !showComments"
                    class="flex gap-1 p-2 items-center cursor-pointer hover:bg-gray-100 hover:rounded-lg min-h-[44px]">
                <x-svg-icons.comment class="w-6 h-auto" />
                <span class="comment-count text-xs sm:text-sm" x-text="commentCount"></span>
            </button>
        </div>

        <button @click="copyToClipboard()"
                class="flex gap-1 p-2 items-center cursor-pointer hover:bg-gray-100 hover:rounded-lg 
                    min-h-[44px] relative">
            <x-svg-icons.share-icon class="w-6 h-auto" />
            {{-- Toast/Tooltip Message --}}
            <div x-cloak 
                 x-show="copied" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-1"
                 class="absolute bottom-full left-1/2 -translate-x-1/2  mb-2 bg-gray-900 text-white 
                    text-xs font-semibold py-1 px-3 rounded-lg shadow-lg z-50">
                Link copied!
            </div>
        </button>

    </div>

    <div class="border-y-2 mx-2 px-2" x-cloak x-show="showComments" @click.away="showComments = false">
        <div x-ref="commentsList" class="comments-container " data-post-id="{{ $post->id  }}">
            {{-- Renders comments if available --}}
            @if ($post->limited_comments->count())
                @foreach($post->limited_comments as $comment)
                    <x-comments :comment="$comment" />
                @endforeach
            @endif
        </div>
        {{-- Load More Comments: Fetches additional comments via AJAX if count exceeds 5 --}}
        @if (($post->comment_count ?? 0) > 5)
            <div class="text-center text-gray-500">
                <button @click="loadMoreComments" x-clock x-show="hasMoreComments"
                        class="  min-h-[44px] text-xs sm:text-sm">
                        View more comments</button>
            </div>
        @endif
        <div x-cloak x-show="loading" class="text-center my-4">
            <x-svg-icons.loading  class="w-7 h-auto animate-spin" />
        </div>
        <div class="border-t-2">
            @include('comments.create', ['post_id' => $post->id])
        </div>
    </div>

</div>