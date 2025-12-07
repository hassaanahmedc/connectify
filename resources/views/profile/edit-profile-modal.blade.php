@vite('resources/js/components/locations.js')
<div class="fixed left-0 top-0 flex h-screen w-screen items-center justify-center bg-black/80"
     x-cloak x-show="edit_profile_details">
    <section @click.outside="edit_profile_details=false"
        class="bg-base-200 flex w-full max-w-screen-sm justify-center overflow-y-scroll bg-white mx-4 p-4 md:w-3/4 rounded-lg">

        <div class="w-full">
            <h2 class="mb-8 text-center text-3xl font-bold">Edit Details</h2>
            <form action="{{ route('profile.update', $user->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="my-4">
                    <x-input-label :value="__('Bio')" class="text-start text-xl font-semibold" for="bio" />
                    <textarea
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 resize-none overflow-y-auto"
                        id="bio" rows="3" name="bio" placeholder="Type your Bio..." value="">{{ old('bio', $user->bio) }}</textarea>
                    <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                </div>

                <div class="my-4">
                    <x-input-label :value="__('Location')" class="text-start text-xl font-semibold" for="location" />
                    <x-text-input :value="old('location', $user->location)" autocomplete="location" autofocus 
                        class="relative mt-1 block w-full"
                        id="location-input" name="location" required type="text" />
                    <x-input-error :messages="$errors->get('location')" class="mt-2" />
                    <div id="location-dropdown" class="absolute list-none  bg-white text-left overflow-y-auto">
                    </div>
                </div>

                <div class="flex w-full flex-wrap gap-2 text-center text-sm md:text-base sm:flex-nowrap lg:text-base">
                    <button type="button" class="w-full rounded-lg bg-gray-200 px-4 py-2 font-semibold text-black"
                            @click="edit_profile_details=false">Cancel</button>
                    <button class="w-full rounded-lg bg-lightMode-primary px-4 py-2 font-semibold text-white"
                        type="submit">Save</button>
                </div>
            </form>
        </div>
    </section>
</div>
