@extends('layouts.main')

@section('main')
<section class="w-full">
    <div id="post-wrapper" class="mx-auto my-0 w-11/12 max-w-md min-w-80 md:w-11/12 lg:w-full lg:max-w-lg xl:max-w-xl py-4  ">
        <div id="post-container">
            <x-post.card :post="$posts" />
        </div>
    </div>
</section>
@endsection



