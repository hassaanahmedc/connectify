<div x-cloak
    x-show="{{ $showVariable }}"
    @click.away="{{ $showVariable }} = false"
    class="delete-comment-modal fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
    <div class="bg-white p-4 rounded-md shadow-md" @click.stop>
        <p>{{ $message }}</p>
        <div class="flex justify-between mt-4">
            @if(isset($action))
                <form method="POST" action="{{ $action }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="confirm-delete-btn bg-red-500 text-white px-4 py-2 rounded-md">Delete</button>
                </form>
            @else
                <button type="button"
                    data-comment-id="{{ $commentId ?? '' }}"
                    x-on:click="{{ $showVariable }} = false;  
                    const event = new CustomEvent('comment-delete-confirmed', { 
                            detail: { commentId: '{{ $commentId ?? '' }}' } 
                        });
                        document.dispatchEvent(event);"
                    class="confirm-delete-btn bg-red-500 text-white px-4 py-2 rounded-md">Delete</button>
            @endif
            <button x-on:click="{{ $showVariable }} = false"
                class="cancel-delete-btn bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
        </div>
    </div>
</div>
