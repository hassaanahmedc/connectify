{{-- Likes and Comment Buttons: Trigger like action and comment toggle --}}
<div x-data="comments({{$post->id}}, {{$post->comment_count ?? 0}})">
    <div class="flex items-center gap-4 sm:gap-8 p-2 mx-2 px-2">
        {{-- Like Button --}}
        <button data-post-id="{{ $post->id }}"
                data-user-id="{{ auth()->id() }}"
                class="like-btn flex gap-1 p-2 items-center cursor-pointer hover:bg-gray-100 hover:rounded-lg min-h-[44px]">
            <x-svg-icons.heart class=" w-6 h-auto like-icon {{ $post->isLiked ? 'liked-icon' : 'default-svg-color' }}" />
            <span class="like-count text-xs sm:text-sm">{{ $post->likes_count ?? 0 }}</span>
        </button>
        {{-- Comments Button --}}
        <button @click="showComments = !showComments"
                class="flex gap-1 p-2 items-center cursor-pointer hover:bg-gray-100 hover:rounded-lg min-h-[44px]">
            <x-svg-icons.comment class="w-6 h-auto" />
            <span class="comment-count text-xs sm:text-sm" x-text="commentCount"></span>
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