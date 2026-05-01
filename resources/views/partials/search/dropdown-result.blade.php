@if ($result->type === 'user')
    <a class="flex items-center gap-3 rounded-md px-3 py-2 transition hover:bg-gray-50"
        href="{{ route('profile.view', $result->id) }}">
        <img alt="{{ $result->fname }}" class="h-8 w-8 rounded-full object-cover" src="{{ $result->avatar_url }}">
        <div>
            <div class="text-sm font-medium text-gray-900">{{ $result->fname }} {{ $result->lname }}</div>
            <div class="text-xs text-gray-400">User</div>
        </div>
    </a>
@else
    <a class="flex items-center gap-3 rounded-md px-3 py-2 transition hover:bg-gray-50"
        href="{{ route('post.view', $result->id) }}">
        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-gray-500">
            <x-svg-icons.magnifying-glass class="h-auto w-5" />
        </div>

        <div class="min-w-0 flex-1">
            <div class="truncate text-sm font-medium text-gray-900">{{ Str::limit($result->content ?? '', 35) }}</div>
            <div class="text-xs text-gray-400">Post</div>
        </div>
    </a>
@endif
