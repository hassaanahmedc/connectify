@extends('layouts.main')

@section('main')
    {{-- The section stays centered and responsive --}}
    <section class="mx-auto my-0 w-11/12 min-w-80 max-w-md md:w-11/12 lg:w-full lg:max-w-lg lg:px-5 xl:max-w-xl xl:px-0 py-6">
        
        {{-- GAP-4 creates the space between the individual cards --}}
        <div class="flex flex-col gap-4">
            @if ($results->isNotEmpty())
                @foreach ($results as $user)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    @include('profile.user-card', [
                        'user' => $user,
                        'profileImageUrl' => $user->avatar_url,
                        'profileUrl' => route('profile.view', $user->id),
                        'userName' => $user->fname . ' ' . $user->lname,
                        'userBio' => $user->bio,
                        'userLocation' => $user->location,
                    ])
                </div>
                @endforeach
            @endif
        </div>

    </section>
@endsection