<x-modal :show="false" focusable name="edit-profile-details-modal">
    <section class="mx-4 flex justify-center p-4 overflow-visible">
        <div class="w-full">
            <h2 class="mb-8 text-center text-3xl font-bold">Edit Details</h2>
            <form action="{{ route('profile.update', $user->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="my-4">
                    <x-input-label :value="__('Bio')" class="text-start text-xl font-semibold" for="bio" />
                    <textarea
                        class="mt-1 block w-full resize-none overflow-y-auto rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        id="bio" name="bio" placeholder="Type your Bio..." rows="3" value="">{{ old('bio', $user->bio) }}</textarea>
                    <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                </div>

                <div class="my-4 relative">
                    <x-input-label :value="__('Location')" class="text-start text-xl font-semibold" for="location" />
                    <x-text-input :value="old('location', $user->location)" autocomplete="location" autofocus class="mt-1 block w-full"
                        id="location-input" name="location" required type="text" />
                    <x-input-error :messages="$errors->get('location')" class="mt-2" />
                    <div class="absolute left-0 right-0 z-50 mt-1 max-h-48 overflow-y-auto rounded-md bg-white shadow-lg list-none" id="location-dropdown">
                    </div>
                </div>

                <div class="flex w-full flex-wrap gap-2 text-center text-sm sm:flex-nowrap md:text-base lg:text-base">
                    <button x-on:click="$dispatch('close')"
                        class="w-full rounded-lg bg-gray-200 px-4 py-2 font-semibold text-black"
                        type="button">Cancel</button>
                    <button class="w-full rounded-lg bg-lightMode-primary px-4 py-2 font-semibold text-white"
                        type="submit">Save</button>
                </div>
            </form>
        </div>
    </section>
</x-modal>
