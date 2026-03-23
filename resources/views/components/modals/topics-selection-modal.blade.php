
<x-modal :show="false" autofocus name="selectTopicsModal">
    <div x-data="{
        selectedTopics: [],
        maxTopics: {{ $topics->count() }},
        status: '',
        toggleTopic(topic) {
            if (this.selectedTopics.includes(topic)) {
                this.selectedTopics = this.selectedTopics.filter(t => t !== topic);
            } else {
                this.selectedTopics.push(topic);
            }
        }

    }">
        <section class="mx-4 flex justify-center p-4 overflow-visible">
            <form method="POST" action="{{ route('topic.attach') }}">
                @csrf
                <div class="my-2">
                    <h4 class="text-xl font-bold text-gray-900 tracking-tight">What are you interested in?</h4>
                    <p class="text-sm text-gray-600">
                        Select atleast a few topics to personalize your newsfeed and discover new content.</p>
                </div>
                <div class="flex flex-wrap gap-3 justify-center mb-4 mt-8">
                    @foreach($topics as $topic)
                        <span @click="toggleTopic('{{ $topic->id }}')"
                        :class="selectedTopics.includes('{{ $topic->id }}')
                            ? 'bg-lightMode-primary text-white font-bold'
                            : 'text-gray-600 border-2 border-gray-200 hover:border-lightMode-primary hover:text-lightMode-primary'"
                        class="inline-block text-sm font-semibold px-6 py-2 shadow-sm rounded-full cursor-pointer 
                            transition-all">{{ $topic->name }}</span>
                    @endforeach
                <template x-for="id in selectedTopics">
                    <input type="hidden" name="topics[]" :value="id">
                </template>
                <div class="h-[1px] w-full bg-gray-200 mt-12"></div>
                <div class="w-full min-w-0 flex items-center justify-between my-4">
                    <div class="text-sm text-gray-500">
                        <span class="font-bold text-blue-600" x-text="selectedTopics.length">0</span>
                        of <span x-text="maxTopics"></span> topics selected
                    </div>

                    <button type="submit" 
                        class="px-5 py-2 bg-lightMode-primary rounded-lg text-white text-sm font-bold 
                         shadow-sm transition-all" 
                        :disabled="selectedTopics.length === 0"
                        :class="selectedTopics.length === 0 
                            ? 'opacity-50 cursor-not-allowed' 
                            : 'hover:shadow-lightMode-primary'">
                        Continue
                    </button>
                </div>
            </form>
        </section>
    </div>
</x-modal>