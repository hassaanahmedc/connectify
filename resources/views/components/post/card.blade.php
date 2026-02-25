@once
    @push('scripts')
        @vite('resources/js/features/comments/comment.js')
        @vite('resources/js/components/likePost.js')
    @endpush
@endonce

{{-- Post Component: Renders a social media post with user info, content, images, likes, and comments, using Tailwind for responsive design and Alpine.js for interactivity --}}
<div class="flex flex-col bg-white rounded-xl mt-2 border shadow-md" 
    data-post-id="{{ $post->id }}"
    x-data="{ 
        imagesModal: false, 
        commentSection: @json($showComments ?? false), 
        post_menu: false, 
        edit_post: false, 
        confirm_delete: false, 
        expanded: @json( $showFullContent ?? false) 
    }"

    x-on:keydown.escape.window="imagesModal = false"
    @click.outside="if(imagesModal) imagesModal = false">

    {{-- Header & Caption --}}
    <x-post.header :post="$post" />
    
    {{-- Post Images --}}
    <x-post.images :images="$post->postImages" />

    {{-- Post Actions & Comments --}}
    <x-post.actions :post="$post" />
    <x-post.comments :post="$post" />
</div>