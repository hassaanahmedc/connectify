{{-- 
    This component renders the header of our main profile page, which includes
    the cover photo and interactive elements associated with it,

    This partial is self-contained Alpine.js component, It manages the state 
    for 'edit-cover' dropdown nmenu.

    It communicates with other parts of the application by dispatchiung global
    window events, such as 'open-image-viewer' and 'open-confitm-modal' for
    confirmation dialogue.
 --}}

{{-- The main root element of Alpine component. It controls the 'editCoverPicture' state. --}}
<header class="relative max-h-96 min-w-96 bg-black opacity-85 xl:rounded-b-lg" 
    x-data="{ editCoverPicture: false, addCoverModal: false, cuurentPreview: '' }">
    @auth
        @if ($user->id === Auth::id())
        {{-- 
            The main cover image, It is only interactive for the profile owner.
            - On click, it dispatches an event to open global image viewer.
            - It also closes the "Edit Cover" dropdown if open.
         --}}
            <img alt=""
                class="profile-cover-display h-80 w-full cursor-pointer object-cover transition-opacity ease-in-out hover:opacity-70 hover:shadow-lg xl:rounded-b-lg"
                id="cover-picture" src="{{ $user->cover_url }}"
                x-on:click.stop="
                    $dispatch('open-image-viewer', { currentImageUrl: '{{ $user->cover_url }}' });
                    $nextTick(() => editCoverPicture = false);">
        @else

        {{-- For other users, the cover image is not interactive except for viewing the image. --}}
            <img alt="" class="ah-full w-full object-cover xl:rounded-b-lg" src="{{ $user->cover_url }}"
                x-on:click.stop="
                    $dispatch('open-image-viewer', { currentImageUrl: '{{ $user->cover_url }}' });
                    $nextTick(() => editCoverPicture = false);">
        @endif
    @endauth

    {{-- Drop Shadow on Mobile Screens --}}
    <div class="absolute bottom-0 left-0 h-24 w-full bg-gradient-to-b from-transparent to-white md:hidden">
    </div>

    {{-- The button to trigger the 'Edit Cover' Dropdown --}}
    <button @click="editCoverPicture = true"
        class="absolute bottom-4 right-4 hidden rounded-lg bg-gray-200 px-4 py-2 font-semibold text-black shadow-md md:block"
        id="uplaod-cover-picture" type="button">Edit Cover</button>
        
    {{-- 
        The Dropdown Menu for cover image.
        - It is controlled by 'editCoverPicture' state.
        - It closes if the user clicks outside of it,
     --}}
    <ul @click.outside="editCoverPicture = false"
        class="bottom-0- absolute right-4 mt-1 rounded-lg border bg-white shadow-md" 
        x-cloak 
        x-show="editCoverPicture">

        {{-- This list item serves as a proxy to trigger the hidden file input. --}}
        <li class="m-2 cursor-pointer px-4 py-1 hover:bg-gray-100" id="upload-cover-picture">
            Upload new photo</li>
        <input hidden id="select-cover-picture" type="file">

        @if ($user->cover)

        {{-- This dispatches detailed event to open generic confirmation modal. --}}
            <li class="m-2 cursor-pointer px-4 py-1 hover:bg-gray-100" id="remove-cover-picture"
                x-on:click.prevent="$dispatch('open-modal', {
                    name: 'confirm_action',
                    title: 'Are you sure?',
                    message: 'Your cover photo will be replaced by default picture.',
                    actionType: 'cover_photo',
                    itemId: null,
                    confirmButtonText: 'Delete', 
                })">
                Remove photo</li>
        @endif
        
        {{-- This dispatches an event to open the global image viewer. --}}
        <li class="m-2 cursor-pointer px-4 py-1 hover:bg-gray-100" id="view-cover-picture"
            x-on:click.stop="
                            $dispatch('open-image-viewer', { currentImageUrl: '{{ $user->cover_url }}' });
                            $nextTick(() => editCoverPicture = false);">
            View photo</li>
    </ul>
</header>
