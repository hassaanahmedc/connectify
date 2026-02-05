@extends('layouts.app')

@section('content')
<header>
    <x-nav.index />
</header>

<div class="mx-auto max-w-[1600px]  h-screen pt-10">
    <div class="flex h-[calc(100vh-4rem)]">
        <x-left-sidebar />

        <main class="flex-1 overflow-y-auto py-4">
            @yield('main')
        </main>

        <x-right-sidebar>
            <x-slot name="upperContainer">
                @hasSection('append-data-to-rightSidebar')
                    @yield('append-data-to-rightSidebar')
                @else
                    @include('components.right-sidebar-friends')
                @endif
            </x-slot>
        </x-right-sidebar>
    </div>
</div>
@endsection
