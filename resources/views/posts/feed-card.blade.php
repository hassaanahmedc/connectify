{{-- Post Component: Renders a social media post with user info, content, images, likes, and comments, using Tailwind for responsive design and Alpine.js for interactivity --}}
<div class="flex flex-col bg-white rounded-xl mt-2 border post-shadow" 
    data-post-id="{{ $postId }}"
    x-data="{ imagesModal: false }"
    x-on:keydown.escape.window="imagesModal = false"
    @click.outside="if(imagesModal) imagesModal = false">
    {{-- Post Header: Displays user profile, name, post time, and action menu (edit/delete/pin) --}}
    <div class="px-3 sm:px-5 pt-5 pb-2">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2 sm:gap-4">
                <a href="{{ $profileUrl }}" class="min-w-[44px] min-h-[44px] flex items-center justify-center">
                    <img src="{{ $profileImageUrl }}"
                         class="bg-gray-200 w-10 h-10 rounded-full object-cover"
                         alt="User profile image">
                </a>
                <div>
                    <span class="font-bold text-xs sm:text-sm lg:text-base font-montserrat block">
                        <a href="{{ $profileUrl }}">{{ $userName }}</a>
                    </span>
                    <span class="text-gray-400 text-xs sm:text-sm inline">{{ $postTime }}</span>
                </div>
            </div>
            {{-- Post Menu: Alpine.js manages dropdown for edit, delete, and pin actions --}}
            <div x-data="{ post_menu: false, edit_post: false, confirm_delete: false }" 
                 x-on:close-modal.window="if ($event.detail.modal === 'edit_post') edit_post = false" 
                 class="relative">
                <button class="min-w-[44px] min-h-[44px] flex items-center justify-center">
                    <img src="{{ Vite::asset('public/svg-icons/3dots.svg') }}"
                         class="cursor-pointer"
                         x-on:click="post_menu = true"
                         alt="Post menu">
                </button>
                <ul x-cloak
                    x-show="post_menu"
                    @click.away="post_menu = false"
                    class="w-max flex flex-col absolute right-0 top-0 bg-white shadow-2xl rounded-md z-10">
                    @can('delete', $post)
                        <li class="py-2 px-6 hover:bg-gray-100 hover:rounded-md">
                            <button class="w-full text-left min-h-[44px] text-xs sm:text-sm" 
                                    x-on:click.prevent="confirm_delete = true">
                                Delete Post
                            </button>
                            {{-- Delete Confirmation: Renders a modal to confirm post deletion --}}
                            <x-confirm-alert :show-variable="'confirm_delete'"
                                             :message="'Are you sure you want to delete this post?'"
                                             :action="route('post.destroy', ['post' => $postId])" />
                        </li>
                    @endcan
                    @can('update', $post)
                        <li class="py-2 px-6 hover:bg-gray-100 hover:rounded-md">
                            <button class="w-full text-left min-h-[44px] text-xs sm:text-sm" 
                                    x-on:click.prevent="edit_post = true;">
                                Edit Post
                            </button>
                            {{-- Edit Modal: Loads edit form in a modal, deferred with x-teleport to avoid initialization issues --}}
                            <template x-if="edit_post">
                                <div x-show="edit_post" x-cloak>
                                    @include('posts.edit', [
                                        'showVariable' => 'edit_post',
                                        'post' => $post,
                                        'images' => $post->postImages ?? collect([]),
                                        'mode' => 'edit'
                                    ])
                                </div>
                            </template>
                        </li>
                    @endcan
                    <li class="py-2 px-6 hover:bg-gray-100 hover:rounded-md">
                        <a href="#" class="block w-full min-h-[44px] flex items-center text-xs sm:text-sm">
                            Pin to your profile
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        {{-- Post Content: Displays text content if available --}}
        <div class="my-2">
            @if ($postContent)
                <p class="text-xs sm:text-sm lg:text-base">{{ $postContent }}</p>
            @endif
        </div>
    </div>

    {{-- Image Carousel: Displays up to 4 images with flex-wrap for responsive layout, with overlay for additional images --}}
