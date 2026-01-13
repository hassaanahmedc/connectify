{{-- @dd($user) --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="{{ csrf_token() }}" name="csrf-token">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Roboto&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/components/follow.js', 'resources/js/features/profile/profileImages.js', 'resources/js/components/locations.js', 'resources/js/features/profile/profileImageDeleter.js', 'resources/js/features/profile/coverImage.js', 'resources/js/features/profile/coverImageDeleter.js'])
</head>

<body class="light bg-lightMode-background">
    {{-- Toast Notification Component --}}
    <x-notification />
    <header>
        <x-custom-nav />
    </header>
    <div class="mx-auto mt-16 max-w-[1600px]">

        <div class="h-[calc(100vh-4rem)] xl:mx-auto xl:my-0 xl:w-4/5">
            {{-- Cover Image --}}
            @include('profile.partials.profile-header')

            <div class="flex w-full flex-col items-center gap-5 md:flex-row md:items-start md:justify-center">
                @include('profile.partials.profile-sidebar')
                @include('profile.partials.profile-feed')
                
            </div>
        </div>
    </div>

    <x-image-viewer />
    {{-- Modal for uploading Cover Image  --}}
    <x-modals.image-upload-preview-modal />
    {{-- Confirm Profile Picture Deletion Modal --}}
    <x-modals.confirm-action />

    <script>
        window.threeDotsSvg = "{{ Vite::asset('public/svg-icons/3dots.svg') }}";
    </script>
</body>

</html>
