@extends('layouts.app')

@section('content')
<header>
    <x-custom-nav />
</header>

<div class="h-screen pt-16">
    <div class="flex h-[calc(100vh-4rem)]">
        <x-left-sidebar />

        <main class="flex-1 overflow-y-auto px-4 py-6">
            @yield('main')
        </main>

        <x-right-sidebar />
    </div>
</div>
@endsection
