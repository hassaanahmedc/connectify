@forelse($comments as $comment)
    <div class="py-2"
        data-commentId="{{ $comment->id }}">
        <div class="flex gap-2">
            <div class="w-8 h-8 flex-shrink-0">
                <img src="https://placewaifu.com/image/200"
                    class="bg-gray-200 rounded-full object-cover w-full h-full"
                    loading="lazy"
                    alt="">
            </div>
            <div class="group relative bg-gray-100 flex-1 rounded-lg px-3 py-2">

                <span class="text-sm font-bold">{{ $comment->user->fname }}
                    {{ $comment->user->lname }}</span>
                <span class="text-sm">{{ $comment->content }}</span> <br>
                <div class="flex items-center justify-between">
                    <span
                        class="text-xs text-gray-500 mt-2">{{ $comment->created_at->diffForHumans() }}</span>
                    <div x-data="{
                        comment_menu: false,
                        edit_comment: false,
                        confirm_delete: false,
                    }"
                        class="relative ">
                        <img src="{{ Vite::asset('/public/svg-icons/3dots.svg') }}"
                            class="cursor-pointer rotate-90 hidden group-hover:block"
                            x-on:click="comment_menu = true"
                            alt="">
                        <ul x-cloak
                            x-show="comment_menu"
                            @click.away="comment_menu = false"
                            class="w-max flex flex-col absolute right-0 top-0 bg-white shadow-2xl rounded-md z-10">

                            @can('delete', $comment)
                                <li
                                    class="py-2 px-6 hover:bg-gray-100 hover:rounded-md">

                                    <button class="deleteBtn"
                                        x-on:click.prevent="confirm_delete = true">
                                        Delete Comment</button>
                                    @include(
                                        'components.confirm-alert',
                                        [
                                            'showVariable' =>
                                                'confirm_delete',
                                            'message' =>
                                                'Are you sure you want to delete this comment?',
                                            'commentId' => $comment->id,
                                        ]
                                    )
                                </li>
                            @endcan
                            @can('update', $comment)
                                <li
                                    class="editBtn py-2 px-6 hover:bg-gray-100 hover:rounded-md">
                                    <a href="#"
                                        id="editBtn"
                                        x-on:click.prevent="edit_comment = true">Edit
                                        Comment</a>
                                    @include('posts.create', [
                                        'showVariable' => 'edit_comment',
                                        'isEdit' => true,
                                        'postUrl' => route('post.update', [
                                            'post' => $postId,
                                        ]),
                                        'submitBtnName' => 'Edit Post',
                                        'postImages' => $postImages,
                                    ])
                                </li>
                            @endcan

                            <li
                                class="py-2 px-6 hover:bg-gray-100 hover:rounded-md">
                                <a href="#"
                                    x-on:click="edit_comment = false">Pin this
                                    comment</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@empty
    <div>No Comments</div>
@endforelse
