@extends('layouts.main')

@section('main')
<div class="mx-auto my-0 w-11/12 min-w-80 max-w-md md:w-11/12 lg:w-full lg:max-w-lg lg:px-5 xl:px-0 xl:max-w-xl">

    <x-feed-header 
        context="Management" 
        title="Account Settings" 
        count="d"
        label="d" 
        icon="gear-icon"    
    />

    <div class="space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow-sm sm:rounded-lg border border-gray-100">
            <div class="flex items-center gap-3 pb-4 mb-6 border-b border-gray-50">
                <div class="p-2 rounded-lg w-fit bg-blue-50">
                    <x-svg-icons.user-icon class="w-6 h-6 text-lightMode-blueHighlight" />
                </div>
                <div>
                    <h3 class="font-bold text-base text-gray-800 leading-tight">Profile Information</h3>
                    <p class="text-sm text-gray-400">Update your account's profile information.</p>
                </div>
            </div>
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Update Password Form --}}
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg border border-gray-100">
            <div class="flex items-center gap-3 pb-4 mb-6 border-b border-gray-50">
                <div class="p-2 rounded-lg w-fit bg-blue-50">
                    <x-svg-icons.lock-icon class="w-6 h-6 text-lightMode-blueHighlight" />
                </div>
                <div>
                    <h3 class="font-bold text-base text-gray-800 leading-tight">Security</h3>
                    <p class="text-sm text-gray-400">Ensure your account is using a long, random password.</p>
                </div>
            </div>

            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- Delete Account Form --}}
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg border border-gray-100">
            <div class="flex items-center gap-3 pb-4 mb-6 border-b border-gray-50">
                <div class="p-2 rounded-lg w-fit bg-red-50">
                    <x-svg-icons.warning-icon class="w-6 h-6 text-red-400" />
                </div>
                <div>
                    <h3 class="font-bold text-base text-gray-800 leading-tight">Danger Zone</h3>
                    <p class="text-sm text-gray-400">Permanently remove your personal data and account access.</p>
                </div>
            </div>
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection