{{--
  This partial is responsible for rendering the feed of posts on a user's
  profile page. It includes the post creation component and iterates through
  the user's posts, rendering a 'feed-card' for each one.
--}}

<div class="w-full max-w-2xl px-4 md:w-1/2 md:px-0 lg:w-2/4">

    <section class="">

        <div class="w-full rounded-t-lg border-b-2 border-b-lightMode-primary bg-white py-2 text-center">
            <span class="text-lg font-semibold md:text-xl lg:text-xl">Following</span>
        </div>

        <div class="pt-2" x-data="{ create_post: false }">
            <x-post-creation :topics="$topics" />
        </div>

        <div class="flex flex-col" id="newsfeed">
            @forelse ($followingList as $followingUsers)
                @include('profile.user-card', [ 'user' => $followingUsers ])
            @empty
                <span class="mx-auto my-10 text-lg font-semibold text-gray-500">No results found.</span>
            @endforelse
        </div>

    </section>
</div>
