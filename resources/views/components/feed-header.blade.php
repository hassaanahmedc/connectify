@props([
    'context',
    'title',
    'count' => 0, 
    'icon' => 'trending',
    'label' => 'results'
])

<div class="bg-white mb-6 flex flex-col gap-3 px-4 py-2">
    <div class="flex items-center gap-2">
        <div class="flex h-6 w-6 items-center justify-center rounded-md bg-blue-50">
            {{-- Icon can change based on the page: Trending, Search, or Compass --}}
            @switch($icon)
                @case('search')
                    <x-svg-icons.magnifying-glass class="w-5 text-lightMode-blueHighlight" />
                    @break
                @case('explore')
                    <x-svg-icons.search class="w-5 text-lightMode-blueHighlight" />
                    @break
                @default
                <x-svg-icons.trending class="w-5 text-lightMode-blueHighlight" />
            @endswitch
        </div>
        <span class="text-xs font-bold tracking-wider text-gray-400">
            {{ $context }}
        </span>
    </div>
    
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-2 sm:pb-1">
        <div class="flex-1 min-w-0">
            <h1 class=" text-2xl font-bold tracking-tight truncate text-gray-900">
                {{ $title }}
            </h1>
        </div>
        
        <div class="flex items-center gap-2 pb-1">
            <span class="text-xs font-bold text-gray-900">{{ $count }}</span>
            <span class="text-xs font-medium text-gray-500  tracking-tighter">{{ $label }}</span>
        </div>
    </div>
    
    <div class="relative h-[2px] w-full bg-gray-100">
        <div class="absolute left-0 top-0 h-full w-24 bg-lightMode-blueHighlight rounded-full"></div>
    </div>
</div>