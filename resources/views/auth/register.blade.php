<x-guest-layout>
    <main class="flex gap-10">
        {{-- Login Form --}}
        <section class="w-1/2  p-8">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4"
                :status="session('status')" />

            <h1
                class="mb-4 font-montserrat text-2xl text-lightMode-primary font-bold">
                Register to Connectify </h1>
            <form method="POST"
                action="{{ route('register') }}">
                @csrf
                <!-- Email Address -->
                <div class="flex gap-2">
                    <div>
                        <x-input-label for="fname"
                            :value="__('First Name')" />
                        <x-text-input id="fname"
                            class="block mt-1 w-full"
                            type="text"
                            name="fname"
                            :value="old('fname')"
                            required
                            autofocus
                            autocomplete="fname" />
                        <x-input-error :messages="$errors->get('fname')"
                            class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="lname"
                            :value="__('Last Name')" />
                        <x-text-input id="lname"
                            class="block mt-1 w-full"
                            type="text"
                            name="lname"
                            :value="old('lname')"
                            required
                            autofocus
                            autocomplete="lname" />
                        <x-input-error :messages="$errors->get('lname')"
                            class="mt-2" />
                    </div>
                </div>

                <!-- Email Address -->
                <div>
                    <x-input-label for="email"
                        :value="__('Email')" />
                    <x-text-input id="email"
                        class="block mt-1 w-full"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')"
                        class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password"
                        :value="__('Password')" />

                    <x-text-input id="password"
                        class="block mt-1 w-full"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')"
                        class="mt-2" />
                </div>
                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation"
                        :value="__('Confirm Password')" />

                    <x-text-input id="password_confirmation"
                        class="block mt-1 w-full"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password_confirmation')"
                        class="mt-2" />
                </div>


                <!-- Remember Me -->
                <div class=" mt-4">
                    <label for="remember_me"
                        class="inline-flex items-center">
                        <input id="remember_me"
                            type="checkbox"
                            class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-none dark:focus:ring-non dark:focus:ring-offset-gray-800"
                            name="remember">
                        <span
                            class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                    </label>
                </div>
                <div class="flex flex-col items-center justify-center gap-4">
                    {{-- Login Button --}}
                    <x-primary-button
                        class="bg-lightMode-primary hover:bg-lightMode-blueHighlight mt-4 w-full justify-center">
                        {{ __('Create my account') }}
                    </x-primary-button>

                    {{-- Login and social buttons divider --}}
                    <div class="flex items-center w-full">
                        <div class="border-t border-gray-400 h-0 w-full mx-4">
                        </div>

                        <span class="text-gray-400"">OR</span>

                        <div class=" border-t border-gray-400 h-0 w-full mx-4">
                        </div>
                    </div>
                    {{-- Facebook Login --}}
                    <div
                        class="w-full flex bg-[#316FF6] hover:bg-[#316FF6] rounded-full ">
                        <div
                            class="border border-[#316FF6] rounded-full p-2 w-fit bg-white">
                            <img src="{{ Vite::asset('/public/svg-icons/fb.svg') }}"
                                class="w-6 "
                                alt="">
                        </div>
                        <div
                            class="flex justify-center px-4 py-2 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm dark:hover:bg-gray-700 focus:outline-none disabled:opacity-25 transition ease-in-out duration-150  w-full ">
                            <button class=" text-white ">
                                {{ __('Continue with Facebook') }}
                            </button>
                        </div>
                    </div>
                    {{-- Google Login --}}
                    <div
                        class="w-full flex bg-[#DB4437] hover:bg-[#DB4437] rounded-full">
                        <div
                            class="border border-[#DB4437] rounded-full p-2 w-fit bg-white">
                            <img src="{{ Vite::asset('/public/svg-icons/google.svg') }}"
                                class="w-6 "
                                alt="">
                        </div>
                        <div
                            class="flex justify-center px-4 py-2 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm dark:hover:bg-gray-700 focus:outline-none disabled:opacity-25 transition ease-in-out duration-150  w-full">
                            <button class=" text-white ">
                                {{ __('Continue with Google') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
        {{-- Branding --}}
        <section class="w-1/2 p-8 bg-lightMode-primary text-center">
            <x-application-logo class="text-3xl text-white pt-10" />
            <h4 class="text-white">Connect with the world and
                friends around you on Connectify</h4>
            {{-- login button --}}

            <div class="mt-4">
                <a href="{{ route('login') }}">
                    <x-primary-button
                        class="bg-transparent hover:bg-lightMode-blueHighlight text-black rounded-3xl border-spacing-2 border-white p-2">
                        {{ __('Login') }}
                    </x-primary-button>
                </a>
            </div>
        </section>
    </main>
</x-guest-layout>
