<div class="mb-2 rounded-xl bg-white px-4 py-2 shadow-sm">
    <div class="flex gap-4 md:gap-6">
        <div class="flex-shrink-0">
            <img alt="" class="h-auto w-9 rounded-full bg-gray-200 object-cover"
                src="{{ Auth::user()->avatar_url }}">
        </div>

        <div class="flex-1">
            <div @click="
                    $dispatch('open-modal', 'post-modal');
                    $dispatch('fill-post-data', { isEdit: false });"> 
                <div class="cursor-pointer rounded-full border px-4 py-2 text-gray-500">
                    Share something...
                </div>
            </div>
        </div>
    </div>
</div>

<x-modals.post-modal :topics="$topics" />