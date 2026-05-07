@php
    // Storing images and count in php variables for easy reference.
    $images = $images ?? collect([]);
    $count = $images->count();
@endphp

@if ($count > 0)
    <div id="post-imgs" class="overflow-hidden">
        {{-- 
            DYNAMIC GRID CALCULATOR:
            - 1 Image: Full width (1 col)
            - 5 Images: 6 cols (allows for 2-over-3)
            - Others: 2 columns
        --}}
        <div class="grid gap-1 max-h-[500px] 
            {{ $count === 1 ? 'grid-cols-1' : ($count === 5 ? 'grid-cols-6' : 'grid-cols-2') }}">
            
            @foreach ($images as $index => $image)
                {{-- We are resolving image path in a variable for reusablility --}}
                @php
                    $resolved_path = str_starts_with($image->path, 'http') 
                            ? $image->path 
                            : asset('storage/' . $image->path)
                @endphp

                {{-- 
                    IMAGE SPANNING LOGIC:
                    - 5 Images: Creates a 2-over-3 collage using column spans.
                    - 3 Images: First image is tall (row-span-2) to fill the left side.
                 --}}
                <figure role="img" x-on:click.stop="imagesModal = true"
                     class="relative cursor-pointer overflow-hidden
                         @if($count === 5) 
                             {{ $index < 2 ? 'col-span-3 h-64' : 'col-span-2 h-40' }}
                         @elseif($count === 3 && $index === 0)
                             row-span-2
                         @endif">

                    <img src="{{ $resolved_path }}"
                        class="w-full h-full object-cover transition-transform duration-300 hover:scale-105"
                        alt="Post Image {{ $loop->index + 1 }}"
                        loading="lazy"
                        x-on:click.stop="
                            $dispatch('open-image-viewer', { 
                                currentImageUrl: '{{ $resolved_path }}' });
                                $nextTick(() => editCoverPicture = false);">
                </figure>
            @endforeach
        </div>
    </div>
@endif