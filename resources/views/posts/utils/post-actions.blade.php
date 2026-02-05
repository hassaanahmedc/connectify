{{-- Likes and Comment Buttons: Trigger like action and comment toggle --}}
<div class="flex items-center gap-4 sm:gap-8 p-2 mx-2 px-2">
    {{-- Like Button --}}
    <button data-post-id="{{ $postId }}"
            data-user-id="{{ auth()->id() }}"
            class="like-btn flex gap-1 p-2 items-center cursor-pointer hover:bg-gray-100 hover:rounded-lg min-h-[44px]">
        <x-svg-icons.heart class="like-icon {{ $isLiked ? 'liked-icon' : 'default-svg-color' }}" />
        <span class="like-count text-xs sm:text-sm">{{ $post->likes_count ?? 0 }}</span>
    </button>
    {{-- Comments Button --}}
    <button x-on:click="commentSection = true"
            class="flex gap-1 p-2 items-center cursor-pointer hover:bg-gray-100 hover:rounded-lg min-h-[44px]">
        <x-svg-icons.comment />
        <span class="comment-count text-xs sm:text-sm"
              data-post-id="{{ $postId }}"
              data-user-id="{{ auth()->id() }}">{{ $post->comment_count ?? 0 }}</span>
    </button>
</div>