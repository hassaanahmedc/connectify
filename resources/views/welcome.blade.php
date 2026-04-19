{{-- 
    This is the entry point of the site that user will redirected to after logging in.
    
    This view acts as a simply layout file. It is responsible for rendeting the
    middle (newsfeed) section of the page by rendering a post creation modal, Topics
    selection modal, and finally user genereted posts with topics to make up the feed..
 --}}

@extends('layouts.main')

@section('main')
    <section class="mx-auto my-0 w-11/12 min-w-80 max-w-md md:w-11/12 lg:w-full lg:max-w-lg lg:px-5 xl:px-0 xl:max-w-xl">
        {{-- Post creation modal  --}}
        <div class="pt-2" x-data="{ create_post: false }">
            <x-post-creation :topics="$topics" />
        </div>

        {{-- Topics Selecton Modal (visible if user has none selected) --}}
        @if(auth()->user()->topics->count() === 0 )
            <div class="flex flex-col gap-3 px-4 py-2 bg-white mb-6" 
                x-data="{ selectTopicsModal: false }">

                <div class="flex items-center justify-between group">
                    <div x-on:click="$dispatch('open-modal', 'selectTopicsModal')">
 
                        <span class="text-xs font-extrabold tracking-wider text-lightMode-primary">
                            Personalization
                        </span>

                        <h4 class="text-xl font-bold tracking-tight sm:truncate text-gray-900 cursor-pointer
                            group-hover:text-lightMode-primary transition-colors">
                            Customize your experience on Connectify!
                        </h5>
                        <p class="text-sm text-gray-500">
                            Pick your favorite topics to see posts that matter to you.
                        </p>
                        
                    </div>
                    <div class=" pb-1">
                        <x-svg-icons.pencil-square class="w-5 h-auto cursor-pointer 
                        text-gray-400 group-hover:text-lightMode-primary transition-all" />
                    </div>                
                </div>
                    
                <div class="relative h-[2px] w-full bg-gray-100">
                    <div class="absolute left-0 top-0 h-full w-24 bg-blue-600 rounded-full"></div>
                </div>
            </div>
        @endif
        
        {{-- Feed Post Cards  --}}
        <div class="flex flex-col" id="newsfeed">
            @forelse ($posts as $post)
                <x-post.card :post="$post" />
            @empty
                <span class="mx-auto my-10 text-lg font-semibold text-gray-500">No Posts</span>
            @endforelse
        </div>

    </section>
    
    {{-- Rendering Modal for topic selection and passing topics object  --}}
    <x-modals.topics-selection-modal :topics="$topics" />
@endsection