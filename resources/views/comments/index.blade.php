@forelse($comments as $comment)
    <div class="py-2" 
        data-comment-id="{{ $comment->id }}"
        x-data="{ showDeleteModal: false }">
        <div class="flex gap-2">
            <div class="w-8 h-8 flex-shrink-0">
                <img src="{{ $comment->user->avatar ?? 'https://placewaifu.com/image/200' }}"
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
                        <textarea id="content-{{ $comment->id }}" class="w-full p-1 border rounded-md text-sm">{{ $comment->content }}</textarea>
                        <div class="flex justify-end mt-1 space-x-2">
                            <button type="button" 
                                class="cancel-edit-btn text-xs px-2 py-1 bg-gray-200 rounded hover:bg-gray-300"
                                data-comment-id="{{ $comment->id }}">
                                Cancel
                            </button>
                            <button type="button" 
                                class="save-comment-btn text-xs px-2 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700"
                                data-comment-id="{{ $comment->id }}">
                                Save
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <span
                        class="text-xs text-gray-500 mt-2">{{ $comment->created_at->diffForHumans() }}</span>
                    <div class="relative">
                        <img src="{{ Vite::asset('/public/svg-icons/3dots.svg') }}"
                            class="cursor-pointer rotate-90 hidden group-hover:block three-dots"
                            data-comment-id="{{ $comment->id }}"
                            alt="">
                        <ul class="comment-menu hidden w-max flex flex-col absolute right-0 top-0 bg-white shadow-2xl rounded-md z-10">
                            @can('delete', $comment)
                                <li class="py-2 px-6 hover:bg-gray-100 hover:rounded-md">
                                    <button 
                                        class="delete-comment-btn" 
                                        data-comment-id="{{ $comment->id }}"
                                        @click="showDeleteModal = true">
                                        Delete Comment
                                    </button>
                                </li>
                            @endcan
                            @can('update', $comment)
                                <li class="py-2 px-6 hover:bg-gray-100 hover:rounded-md">
                                    <button type="button" class="edit-comment-btn" data-comment-id="{{ $comment->id }}">
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
@empty
    <div>No Comments</div>
@endforelse

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle edit button clicks
    document.querySelectorAll('.edit-comment-btn').forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.dataset.commentId;
            toggleEditMode(commentId, true);
            
            // Close the dropdown menu if it's open
            const dropdown = this.closest('[x-data]');
            if (dropdown && dropdown.__x) {
                dropdown.__x.$data.comment_menu = false;
            }   
        });
    });
    
    // Handle cancel button clicks
    document.querySelectorAll('.cancel-edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.dataset.commentId;
            toggleEditMode(commentId, false);
        });
    });
    
    // Handle comment edit form submission
    document.querySelectorAll('.save-comment-btn').forEach(button => {
        button.addEventListener('click', async function(event) {
            await updateComment(event);
        });
    });
});
</script>
@endpush
