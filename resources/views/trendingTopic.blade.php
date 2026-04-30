
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
        <div class="flex flex-col" x-data="infiniteScroll('{{ $topic_posts->nextPageUrl() }}')">
            @forelse ($topic_posts as $post)
                <x-post.card :post="$post" />
            @empty
                <span class="mx-auto my-10 text-lg font-semibold text-gray-500">No Posts</span>
            @endforelse

            <div x-ref="sentinal" class=" py-8 w-full flex  justify-center items-center">
                <template x-if="isLoading" class="">
                    <x-svg-icons.loading class="w-7 h-auto animate-spin" />
                </template>

                <template x-if="!hasMore && !isLoading">
                    <p class="text-gray-400 text-sm">You've caught up for today...</p>
                </template>
            </div>
        </div>

    </section>
@endsection