@if (($postImages ?? collect([]))->count())
        <div id="post-imgs" class="flex flex-wrap gap-1 max-w-3xl">
            @foreach ($postImages as $image)
                @if ($loop->index < 4) {{-- Limits to first 4 images for performance, shows overlay if more exist --}}
                    <figure class="relative flex-grow w-32 sm:w-40" role="img" x-on:click.stop="imagesModal = true">
                        <img 
                            src="{{ asset('storage/' . $image->path) }}"
                            class="post-image w-full h-32 sm:h-40 object-cover aspect-square"
                            alt="Post Image {{ $loop->index + 1 }}"
                            loading="lazy">
                        @if ($loop->index == 3 && $postImages->count() > 4)
                            <div 
                                class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center text-white cursor-pointer"
                                x-on:click.stop="imagesModal = true"
                                aria-label="View {{ $postImages->count() - 4 }} more images">
                                +{{ $postImages->count() - 4 }} more
                            </div>
                        @endif
                    </figure>
                @endif
            @endforeach
        </div>
        {{-- Images Modal: will be triggered when user clicks on any image in the post card" --}}
        <div aria-modal="true" role="dialog" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50"
            x-cloak x-show="imagesModal" 
            x-on:click.away="imagesModal = false"
            x-on:keydown.escape="imagesModal = false"
            @click.stop>
            <div class="bg-white p-4 rounded-lg max-w-3xl w-5/6 max-h-[80vh] overflow-y-auto relative">
                <button 
                    x-on:click.stop="imagesModal = false"
                    class="absolute top-2 right-2 bg-gray-200 hover:bg-gray-300 rounded-full w-7 h-7 flex items-center justify-center text-black font-bold transition-colors z-60"
                    aria-label="Close modal">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <div class="flex flex-col gap-2 mt-6">
                    @foreach ($postImages as $image)
                        <figure class="w-full" role="img">
                            <img 
                                src="{{ asset('storage/' . $image->path) }}"
                                class="post-image w-full h-auto max-h-screen object-cover"
                                alt="Post Image {{ $loop->index + 1 }}"
                                loading="lazy">
                        </figure>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- Likes/Comments: Toggles comment section and handles likes via AJAX --}}
    <div x-data="{ commentSection: false }" class="mx-2 px-2">
        {{-- Likes and Comment Buttons: Trigger like action and comment toggle --}}
        <div class="flex items-center gap-4 sm:gap-8 p-2">
            <button data-post-id="{{ $postId }}"
                    data-user-id="{{ auth()->id() }}"
                    class="like-btn flex gap-1 p-2 items-center cursor-pointer hover:bg-gray-100 hover:rounded-lg min-h-[44px]">
                <x-svg-icons.heart :isLiked="$post->liked_by_user" />
                <span class="like-count text-xs sm:text-sm">{{ $post->likes_count ?? 0 }}</span>
            </button>
            <button x-on:click="commentSection = true"
                    class="flex gap-1 p-2 items-center cursor-pointer hover:bg-gray-100 hover:rounded-lg min-h-[44px]">
                <x-svg-icons.comment />
                <span class="comment-count text-xs sm:text-sm"
                      data-post-id="{{ $postId }}"
                      data-user-id="{{ auth()->id() }}">{{ $post->comment_count ?? 0 }}</span>
            </button>
        </div>
        {{-- Comment Dropdown: Shows comments when toggled, loads more via AJAX --}}
        <div class="border-y-2" x-cloak x-show="commentSection" @click.away="commentSection = false">
            <div class="comments-container my-2" data-post-id="{{ $postId }}">
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
                    <button class="load-more-comments mb-2 pb-2 min-h-[44px] text-xs sm:text-sm"
                            data-post-id="{{ $postId }}"
                            data-offset="5">View more comments</button>
                </div>-
            @endif
            <div class="border-t-2">
                @include('comments.create', ['post_id' => $postId])
            </div>
        </div>
    </div>
</div>

