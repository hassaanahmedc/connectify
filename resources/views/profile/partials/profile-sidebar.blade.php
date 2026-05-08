{{-- 
    This partial renders the sidebar of the main profile page which
    includes user details like profile states, avatar and triggers edit user
    details modal,

--}}

<div class="z-10 -mt-20 w-full max-w-md px-4 md:w-1/3 md:px-0 lg:w-1/3">

    <section class="flex flex-col items-center justify-center bg-white px-5 py-6 rounded-2xl shadow-md 
        border border-gray-50 transition-shadow hover:shadow-lg"
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

            <figure class="relative w-36 aspect-square rounded-full bg-black border border-gray-100 mb-4">
                @auth
                    @if ($isOwnProfile)
                    {{-- 
                        The main Profile picture, It is only interactive for the profile owner.
                        On click, triggers the dropdown to view, edit and delete the image.
                    --}}
                        <img @click="editProfilePicture = true" alt=""
                            class="profile-picture-display h-full w-full cursor-pointer rounded-full object-cover transition-opacity ease-in-out hover:opacity-70"
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
            <ul @click.outside="editProfilePicture = false" class="w-48 flex flex-col absolute bg-white shadow-xl border border-gray-100 rounded-xl z-10 p-1.5"
                x-cloak x-show="editProfilePicture">

                 {{-- This list item serves as a proxy to trigger the hidden file input. --}}
                <li class="px-3 py-2 text-sm font-medium text-gray-700 hover:bg-blue-50 rounded-lg transition-colors" id="upload-profile-picture">
                    Upload new photo</li>
                <input hidden id="select-profile-picture" type="file">

                @if ($user->avatar)

                    {{-- This dispatches detailed event to open generic confirmation modal. --}}
                    <li class="m-2 cursor-pointer px-3 py-2 font-medium text-gray-700 hover:bg-blue-50 rounded-lg transition-colors" id="remove-profile-picture"
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

        <div class="text-center w-full px-2">
            <h1 class="my-3 font-bold text-xl md:text-2xl lg:text-3xl text-gray-900 tracking-tight">
                {{ $user->fname }}
                {{ $user->lname }}</h1>
            @if ($user->bio !== null)
                <span class="text-sm text-gray-600 md:text-base leading-relaxed mb-3">{{ $user->bio }}</span><br>
            @endif
            @if ($user->location !== null)
                <div class="flex items-center justify-center gap-1 my-3 text-lightMode-text">
                    <x-svg-icons.map-pin class="w-5 h-5" />
                    <span class="">From <span class="font-semibold">{{ $user->location }}</span></span>
                </div>
            @endif
        </div>

        <div class="my-2 flex w-full flex-wrap gap-2 text-center text-sm md:text-base lg:flex-nowrap lg:text-base"
            x-data="{ edit_profile_details: false }">

            @auth
                @if ($isOwnProfile)
                    <a class="w-full rounded-xl shadow-sm bg-lightMode-primary py-2.5 font-bold text-white">
                        420 Followers
                    </a>
                    <button class="w-full rounded-xl shadow-sm bg-gray-200 px-4 py-2 font-semibold text-black"
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
                            class="w-full rounded-xl shadow-sm bg-lightMode-primary py-2.5 font-bold text-white transition-transform active:scale-95"
                            x-text="loading ? 'working...' :
                                    (isFollowing 
                                        ? (isHovering ? 'Unfollow' : 'Following')
                                        : 'Follow')">
                    </button>
                    <button x-data="shareUrl('{{ route('profile.view', $user->id) }}')"
                        `   @click="copyToClipboard()"
                            class="w-full py-2.5 cursor-pointer text-gray-700 bg-gray-200 rounded-xl shadow-sm font-bold 
                                transition-all duration-200 active:scale-95 relative">
                        Share Profile
                        {{-- Toast/Tooltip Message --}}
                        <div x-cloak 
                             x-show="copied" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="absolute bottom-full left-1/2 -translate-x-1/2  mb-2 bg-gray-900 text-white 
                                text-xs font-semibold py-1 px-3 rounded-lg shadow-lg z-50">
                            Link copied!
                        </div>
                    </button>
                @endif
            @endauth
        </div>
    </section>

    {{-- Interest Section --}}
    <section class="my-4 bg-white px-5 py-4 rounded-2xl shadow-md border border-gray-50"
        x-data="{ selectTopicsModal: false }">

        <h6 class="text-lg font-semibold md:text-xl lg:text-xl">Interests</h6>
        <ul class="mt-4 flex flex-wrap items-center gap-2 text-sm md:text-base lg:text-base">
            @foreach($user->topics as $topic)
                <a href="{{ route('topic.trending', $topic->slug) }}" 
                    class="px-2 py-1 text-lightMode-blueHighlight bg-blue-50/30 border 
                        border-lightMode-blueHighlight shadow-sm text-xs font-semibold rounded-full 
                        hover:bg-opacity-10 transition-colors duration-200 
                        flex-shrink-0">{{ $topic->name }}</a>
            @endforeach

            {{-- Add interest button (visible if user user hasnt reached topics limit) --}}
            @if($user->topics->count() < $topics->count())
                <div class="px-2 py-1 text-lightMode-blueHighlight bg-blue-50/30 border 
                            border-lightMode-blueHighlight shadow-sm text-xs font-semibold rounded-full 
                            hover:bg-opacity-10 transition-colors duration-200
                            flex-shrink-0 flex items-center cursor-pointer"
                            x-on:click="$dispatch('open-modal', 'selectTopicsModal')">
                            <x-svg-icons.plus class=" w-4 h-auto" />
                            <p>Add Interest</p>
                
                </div>
            @endif
        </ul>

    </section>

    <section class="bg-white px-5 py-4 rounded-2xl shadow-md border border-gray-50">

        <h6 class="text-lg font-semibold md:text-xl lg:text-xl">About {{ $user->fname }}</h6>
        <ul class="my-4 text-sm md:text-base lg:text-base space-y-1">
            <li class="flex items-center gap-2">
                <x-svg-icons.briefcase class="w-4 h-4" />
                <span>Occupation <span class="font-bold text-gray-900">Software Engineer</span></span>
            </li>
            <li class="flex items-center gap-2">
                <x-svg-icons.calender class="w-4 h-4" />
                <span>Joined <span class="font-bold text-gray-900">{{ $user->created_at->format('F Y') }}</span></span>
            </li>
            <li class="flex items-center gap-2">
                <x-svg-icons.map-pin class="w-4 h-4" />
                <span>From <span class="font-bold text-gray-900">{{ $user->location }}</span></span>
            </li>
        </ul>
        
        <div class="">
            <a href="{{ route('profile.followers', auth()->user()->id) }}" class="mr-4 inline hover:underline">
                <span class="font-bold" id="follower-count"> {{ $user->followers_count }}</span>
                <span class="text-sm">Followers</span>
            </a>

            <a href="{{ route('profile.following', auth()->user()->id) }}"  class="inline hover:underline">
                <span class="font-bold" id="following-count" id="following-count">{{ $user->following_count }}</span>
                <span class="text-sm">Following</span>
            </a>
        </div>
    </section>
</div>
@include('profile.partials.edit-profile-details-modal')
