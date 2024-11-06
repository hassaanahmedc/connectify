<div class="w-screen fixed h-screen bg-black/80 top-0 left-0  flex justify-center items-center z-50 "
    x-cloak
    x-show="edit_profile"
    @click.away="edit_profile=false">
    <section
        class="relative bg-white max-w-screen-sm bg-base-200 min-w-[350px] py-8 px-6  flex justify-center overflow-y-scroll md:w-3/4">
        {{-- close Modal Button --}}
        <svg class="swap-on fill-current absolute right-4 top-8 cursor-pointer"
            x-on:click="edit_profile=false"
            xmlns="http://www.w3.org/2000/svg"
            width="32"
            height="32"
            viewBox="0 0 512 512">
            <polygon
                points="400 145.49 366.51 112 256 222.51 145.49 112 112 145.49 222.51 256 112 366.51 145.49 400 256 289.49 366.51 400 400 366.51 289.49 256 400 145.49" />
        </svg>

        <div class="w-full">
            <h2 class="text-3xl font-bold mb-8 text-center">Edit Details
            </h2>
            <form action="{{ route('profile.update', $user->id) }}"
                method="POST">
                @csrf
                @method('PATCH')

                <div class="">
                    <x-input-label for="cover"
                        :value="__('Cover Image')"
                        class="text-xl font-semibold" />
                        <img id="cover" name="cover" src="" alt="">

    
                    <x-input-error :messages="$errors->get('cover')"
                        class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="bio"
                        :value="__('Bio')"
                        class="text-xl font-semibold" />
                    <textarea
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        name="bio"
                        id="bio"
                        value=""
                        placeholder="Type your Bio...">{{ old('bio', $user->bio) }}</textarea>
                    <x-input-error :messages="$errors->get('bio')"
                        class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="bio"
                        :value="__('Bio')"
                        class="text-xl font-semibold" />
                    <textarea
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        name="bio"
                        id="bio"
                        value=""
                        placeholder="Type your Bio...">{{ old('bio', $user->bio) }}</textarea>
                    <x-input-error :messages="$errors->get('bio')"
                        class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="location"
                        :value="__('Location')"
                        class="text-xl font-semibold" />
                    <x-text-input id="location"
                        class="block mt-1 w-full"
                        type="text"
                        name="location"
                        :value="old('location', $user->location)"
                        required
                        autofocus
                        autocomplete="location" />
                    <x-input-error :messages="$errors->get('location')"
                        class="mt-2" />
                </div>

                <div class="mt-8 ">
                    <a href=""
                        class="px-4 py-2 text-lg mr-2 rounded bg-gray-200 hover:bg-gray-300">Cancel</a>
                    <button type="submit"
                        class="px-8 py-2 text-lg rounded bg-lightMode-primary text-white">Save</button>
                </div>
            </form>
        </div>
    </section>
</div>
