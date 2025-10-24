@php($id = $instance ?? 'default')
<div id="filter-container-{{ $id }}">
    <h4 class="hidden lg:mb-2 lg:block lg:px-4 lg:text-base lg:font-bold lg:text-zinc-400">Search filters</h4>
    <form action="{{ route('search.results') }}" method="GET">
        <ul class="flex justify-center gap-3 py-4 lg:flex-col lg:gap-0 lg:divide-y lg:py-0" id="search-filters-{{ $id }}">
            <li class="flex items-center gap-2">
                <input class="peer hidden" id="search-all-{{ $id }}" name="all" type="checkbox" value="all">
                <label class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2 shadow peer-checked:bg-lightMode-blueHighlight peer-checked:text-white transition-colors duration-200 ease-in-out lg:rounded-none lg:border-none lg:shadow-none lg:hover:cursor-pointer lg:hover:bg-lightMode-background" for="search-all-{{ $id }}">All</label>
            </li>
            <li class="flex items-center gap-2">
                <input class="peer hidden" id="search-post-{{ $id }}" name="posts" type="checkbox" value="posts">
                <label class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2 shadow peer-checked:bg-lightMode-blueHighlight peer-checked:text-white transition-colors duration-200 ease-in-out lg:rounded-none lg:border-none lg:shadow-none lg:hover:cursor-pointer lg:hover:bg-lightMode-background" for="search-post-{{ $id }}">Posts</label>
            </li>
            <li class="flex items-center gap-2">
                <input class="peer hidden" id="search-user-{{ $id }}" name="users" type="checkbox" value="users">
                <label class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2 shadow peer-checked:bg-lightMode-blueHighlight peer-checked:text-white transition-colors duration-200 ease-in-out lg:rounded-none lg:border-none lg:shadow-none lg:hover:cursor-pointer lg:hover:bg-lightMode-background" for="search-user-{{ $id }}">Users</label>
            </li>
            <li class="flex items-center gap-2">
                <input class="peer hidden" id="search-near-{{ $id }}" name="near" type="checkbox" value="near">
                <label class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2 shadow peer-checked:bg-lightMode-blueHighlight peer-checked:text-white transition-colors duration-200 ease-in-out lg:rounded-none lg:border-none lg:shadow-none lg:hover:cursor-pointer lg:hover:bg-lightMode-background" for="search-near-{{ $id }}">Near me</label>
            </li>
        </ul>
        <div class="hidden lg:block lg:px-4 lg:py-1 lg:hover:bg-lightMode-background">
            <button class="lg:w-full lg:text-lightMode-blueHighlight">Advance search</button>
        </div>
    </form>
</div>
