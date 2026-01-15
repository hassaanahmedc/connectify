{{-- 
    This is the main public-facing Profile Page.
    
    This view acts as a simply layout file. It is responsible for rendeting the
    larger self-contained partials that render that make up the page, such as header, 
    sidebar, user-posts. It passes the required data such as $user object down to these partials.
 --}}

@extends('layouts.app')

@section('content')
  {{-- 
    THis is a global component to display toast notifications triggered by
    Api requests or user actions  
    --}}
    <x-notification />
    <header>
        <x-custom-nav />
    </header>

    <div class="mx-auto mt-16 max-w-[1600px]">

        <div class="h-[calc(100vh-4rem)] xl:mx-auto xl:my-0 xl:w-4/5">
            {{-- The Profile header, containing cover photo and user actions --}}
            @include('profile.partials.profile-header')

            <div class="flex w-full flex-col items-center gap-5 md:flex-row md:items-start md:justify-center">

                {{-- The Profile sidebarx containing user info, stats and main avatar --}}
                @include('profile.partials.profile-sidebar')

                {{-- The feed of posts belonging to this user --}}
                @include('profile.partials.profile-feed')
                
            </div>
        </div>
    </div>

    {{-- 
    Global Application Modals
    ----------------------------------------------------------------------------------
    These components are single, page-wide instances for handling Common UI patterns 
    like vciwing images or confirming actions.

    They are designed to be "dumb" and are controlled entirely by dispatching 
    global window events from other components or Javascript files. 
    For example, to open confirm action modal, another component dispatches 'open-modal'
    event with 'confirm-action' payload. 
     --}}

    <x-image-viewer />
    <x-modals.image-upload-preview-modal />
    <x-modals.confirm-action />

@endsection

@push('scripts')
    @vite('resources/js/components/follow.js')
    @vite('resources/js/features/profile/profileImages.js')
    @vite('resources/js/components/locations.js')
    @vite('resources/js/features/profile/profileImageDeleter.js')
    @vite('resources/js/features/profile/coverImage.js')
    @vite('resources/js/features/profile/coverImageDeleter.js')
@endpush
