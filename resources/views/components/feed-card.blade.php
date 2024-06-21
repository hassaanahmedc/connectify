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
            <div>
                <img src="{{ Vite::asset('/public/svg-icons/3dots.svg') }}"
                    alt="">
            </div>

        </div>
        {{-- Post Content --}}
        <div class="my-2">
            <p> {{ $postContent }} </p>
        </div>
    </div>
    {{-- Image Container --}}
    @if ($postImageUrl)
        <div>
            <img src="{{ $postImageUrl }}"
                class="w-full h-full object-cover"
                alt="Post Image">
        </div>
    @endif
</div>
