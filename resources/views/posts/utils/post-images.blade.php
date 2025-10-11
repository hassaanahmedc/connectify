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
                            {{ $postImages->count() - 4 }} more
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