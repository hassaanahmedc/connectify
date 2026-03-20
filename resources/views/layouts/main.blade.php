@extends('layouts.app')

@section('content')
<x-notification />
<div class="flex h-screen flex-col overflow-hidden">
    
    <header class="flex-shrink-0 h-16 z-50">
        <x-nav.index />
    </header>

    <div class="mx-auto flex w-full max-w-[1600px] flex-1 overflow-hidden">
        
        <x-left-sidebar class="flex-shrink-0 h-full" />

        <main class="flex-1 min-w-0 overflow-y-auto py-4">
            @yield('main')
        </main>

        <x-right-sidebar class="flex-shrink-0 h-full">
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