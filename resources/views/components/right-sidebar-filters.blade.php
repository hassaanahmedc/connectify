<div id="filter-container">
    <div class="py-2">
        <h4 class="text-xs sm:text-sm lg:text-base font-bold text-zinc-400 px-4 mb-2">Search filters</h4>
        <form action="{{ route('search.results') }}" method="GET">
            <ul id="search-filters" class="divide-y">
                <li class="flex items-center justify-between gap-2 hover:bg-lightMode-background hover:cursor-pointer px-4 py-2">
                    <label for="search-all">All</label>
                    <input type="checkbox" class="mr-5" value="all" name="all" id="search-all">
                </li>
                <li class="flex items-center justify-between gap-2 hover:bg-lightMode-background hover:cursor-pointer px-4 py-2">
                    <label for="search-post">Posts</label>
                    <input type="checkbox" class="mr-5" value="posts" name="posts" id="search-post">
                </li>
                <li class="flex items-center justify-between gap-2 hover:bg-lightMode-background hover:cursor-pointer px-4 py-2">
                    <label for="search-user">Users</label>
                    <input type="checkbox" class="mr-5" value="users" name="users" id="search-user">
                </li>
                <li class="flex items-center justify-between gap-2 hover:bg-lightMode-background hover:cursor-pointer px-4 py-2">
                    <label for="search-near">Near me</label>
                    <input type="checkbox" class="mr-5" value="near" name="near" id="search-near">
                </li>
            </ul>
            <div class="hover:bg-lightMode-background hover:cursor-pointer px-4 py-1">
                <button href="" class="w-full text-lightMode-blueHighlight ">Advance search</button>
            </div>
        </form>
    </div>
</div>