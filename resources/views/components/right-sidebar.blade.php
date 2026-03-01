<aside class="hidden w-72 min-w-0 overflow-hidden border-l bg-white lg:block xl:w-80">
    <div class="sticky py-4">
        {{-- Dynamic container for Online friends or Search Filters based on page --}}
        {{ $upperContainer }}
        {{-- Static container for trending topics --}}
        <div class="mt-4" id="trending-container">
            <div>
                {{-- Refined header to match the Suggested Friends style --}}
                <div class="flex items-center justify-between px-6 mb-2">
                    <h5 class="mb-2  text-xs font-extrabold uppercase tracking-widest text-zinc-400">What's Trending?
                    </h5>
                </div>

                <div class="w-full flex flex-wrap gap-2 px-6">
                    {{-- Repeatable Trend Row --}}
                    @foreach ($topics as $topic)
                        <a class="break-words rounded-full border border-lightMode-blueHighlight 
                                bg-blue-50/30 px-2 py-1 text-xs font-semibold text-lightMode-blueHighlight 
                                shadow-sm transition-colors duration-200 hover:bg-opacity-10"
                            href="">{{ $topic->name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</aside>
