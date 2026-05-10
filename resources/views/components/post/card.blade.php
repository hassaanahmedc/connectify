{{-- Post Component: Renders a social media post with user info, content, images, likes, and comments, using Tailwind for responsive design and Alpine.js for interactivity --}}
<div class="flex flex-col bg-white rounded-xl mt-2 border shadow-md" 
    data-post-id="{{ $post->id }}"
    x-data="{ 
        isVisible: true,
        imagesModal: false, 
        commentSection: @json($showComments ?? false), 
        post_menu: false, 
        edit_post: false, 
        confirm_delete: false, 
        expanded: @json( $showFullContent ?? false) 
    }"
    x-show="isVisible"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-95"

    @post-deleted.window="if($event.detail.id == '{{ $post->id }}') {
        isLoading = false;
        isVisible = false;
        setTimeout(() => { $el.remove() }, 300);
    }"

    x-on:keydown.escape.window="imagesModal = false"
    @click.outside="if(imagesModal) imagesModal = false">

    {{-- Header & Caption --}}
    <x-post.header :post="$post" :topics="$post->topics" />
    
    {{-- Post Images --}}
    <x-post.images :images="$post->postImages" />

    {{-- Post Actions & Comments --}}
    <x-post.actions :post="$post" />
</div>