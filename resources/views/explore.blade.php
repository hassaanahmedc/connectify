@extends('layouts.main')

@section('main')
    {{-- The section stays centered and responsive --}}
    <section class="mx-auto my-0 w-11/12 min-w-80 max-w-md md:w-11/12 lg:w-full lg:max-w-lg lg:px-5 xl:max-w-xl xl:px-0 py-6">
            <x-feed-header 
                :context="$header_data['context']" 
                :title="$header_data['title']" 
                :count="$header_data['count']"
                :label="$header_data['label']" 
                icon="explore"    
            />

        {{-- GAP-4 creates the space between the individual cards --}}
        <div class="flex flex-col gap-2" x-data="infiniteScroll('{{ $results->nextPageUrl() }}')">
            @if ($results->isNotEmpty())
                @forelse ($results as $user)
                    <x-user-card :user="$user" />
                @empty
                    <span class="mx-auto my-10 text-lg font-semibold text-gray-500">No More Users.</span>
                @endforelse

                <div x-ref="sentinal" class=" py-8 w-full flex  justify-center items-center">
                    <template x-if="isLoading" class="">
                        <x-svg-icons.loading class="w-7 h-auto animate-spin" />
                    </template>

                    @if($results->count() >= 15)
                        <template x-if="!hasMore && !isLoading">
                            <p class="text-gray-400 text-sm">You've caught up for today...</p>
                        </template>
                    @endif

                </div>
            @endif
        </div>

    </section>
@endsection