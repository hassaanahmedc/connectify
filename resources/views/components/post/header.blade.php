{{-- Post Header: Displays user profile, name, post time, and action menu (edit/delete/pin) --}}
<div x-data="postModal"
    @execute-confirmed-action.window="
        if($event.detail.actionType === 'delete-post' && $event.detail.itemId == '{{$post->id}}') {
            isLoading = true;
            deletePost($event.detail.itemId);
        }
    ">
    <div class="px-3 sm:px-5 pt-5 pb-2">
        <div class="flex justify-between items-start gap-3">
            <div class="flex flex-wrap flex-1 items-center gap-3 min-w-0">
                <div class="flex items-center gap-3">
                    <a href="{{ route('profile.view', $post->user->id) }}"
                        class="w-11 h-11 flex-shrink-0 rounded-full overflow-hidden" 
                        aria-label="View profile of {{ $post->user->fname . ' ' . $post->user->lname }}">
                        <img src="{{ $post->user->avatar_url }}"
                            class="w-full h-full object-cover flex-shrink-0"
                            alt="{{ $post->user->fname }}'s profile photo">
                    </a>
    
                    <div class="min-w-0">
                        <a href="{{ route('profile.view', $post->user->id) }}" 
                            class="block text-sm font-semibold leading-tight break-words hover:underline truncate">
                            {{ $post->user->fname . ' ' . $post->user->lname }}
                        </a>
                        <time datetime="{{ $post->created_at->toIso8601String() }}" 
                            class="text-xs text-gray-400 block">{{ $post->created_at->diffForHumans() }}</time>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach($post->topics as $topic)
                        <a href="" class="px-2 py-1 text-gray-700 bg-gray-100 border 
                            text-xs font-semibold rounded-full border-gray-300
                            hover:bg-gray-200 transition-colors duration-200
                             flex-shrink-0">{{ $topic->name }}</a>
                    @endforeach
                </div>
            </div>
            {{-- Post Menu: Alpine.js manages dropdown for edit, delete, and pin actions --}}
            @if($post->user->id === auth()->user()->id)
                <div  
                     x-on:close-modal.window="if ($event.detail.modal === 'edit_post') edit_post = false" 
                     class="relative">
                    <button class="w-11 h-11 rounded-full flex items-center justify-center hover:bg-gray-100 focus:outline-none"
                            :aria-expanded="post_menu"
                            aria-haspopup="true"
                            aria-label="Open post menu">
                        <x-svg-icons.ellipsis-vertical class="w-6 h-6 cursor-pointer" x-on:click="post_menu = true" />
                    </button>
                    <ul x-cloak
                        x-transition
                        x-show="post_menu"
                        @click.outside="post_menu = false"
                        aria-label="Post actions"
                        class="w-48 flex flex-col absolute right-0 top-12 bg-white shadow-xl border border-gray-100 rounded-xl z-10 p-1.5">
                        @can('delete', $post)
                            <li role="menuitem">
                                <button class="w-full flex items-center gap-3 px-3 py-2 text-sm font-medium 
                                    text-red-600 hover:bg-red-50 rounded-lg transition-colors" 
                                        x-on:click.prevent="$dispatch('open-modal', {
                                                name: 'confirm_action',
                                                title: 'Are you sure?',
                                                message: 'Your post will be removed forever.',
                                                actionType: 'delete-post',
                                                itemId: '{{ $post->id }}',
                                                confirmButtonText: 'Delete', 
                                            })">
                                    <x-svg-icons.trash class="w-5 h-5 text-red-500" />
                                    Delete Post
                                </button>

                            </li>
                        @endcan

                        @can('update', $post)
                            <li role="menuitem">
                                <button class="w-full flex items-center gap-3 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-blue-50 rounded-lg transition-colors" 
                                        @click="
                                            $dispatch('open-modal', 'post-modal');
                                            $dispatch('fill-post-data', {
                                                isEdit: true,
                                                id: {{ $post->id }},
                                                content: {{ json_encode($post->content) }},
                                                topics: {{ $post->topics->toJson() }},
                                                images: {{ $post->postImages->map(fn($img) => [
                                                    'id' => $img->id,
                                                    'url' => asset('storage/' . $img->path)
                                                ]) }}
                                            })">
                                    <x-svg-icons.pencil-square class="w-5 h-5 text-gray-500" />
                                    Edit Post
                                </button>
                            </li>
                        @endcan
                    </ul>
                </div>
            @endif
        </div>
        {{-- Post Content: Displays text content if available --}}
        <div class="my-2" >
        
            @if($post->content)
                <p class="text-xs sm:text-sm lg:text-base">
                    <span x-text="expanded ? @js($post->content) : '{{ Str::limit($post->content, 300, '...') }}'"></span>
                </p>
        
                @if(strlen($post->content) > 300)
                    <button x-on:click="expanded = !expanded" 
                            class="mt-2 text-sm font-medium hover:underline text-blue-600">
                            <span x-text="expanded ? '<Show less' : 'Read more'"></span>
                    </button>
                @endif
            @endif
        </div>
    </div>
</div>