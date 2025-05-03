{{-- resources/views/posts/feed-card.blade.php --}}
<div class="flex flex-col bg-white rounded-xl mt-2 shadow-[0px_10px_34px_-15px_rgba(0,0,0,0.10)] border" 
    data-post-id="{{ $postId }}">
    {{-- Card Content --}}
    <div class="px-5 pt-5 pb-2">
        {{-- Header: User Info and Edit Button --}}
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="{{ $profileUrl }}"><img src="{{ $profileImageUrl }}"
                        class="bg-gray-200 w-10 h-10 rounded-full object-cover"
                        alt=""></a>
                <div>
                    <span class="font-bold/[1px] text-base/[1rem] font-montserrat block"><a
                            href="{{ $profileUrl }}">{{ $userName }}</a></span>
                    <span class="text-gray-400 text-sm inline">{{ $postTime }}</span>
                </div>
            </div>
            <div x-data="{ post_menu: false, edit_post: false, confirm_delete: false }" class="relative">
                <img src="{{ Vite::asset('public/svg-icons/3dots.svg') }}"
                    class="cursor-pointer"
                    x-on:click="post_menu = true"
                    alt="">
                <ul x-cloak
                    x-show="post_menu"
                    @click.away="post_menu = false"
                    class="w-max flex flex-col absolute right-0 top-0 bg-white shadow-2xl rounded-md z-10">
                    @can('delete', $post)
                        <li class="py-2 px-6 hover:bg-gray-100 hover:rounded-md">
                            <button class="w-full text-left" x-on:click.prevent="confirm_delete = true">
                                Delete Post
                            </button>
                            <x-confirm-alert :show-variable="'confirm_delete'"
                                :message="'Are you sure you want to delete this post?'"
                                :action="route('post.destroy', ['post' => $postId])" />
                        </li>
                    @endcan
                    @can('update', $post)
                        <li class="editBtn py-2 px-6 hover:bg-gray-100 hover:rounded-md">
                            <button class="w-full text-left" x-on:click.prevent="edit_post = true;">
                                Edit Post
                            </button>
                            @include('posts.edit', [
                                'showVariable' => 'edit_post',
                                'post' => $post,
                                'postImages' => $postImages ?? collect([]),
                            ])
                        </li>
                    @endcan
                    <li class="py-2 px-6 hover:bg-gray-100 hover:rounded-md">
                        <a href="#" class="block w-full">Pin to your profile</a>
                    </li>
                </ul>
            </div>
        </div>
        {{-- Post Content --}}
        <div class="my-2">
            @if ($postContent)
                <p>{{ $postContent }}</p>
            @endif
        </div>
    </div>
    {{-- Image Container --}}
    @if (($postImages ?? collect([]))->count())
        <div>
            @foreach ($postImages as $image)
                <img src="{{ asset('storage/' . $image->path) }}"
                    class="postedImg w-full h-full object-cover"
                    alt="Post Image">
            @endforeach
        </div>
    @endif
    {{-- Like and Comment Section --}}
    <div x-data="{ commentSection: false }" class="mx-2 px-2">
        <div class="flex items-center gap-8 p-2">
            <button data-post-id="{{ $postId }}"
                data-user-id="{{ auth()->id() }}"
                class="like-btn flex gap-1 p-2 items-center cursor-pointer hover:bg-gray-100 hover:rounded-lg">
                <x-svg-icons.heart :isLiked="$post->liked_by_user ?? false" />
                <span class="like-count">{{ $post->likes_count ?? 0 }}</span>
            </button>
            <button x-on:click="commentSection = true"
                class="flex gap-1 p-2 items-center cursor-pointer hover:bg-gray-100 hover:rounded-lg">
                <x-svg-icons.comment />
                <span class="comment-count"
                    data-post-id="{{ $postId }}"
                    data-user-id="{{ auth()->id() }}">{{ $post->comment_count ?? 0 }}</span>
            </button>
        </div>
        {{-- Comment Dropdown --}}
        <div x-cloak
            x-show="commentSection"
            @click.away="commentSection = false"
            class="border-y-2">
            <div class="comments-container my-2" data-post-id="{{ $postId }}">
                @if (($comments ?? collect([]))->count())
                    @include('comments.index', ['comments' => $comments])
                @endif
            </div>
            @if (($post->comment_count ?? 0) > 5)
                <div class="text-center text-gray-500">
                    <button class="load-more-comments mb-2 pb-2"
                        data-post-id="{{ $postId }}"
                        data-offset="5">View more comments</button>
                </div>
            @endif
            <div class="border-t-2">
                @include('comments.create', ['post_id' => $postId])
            </div>
        </div>
    </div>
</div>