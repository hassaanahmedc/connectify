<x-guest-layout>
    <main class="flex gap-10">
        {{-- Branding --}}
        <section class="w-1/2 p-8 bg-lightMode-primary text-center">
            <x-application-logo class="text-3xl text-white pt-10" />
            <h4 class="text-white">Connect with the world and
                friends around you on Connectify</h4>
            {{-- Sign up button --}}
            <div class="mt-4">
                <a href="{{ route('register') }}">
                    <x-primary-button
                        class="bg-transparent hover:bg-lightMode-blueHighlight text-black rounded-3xl border-spacing-2 border-white p-2">
                        {{ __('Sign-up') }}
                    </x-primary-button>
                </a>
            </div>
        </section>
        {{-- Login Form --}}
        <section class="w-1/2  p-8">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4"
                :status="session('status')" />

            <h1
                class="mb-4 font-montserrat text-2xl text-lightMode-primary font-bold">
                Login to your account</h1>
            <form method="POST"
                action="{{ route('login') }}">
                @csrf

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

                <!-- Remember Me -->
                <div class="flex items-center justify-between mt-4">
                    <label for="remember_me"
                        class="inline-flex items-center">
                        <input id="remember_me"
                            type="checkbox"
                            class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-none dark:focus:ring-non dark:focus:ring-offset-gray-800"
                            name="remember">
                        <span
                            class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                    </label>
                    {{-- Forgot Password --}}
                    <div class="">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:text-indigo-500"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif

                    </div>
                </div>
                <div class="flex flex-col items-center justify-center gap-4">
                    {{-- Login Button --}}
                    <x-primary-button
                        class="bg-lightMode-primary hover:bg-lightMode-blueHighlight mt-4 w-full justify-center">
                        {{ __('Log in') }}
                    </x-primary-button>

                    {{-- Login and social buttons divider --}}
                    <div class="flex items-center w-full">
                        <div class="border-t border-gray-400 h-0 w-full mx-4">
                        </div>

                        <span class="text-gray-400"">OR</span>

                        <div class="border-t border-gray-400 h-0 w-full mx-4">
                        </div>
                    </div>
                    {{-- Facebook Login --}}
                    <div
                        class="w-full flex bg-[#316FF6] hover:bg-[#316FF6] rounded-full">
                        <div
                            class="border border-[#316FF6] rounded-full p-2 w-fit bg-white">
                            <img src="{{ Vite::asset('/public/svg-icons/fb.svg') }}"
                                class="w-6 "
                                alt="">
                        </div>
                        <div
                            class="flex justify-center px-4 py-2 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm dark:hover:bg-gray-700 focus:outline-none disabled:opacity-25 transition ease-in-out duration-150  w-full">
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
                            class="flex justify-center px-4 py-2 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm dark:hover:bg-gray-700 focus:outline-none disabled:opacity-25 transition ease-in-out duration-150  w-full">
                            <button class=" text-white ">
                                {{ __('Continue with Google') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>
</x-guest-layout>
