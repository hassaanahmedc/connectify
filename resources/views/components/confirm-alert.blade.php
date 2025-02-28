<div x-cloak
    x-show="{{ $showVariable }}"
    class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="bg-white p-4 rounded-md shadow-md">
        <p>{{ $message }}</p>
        <div class="flex justify-between mt-4">
            <button type="button"
                data-comment-id="{{ $commentId ?? '' }}"
                x-on:click="{{ $showVariable }} = false"
                class="confirmDeleteBtn bg-red-500 text-white px-4 py-2 rounded-md">Delete</button>
            <button x-on:click="{{ $showVariable }} = false"
                class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancel</button>
        </div>
    </div>
</div>
