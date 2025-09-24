{{-- Post Header: Displays user profile, name, post time, and action menu (edit/delete/pin) --}}
<div class="px-3 sm:px-5 pt-5 pb-2">
    <div class="flex justify-between items-center gap-3">
        <div class="flex items-center gap-3 min-w-0">
            <a href="{{ $profileUrl }}" class="w-11 h-11 flex-shrink-0 rounded-full overflow-hidden" 
                aria-label="View profile of {{ $userName }}">
                <img src="{{ $profileImageUrl }}"
                     class="w-full h-full object-cover"
                     alt="{{ $userName }}'s profile photo">
            </a>

            <div class="min-w-0">
                <a href="{{ $profileUrl }}" class="block text-sm font-semibold leading-tight break-words hover:underline">
                    {{ $userName }}
                </a>
                <time datetime="" class="text-xs text-gray-400 block">{{ $postTime }}</time>
            </div>
        </div>
        {{-- Post Menu: Alpine.js manages dropdown for edit, delete, and pin actions --}}
        <div  
             x-on:close-modal.window="if ($event.detail.modal === 'edit_post') edit_post = false" 
             class="relative">
            <button class="w-11 h-11 rounded-full flex items-center justify-center hover:bg-gray-100 focus:outline-none"
                    :aria-expanded="post_menu"
                    aria-haspopup="true"
                    aria-label="Open post menu">
                <img src="{{ Vite::asset('public/svg-icons/3dots.svg') }}"
                     class="cursor-pointer"
                     x-on:click="post_menu = true"
                     alt="Post menu">
            </button>
            <ul x-cloak
                x-transition
                x-show="post_menu"
                @click.outside="post_menu = false"
                aria-label="Post actions"
                class="w-max flex flex-col absolute right-0 top-0 bg-white shadow-2xl rounded-md z-10">
                @can('delete', $post)
                    <li role="menuitem" class="px-2">
                        <button class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100" 
                                @click.prevent="confirm_delete = true;">
                            Delete Post
                        </button>
                        {{-- Delete Confirmation: Renders a modal to confirm post deletion --}}
                        <x-confirm-alert :show-variable="'confirm_delete'"
                                         :message="'Are you sure you want to delete this post?'"
                                         :action="route('post.destroy', ['post' => $postId])" />
                    </li>
                @endcan

                @can('update', $post)
                    <li role="menuitem" class="px-2">
                        <button class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100" 
                                @click.prevent="edit_post = true;">
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
                <li class="px-6 py-2 hover:bg-gray-200">
                    <a href="#" class="w-full text-left text-xs sm:text-sm">
                        Pin to your profile
                    </a>
                </li>
            </ul>
        </div>
    </div>
    {{-- Post Content: Displays text content if available --}}
<div class="my-2" >

    @if($postContent)
        <p class="text-xs sm:text-sm lg:text-base">
            <span x-text="expanded ? @js($postContent) : '{{ Str::limit($postContent, 300, '...') }}'"></span>
        </p>

        @if(strlen($postContent) > 300)
            <button x-on:click="expanded = !expanded" 
                    class="mt-2 text-sm font-medium hover:underline text-blue-600">
                    <span x-text="expanded ? '<Show less' : 'Read more'"></span>
            </button>
        @endif
    @endif
</div>
</div>