<div class="py-2" 
    x-data="{ 
        showDeleteModal: false, 
        commentMenu: false, 
        isEditing:false,
        isVisible: true,
        isLoading: false,
        originalContent: '{{ addslashes($comment->content) }}',
        editedContent: '{{ addslashes($comment->content) }}',
    }"
    @comment-updated.window="if($event.detail.id == '{{ $comment->id }}') {
        isLoading = false;
        showDeleteModal = false;
        originalContent = $event.detail.newContent;
        isEditing = false;
    }"
    @execute-confirmed-action.window="
        if($event.detail.actionType === 'delete-comment' && $event.detail.itemId == '{{$comment->id}}') {
            isLoading = true;
            deleteComment($event.detail.itemId);
        }
    "
    @comment-deleted.window="if($event.detail.id == '{{ $comment->id }}') {
        showDeleteModal = false;
        isLoading = false;
        isVisible = false;
        setTimeout(() => { if ($el) $el.remove() }, 300);
    }">
    <div class="flex gap-2" x-show="isVisible">
        <div class="w-8 h-8 flex-shrink-0 md:w-10 md:h-10">
            <img src="{{ $comment->user->avatar_url}}"
                class="bg-gray-200 rounded-full object-cover w-full h-full"
                loading="lazy"  
                alt="">
        </div>
        <div class="group relative bg-gray-100 flex-1 min-w-0 rounded-lg px-3 py-2">
            <span class="text-sm font-bold">{{ $comment->user->fname }}
                {{ $comment->user->lname }}</span>
            
            <!-- Comment content display -->
            <div class="comment-container">
                <span x-show="!isEditing" 
                    x-text="originalContent" 
                    class="text-sm break-all leading-tight block">{{ $comment->content }}</span>
                
                <!-- Inline edit form (hidden by default) -->
                <div class="edit-form mt-1" x-cloak x-show="isEditing"
                    @keydown.escape="isEditing = false">
                    <textarea x-model="editedContent" 
                        class="w-full p-1 border rounded-md text-sm">{{ $comment->content }}</textarea>
                        <div class="flex justify-end mt-1 space-x-2">
                            <button type="button" @click="isEditing=false"
                                class="cancel-edit-btn text-xs px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">
                                Cancel
                            </button>
                            <button type="button" 
                                @click="isLoading = true; updateComment('{{$comment->id}}', originalContent, editedContent)"
                                class=" text-xs px-2 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                                <span x-cloak x-show="!isLoading">Save</span>
                                <span x-cloak x-show="isLoading">Saving...</span>
                            </button>
                        </div>
                </div>
            </div>
            
            <div class="flex items-center justify-between">
                <span
                    class="text-xs text-gray-500 mt-2">{{ $comment->created_at->diffForHumans() }}</span>
                @if($comment->user->id === auth()->user()->id)
                    <div class="relative">
                        <x-svg-icons.ellipsis-vertical 
                            class="w-6 h-6 cursor-pointer md:hidden md:group-hover:block" 
                            @click="commentMenu = !commentMenu" @click.outside="commentMenu = false" />
                            
                        <ul x-cloak x-show="commentMenu"
                            class="w-48 flex flex-col absolute right-0 top-0 bg-white shadow-xl border border-gray-100 rounded-xl z-10 p-1.5">
                                @can('delete', $comment)
                                <li role="menuitem">
                                    <button class="w-full flex items-center gap-3 px-3 py-2 text-sm font-medium 
                                    text-red-600 hover:bg-red-50 rounded-lg transition-colors" 
                                        x-on:click.prevent="$dispatch('open-modal', {
                                                name: 'confirm_action',
                                                title: 'Are you sure?',
                                                message: 'Your comment on this post will be removed forever.',
                                                actionType: 'delete-comment',
                                                itemId: '{{ $comment->id }}',
                                                confirmButtonText: 'Delete', 
                                            })">
                                        <x-svg-icons.trash class="w-5 h-5 text-red-500" />
                                        Delete Comment
                                    </button>
                                </li>
                            @endcan
                            @can('update', $comment)
                                <li role="menuitem">
                                    <button class="w-full flex items-center gap-3 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-blue-50 rounded-lg transition-colors" 
                                        type="button" @click="isEditing=true">
                                        <x-svg-icons.pencil-square class="w-5 h-5 text-gray-500" />
                                        Edit Comment
                                    </button>
                                </li>
                            @endcan
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>