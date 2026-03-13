{{-- 
    This partial renders the sidebar of the main profile page which
    includes user details like profile states, avatar and triggers edit user
    details modal,

--}}

<div class="z-10 -mt-20 w-full max-w-md px-4 md:w-1/3 md:px-0 lg:w-1/3">

    <section class="flex flex-col items-center justify-center rounded-lg bg-white px-5 py-4 shadow-md"
        id="user-profile-card">

        {{-- 
            This is the main Alpine component elemennt that manages the state 
            of sidebar. 
            - We close 'editProfileModal' if user clicks outside of it,
            - we are listening for global window event (profile-image-slected)
              to receive the URL to preview image inside the modal. 
        --}}
        <div @close-profile-modal.window="editProfileModal = false;"
            @profile-image-selected.window="
                previewUrl = $event.detail.previewImage;
                editProfileModal = true;"
            x-data="{ editProfilePicture: false, editProfileModal: false, previewUrl: '' }">

            <figure class="relative w-36 rounded-full bg-black">
                @auth
                    @if ($isOwnProfile)
                    {{-- 
                        The main Profile picture, It is only interactive for the profile owner.
                        On click, triggers the dropdown to view, edit and delete the image.
                    --}}
                        <img @click="editProfilePicture = true" alt=""
                            class="profile-picture-display aspect-square h-full w-full cursor-pointer rounded-full object-cover transition-opacity ease-in-out hover:opacity-70"
                            id="profile-picture" src="{{ $user->avatar_url }}">
                    @else

                    {{-- For other users, the profile image is not interactive.. --}}
                        <img alt="" class="aspect-square h-full w-full rounded-full object-cover"
                            src="{{ $user->avatar_url }}">
                    @endif
                @endauth
            </figure>

            {{-- 
                The Dropdown Menu for Profile image.
                - It is controlled by 'editProfilePicture' state.
                - It closes if the user clicks outside of it,
            --}}
            <ul @click.outside="editProfilePicture = false" class="absolute mt-1 rounded-lg border bg-white shadow-md"
                x-cloak x-show="editProfilePicture">

                 {{-- This list item serves as a proxy to trigger the hidden file input. --}}
                <li class="m-2 cursor-pointer px-4 py-1 hover:bg-gray-100" id="upload-profile-picture">
                    Upload new photo</li>
                <input hidden id="select-profile-picture" type="file">

                @if ($user->avatar)

                    {{-- This dispatches detailed event to open generic confirmation modal. --}}
                    <li class="m-2 cursor-pointer px-4 py-1 hover:bg-gray-100" id="remove-profile-picture"
                        x-on:click.prevent="$dispatch('open-modal', {
                            name: 'confirm_action',
                            title: 'Are you sure?',
                            message: 'Your profile picture will be replaced by the default avatar',
                            actionType: 'profile_picture',
                            itemId: null,
                            confirmButtonText: 'Delete', 
                        })">
                        Remove photo</li>
                @endif

                {{-- This dispatches an event to open the global image viewer. --}}
                <li class="m-2 cursor-pointer px-4 py-1 hover:bg-gray-100" id="view-profile-picture"
                    x-on:click.stop="
                        $dispatch('open-image-viewer', { currentImageUrl: '{{ $user->avatar_url }}' });
                        $nextTick(() => editProfilePicture = false);">
                    View photo</li>
            </ul>

        </div>

        <div class="text-center">
            <h1 class="my-3 font-semibold md:text-2xl lg:text-3xl">
                {{ $user->fname }}
                {{ $user->lname }}</h1>
            @if ($user->bio !== null)
                <span class="text-sm text-lightMode-text md:text-base lg:text-base">{{ $user->bio }}</span><br>
            @endif
            @if ($user->location !== null)
                <div class="my-3 text-lightMode-text">
                    <span class="">From <span class="font-semibold">{{ $user->location }}</span></span>
                </div>
            @endif
        </div>

        <div class="my-2 flex w-full flex-wrap gap-2 text-center text-sm md:text-base lg:flex-nowrap lg:text-base"
            x-data="{ edit_profile_details: false }">

            @auth
                @if ($isOwnProfile)
                    <a class="w-full rounded-lg bg-lightMode-primary px-4 py-2 font-semibold text-white">
                        420 Followers
                    </a>
                    <button class="w-full rounded-lg bg-gray-200 px-4 py-2 font-semibold text-black"
                        x-on:click="$dispatch('open-modal', 'edit-profile-details-modal')">
                        Edit Profile
                    </button>
                @else
                    <button x-data="followButton({{ $user->id }}, {{ Auth::user()->isFollowing($user) ? 'true' : 'false' }})"
                        :class="loading ? 'opacity-50 cursor-not-allowed' :
                                (isFollowing ?
                                    (isHovering ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-700') :
                                    'bg-lightMode-primary text-white')"
                            :disabled="loading" @click="toggleFollow()" @mouseenter="isHovering = true"
                            @mouseleave="isHovering = false"
                            class="w-full rounded-lg px-4 py-2 font-bold transition-all duration-200 active:scale-95"
                            x-text="loading ? 'working...' :
                                    (isFollowing 
                                        ? (isHovering ? 'Unfollow' : 'Following')
                                        : 'Follow')">
                    </button>
                    <a class="w-full rounded-lg bg-gray-200 px-4 py-2 font-semibold text-black transition-all hover:bg-gray-300"
                        href="{{ route('profile.edit') }}">
                        Message
                    </a>
                @endif
            @endauth
        </div>
    </section>

    <section class="my-4 rounded-lg bg-white px-5 py-4 shadow-md">

        <h6 class="text-lg font-semibold md:text-xl lg:text-xl">Interests</h6>
        <ul class="mt-4 flex flex-wrap items-center gap-2 text-sm md:text-base lg:text-base">
            @foreach($user->topics as $topic)
                <a href="{{ route('topic.trending', $topic->slug) }}" 
                    class="px-2 py-1 text-lightMode-blueHighlight bg-blue-50/30 border 
                        border-lightMode-blueHighlight shadow-sm text-xs font-semibold rounded-full 
                        hover:bg-opacity-10 transition-colors duration-200
                        flex-shrink-0">{{ $topic->name }}</a>
            @endforeach
        </ul>

    </section>

    <section class="rounded-lg bg-white px-5 py-4 shadow-md">

        <h6 class="text-lg font-semibold md:text-xl lg:text-xl">About {{ $user->fname }}</h6>
        <ul class="my-4 text-sm md:text-base lg:text-base">
            <li>Occupation <span class="font-semibold">Software Engineer</span></li>
            <li>Joined <span class="font-semibold">September 2025</span></li>
            <li>From <span class="font-semibold">{{ $user->location }}</span></li>
        </ul>
        
        <div class="">
            <a href="{{ route('profile.followers', auth()->user()->id) }}" class="mr-4 inline hover:underline">
                <span class="font-bold" id="follower-count"> {{ $user->followers_count }}</span>
                <span class="text-sm font-normal">Followers</span>
            </a>

            <a href="{{ route('profile.following', auth()->user()->id) }}"  class="inline hover:underline">
                <span class="font-bold" id="following-count" id="following-count">{{ $user->following_count }}</span>
                <span class="text-sm font-normal">Following</span>
            </a>
        </div>
    </section>
</div>
@include('profile.partials.edit-profile-details-modal')
