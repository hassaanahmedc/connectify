@push('scripts')
    @vite('resources/js/features/comments/comment.js')
    @vite('resources/js/components/likePost.js')
@endpush
{{-- Post Component: Renders a social media post with user info, content, images, likes, and comments, using Tailwind for responsive design and Alpine.js for interactivity --}}
<div class="flex flex-col bg-white rounded-xl mt-2 border post-shadow" 
    data-post-id="{{ $postId }}"
    x-data="{ imagesModal: false, commentSection: @json($showComments ?? false), 
            post_menu: false, edit_post: false, confirm_delete: false, expanded: @json( $showFullContent ?? false) }"
    x-on:keydown.escape.window="imagesModal = false"
    @click.outside="if(imagesModal) imagesModal = false">

    {{-- Header & Caption --}}
    @include('posts.utils.post-header') 
    
    {{-- Post Images --}}
    @include('posts.utils.post-images')

    {{-- Post Actions & Comments --}}
    @include('posts.utils.post-actions')
    @include('posts.utils.post-comments')
</div>