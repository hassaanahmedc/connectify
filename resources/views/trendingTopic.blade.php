@extends('layouts.main')

@section('main')
    <section class="mx-auto my-0 w-11/12 min-w-80 max-w-md py-6 md:w-11/12 lg:w-full lg:max-w-lg lg:px-5 
        xl:max-w-xl xl:px-0">

<div class="bg-white mb-6 flex flex-col gap-3 px-4 py-2">
    <div class="flex items-center gap-2">
        <div class="flex h-6 w-6 items-center justify-center rounded-md bg-blue-50">
            {{-- Icon can change based on the page: Trending, Search, or Compass --}}
            <x-svg-icons.trending class="w-5 text-lightMode-blueHighlight" />
        </div>
        <span class="text-xs font-bold tracking-wider text-gray-400">
            Trending Topic
        </span>
    </div>
    
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-2 sm:pb-1">
        <div class="flex-1">
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">
                #{{ request()->route('topic')->name }}
            </h1>
        </div>
        
        <div class="flex items-center gap-2 pb-1">
            <span class="text-xs font-bold text-gray-900">56</span>
            <span class="text-xs font-medium text-gray-500  tracking-tighter">posts</span>
        </div>
    </div>
    
    <div class="relative h-[2px] w-full bg-gray-100">
        <div class="absolute left-0 top-0 h-full w-24 bg-lightMode-blueHighlight rounded-full"></div>
    </div>
</div>

        {{-- Post Card --}}
        <div class="flex flex-col" id="newsfeed">
            @forelse ($topic_posts as $post)
                <x-post.card :post="$post" />
            @empty
                <span class="mx-auto my-10 text-lg font-semibold text-gray-500">No Posts</span>
            @endforelse
        </div>

    </section>
@endsection
