<div class="py-2" 
    x-data="{ showDeleteModal: false }">
    <div class="flex gap-2">
        <div class="w-8 h-8 flex-shrink-0">
            <img src="{{ $comment->user->avatar_url}}"
                class="bg-gray-200 rounded-full object-cover w-full h-full"
                loading="lazy"  
                alt="">
        </div>
        <div class="group relative bg-gray-100 flex-1 rounded-lg px-3 py-2">
            <span class="text-sm font-bold">{{ $comment->user->fname }}
                {{ $comment->user->lname }}</span>
            
            <!-- Comment content display -->
            <div class="comment-container">
                <span class="text-sm comment-content">{{ $comment->content }}</span>
                
                <!-- Inline edit form (hidden by default) -->
                <div class="edit-form mt-1" style="display: none;">
                    <textarea class="w-full p-1 border rounded-md text-sm" x-model="content">{{ $comment->cotent }}</textarea>
                        <div class="flex justify-end mt-1 space-x-2">
                        <button type="button" 
                            class="cancel-edit-btn text-xs px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">
                            Cancel
                        </button>
                        <button type="button" 
                            class="save-comment-btn text-xs px-2 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Save
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center justify-between">
                <span
                    class="text-xs text-gray-500 mt-2">{{ $comment->created_at->diffForHumans() }}</span>
                <div class="relative">
                    <x-svg-icons.ellipsis-vertical class="w-6 h-6 cursor-pointer hidden group-hover:block " 
                        x-on:click="post_menu = true" />
                    <ul class="comment-menu hidden w-max flex flex-col absolute right-0 top-0 bg-white shadow-2xl rouded-md z-10">
                            @can('delete', $comment)
                            <li class="py-2 px-6 hover:bg-gray-100 hover:rounded-md">
                                <button 
                                    class="delete-comment-btn" 
                                    @click="showDeleteModal = true">
                                    Delete Comment
                                </button>
                            </li>
                        @endcan
                        @can('update', $comment)
                            <li class="py-2 px-6 hover:bg-gray-100 hover:rounded-md">
                                <button type="button" class="edit-comment-btn">
                                    Edit Comment
                                </button>
                            </li>
                        @endcan
                        <li class="py-2 px-6 hover:bg-gray-100 hover:rounded-md">
                            <a href="#" class="pin-comment-btn">Pin this comment</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Using the reusable confirm-alert component instead of inline modal -->
    @if(Auth::check() && Auth::user()->can('delete', $comment))
        <x-confirm-alert 
            :show-variable="'showDeleteModal'" 
            :message="'Are you sure you want to delete this comment?'" 
            :comment-id="$comment->id" />
    @endif
</div>