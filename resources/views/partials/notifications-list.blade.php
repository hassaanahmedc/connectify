<div class="py-2">
    <h5 class="text-lg font-bold px-4 pb-2">Notifications</h5>
    <div class="divide-y divide-gray-100">
        {{-- This is a placeholder. You should replace this with a loop of your actual notifications. --}}
        @for ($i = 0; $i < 7; $i++)
        <a href="#" class="block p-3 hover:bg-gray-50 dark:hover:bg-gray-800 transition duration-150 ease-in-out">
            <div class="flex gap-3 items-center text-sm">
                @if(isset($navUser))
                <img src="{{ $navUser->avatar_url }}" class="w-12 h-12 rounded-full object-cover" alt="">
                @endif
                <p class="text-gray-700 dark:text-gray-300">
                    <span class="font-bold">User Name</span> just posted something that might interest you. Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit, recusandae!
                    <span class="text-xs text-gray-500 dark:text-gray-400 block mt-1">2 hours ago</span>
                </p>
            </div>
        </a>
        @endfor
    </div>
</div>
