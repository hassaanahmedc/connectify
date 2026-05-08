{{--
  This partial is responsible for rendering the feed of posts on a user's
  profile page. It includes the post creation component and iterates through
  the user's posts, rendering a 'feed-card' for each one.
--}}

<section class="w-full max-w-2xl px-4 md:w-1/2 md:px-0 lg:w-2/4">

    <div class="w-full rounded-t-lg border-b-2 border-b-lightMode-primary bg-white py-2 text-center">
        <span class="text-lg font-semibold md:text-xl lg:text-xl">Posts</span>
    </div>

    @if($user->id === auth()->user()->id)
        <div class="pt-2" x-data="{ create_post: false }">
            <x-post-creation :topics="$topics" />
        </div>
    @endif

    <div class="flex flex-col" x-data="infiniteScroll('{{ $user->post->nextPageUrl() }}', null)">
        @forelse ($user->post as $post)
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
