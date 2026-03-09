
@extends('layouts.main')

@section('main')
    <section class="mx-auto my-0 w-11/12 min-w-80 max-w-md py-6 md:w-11/12 lg:w-full lg:max-w-lg lg:px-5 
        xl:max-w-xl xl:px-0">

        <x-feed-header 
            :context="$header_data['context']"
            :title="$header_data['title']" 
            :count="$header_data['count']"
            :label="$header_data['label']"
            icon="trending"
        />

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
