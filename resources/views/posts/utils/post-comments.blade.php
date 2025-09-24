<div class="border-y-2 mx-2 px-2" x-cloak x-show="commentSection" @click.away="commentSection = false">
    <div class="comments-container " data-post-id="{{ $postId }}">
        {{-- Renders comments if available --}}
        @if ($comments->count())
            @include('comments.index', [
                'comments' => $comments,
            ])
        @endif
    </div>
    {{-- Load More Comments: Fetches additional comments via AJAX if count exceeds 5 --}}
    @if (($post->comment_count ?? 0) > 5)
        <div class="text-center text-gray-500">
            <button class="load-more-comments  min-h-[44px] text-xs sm:text-sm"
                    data-post-id="{{ $postId }}"
                    data-offset="5">View more comments</button>
        </div>
    @endif
    <div class="border-t-2">
        @include('comments.create', ['post_id' => $postId])
    </div>
</div>