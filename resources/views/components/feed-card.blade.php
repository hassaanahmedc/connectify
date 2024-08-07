{{-- Container --}}
<div
    class="flex flex-col bg-white rounded-xl mt-2 shadow-[0px_10px_34px_-15px_rgba(0,0,0,0.10)]">
    {{-- Card Content --}}
    <div class=" px-5 pt-5 pb-2">
        {{-- Header: User Info and Edit Button --}}
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="{{ $profileUrl }}"><img src="{{ $profileImageUrl }}"
                        class="bg-gray-200 w-10 rounded-full"
                        alt=""></a>
                <div>
                    <span
                        class="font-bold/[1px] text-base/[1rem] font-montserrat block"><a
                            href="{{ $profileUrl }}">{{ $userName }}</a></span>
                    <span
                        class="text-gray-400 text-sm inline">{{ $postTime }}</span>
                </div>
            </div>
            <div x-data="{ edit_post: false, confirm_delete: false }"
                class="relative cursor-pointer">
                <img src="{{ Vite::asset('/public/svg-icons/3dots.svg') }}"
                    x-on:click="edit_post = true"
                    alt="">
                <ul x-cloak
                    x-show="edit_post"
                    @click.away="edit_post = false"
                    class="w-max flex flex-col absolute right-0 top-0 bg-white shadow-2xl rounded-md">

                    @can('delete', $post)
                        <li class="py-2 px-6 hover:bg-gray-100 hover:rounded-md">
                            <button
                                x-on:click.prevent="edit_post = false; confirm_delete = true">Delete
                                Post</button>
                        </li>

                        <li class="py-2 px-6 hover:bg-gray-100 hover:rounded-md">
                            <a href="#"
                                x-on:click="edit_post = false">Edit Post</a>
                        </li>
                    @endcan

                    <li class="py-2 px-6 hover:bg-gray-100 hover:rounded-md">
                        <a href="#"
                            x-on:click="edit_post = false">Pin to your
                            profile</a>
                    </li>
                </ul>

                @include('components.confirm-alert', [
                    'showVariable' => 'confirm_delete',
                    'message' =>
                        'Are you sure you want to delete this post?',
                    'action' => route('post.destroy', ['post' => $postId]),
                ])
            </div>


        </div>
        {{-- Post Content --}}
        <div class="my-2">
            <p> {{ $postContent }} </p>
        </div>
    </div>
    {{-- Image Container --}}
    @if ($postImages->count())
        <div>
            @foreach ($postImages as $image)
                <img src="{{ asset('storage/' . $image->path) }}"
                    class="w-full h-full object-cover"
                    alt="Post Image">
            @endforeach
        </div>
    @endif
</div>
