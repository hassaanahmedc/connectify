<div class="mb-2 rounded-xl bg-white px-4 py-2 shadow-sm">
    <div class="flex gap-4 md:gap-6">
        <div class="flex-shrink-0">
            <img alt="" class="h-auto w-9 rounded-full bg-gray-200 object-cover"
                src="{{ Auth::user()->avatar_url }}">
        </div>

        <div class="flex-1">
            <div @click="$dispatch('open-modal', 'post-modal', { isEdit: false })"> 
                <div class="cursor-pointer rounded-full border px-4 py-2 text-gray-500">
                    Share something...
                </div>
            </div>

            {{-- <!-- Post Creation Modal -->
            @include('posts.create', ['showVariable' => 'create_post']) --}}

        </div>
    </div>
</div>

<x-modal :show="false" autofocus name="post-modal">
    <div x-data="imagePreviewer">
        <section class="mx-1 md:mx-4 flex justify-center p-4 overflow-visible" >
            <form method="POST" action="{{ route('topic.attach') }}" multipart/form-data class="w-full">
                @csrf

                {{-- Header Area --}}
                <div class="my-2 flex justify-between">
                    <div class="flex items-center gap-4">
                        <img alt="" class="h-auto w-10 rounded-full bg-gray-200 object-cover"
                            src="{{ Auth::user()->avatar_url }}">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 leading-tight truncate">
                                {{ Auth::user()->fname . ' ' . Auth::user()->lname }}</h4>
                            <span class="text-xs">Creating Post...</span>
                        </div>
                    </div>
                    <div @click="$dispatch('close')" class="cursor-pointer">
                        <x-svg-icons.cross-mark class="w-6 h-auto" />
                    </div>
                </div>

                {{-- Main Content --}}
                <div class="overflow-y-auto max-h-[60vh] md:max-h-[500px] pr-2">
                    <textarea class="w-full resize-none focus:ring-0 border-0 bg-blue-50/50 p-4 rounded-2xl text-gray-800" 
                        name="" 
                        id="" 
                        rows="5"
                        x-model="content"
                        placeholder="What's on your mind?"></textarea>

                    {{-- Selected Topics --}}
                    <div class="flex flex-wrap gap-2 my-3 px-2 w-full">
                        <template x-for="topic in selectedTopics" :key="topic.id">
                            <span class="px-2 py-1 text-lightMode-blueHighlight bg-blue-50/30 border 
                                border-lightMode-blueHighlight shadow-sm text-xs font-semibold rounded-full 
                                hover:bg-opacity-10 transition-colors duration-200
                                flex-shrink-0" x-text="topic.name"></span>
                        </template>
                    </div>

                    {{-- Selected Images --}}
                    <div class="flex items-center gap-2 snap-x snap-mandatory overflow-x-auto scrollbar-hide max-w-full pb-2">
                        <template x-for="img in previewImages" :key="img.id">
                            <div class="relative group cursor-pointer snap-center shrink-0 w-10/12 md:w-2/5 lg:w-2/6">
                                <img :src="img.url" 
                                    class="w-full object-cover rounded-xl aspect-square shadow-sm border border-gray-100 
                                        my-2">
                                <div class="absolute inset-0 rounded-xl bg-black/40 opacity-0 group-hover:opacity-100 my-2
                                    transition-opacity duration-200 flex items-center justify-center shadow-md">
                                    <div @click="removePreview(img.id)" 
                                        class="bg-red-600 rounded-full p-2 hover:bg-red-700">
                                        <x-svg-icons.cross-mark class="w-6 h-auto" color="white" />
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="h-[1px] w-full bg-gray-200 mt-1"></div>
                <div class="w-full min-w-0 flex items-center justify-between mt-4">
                    <div  class="flex gap-2 items-center">

                        <label for="post-modal-preview-upload"
                            class="flex items-center gap-2 text-sm px-4 py-2 rounded-xl text-gray-600 cursor-pointer 
                                hover:bg-blue-50 hover:text-lightMode-blueHighlight"
                            >
                            <x-svg-icons.images class="w-5 h-auto "/>
                            <span class="text-xs sm:text-sm md:text-base">Image</span>
                            <input type="file" 
                                id="post-modal-preview-upload" 
                                class="hidden" 
                                multiple
                                @change="handleFileSelect"
                                accept="image/*">
                        </label>

                        <div @click="topicButtonToggle = !topicButtonToggle"
                             class="relative ">
                            <div class="flex items-center gap-2 text-sm px-4 py-2 rounded-xl text-gray-600 cursor-pointer 
                                hover:bg-blue-50 hover:text-lightMode-blueHighlight">
                                <x-svg-icons.images class="w-5 h-auto "/>
                                <span class="text-xs sm:text-sm md:text-base">Topics</span>
                            </div>
                            <div x-show="topicButtonToggle" 
                                 @click.away="open = false"
                                class="absolute w-52 bottom-full left-0 mb-2 bg-white py-2 px-3 border 
                                    border-gray-100 rounded-2xl shadow-xl">
                                <p class="text-xs font-bold uppercase tracking-widest text-gray-500 px-3 py-2">
                                    Select Topics</p>
                                <div>
                                    @foreach($topics as $topic)
                                        <label class="flex items-center gap-2 px-3 py-2 hover:bg-blue-50 rounded-lg 
                                                cursor-pointer">
                                            <input type="checkbox" 
                                                @change="toggleTopic({ id: {{ $topic->id }}, name: '{{ $topic->name }}' })"
                                                :checked="selectedTopics.some(t => t.id === {{ $topic->id }})"
                                                class="rounded text-lightMode-primary focus:ring-0">
                                            <span class="text-sm text-gray-700">{{ $topic->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <button type="submit"
                        @click.prevent="submitPostModal()"
                        class="px-5 py-2 bg-lightMode-primary rounded-lg text-white text-sm font-bold 
                        shadow-sm transition-all"
                        :disabled="loading"
                        :class="loading
                            ? 'opacity-50 cursor-not-allowed' 
                            : 'hover:shadow-lightMode-primary'">
                        Continue
                    </button>
                </div>
            </form>
        </section>
    </div>
</x-modal>