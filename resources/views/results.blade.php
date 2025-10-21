@extends('layouts.main')

@section('main')
    <section class="mx-auto my-0 w-11/12 min-w-80 max-w-md py-4 md:w-11/12 lg:w-full lg:max-w-lg xl:max-w-xl">
        <div id="searchResults">
            @include('partials.search.search-results', ['results' => $results])
        </div>
    </section>
@endsection

@section('append-data-to-rightSidebar')
    <x-right-sidebar-filters />
@endsection
