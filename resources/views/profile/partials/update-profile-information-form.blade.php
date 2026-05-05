<section>

    <form method="post" action="{{ route('profile.update', $user->id) }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="flex items-center gap-5 w-full">
            <div class="flex-1">
                <x-input-label for="fname" class="block text-xs font-bold text-gray-700 tracking-wide uppercase mb-1" :value="__('First Name')" />
                <x-text-input id="fname" name="fname" type="text" class="mt-1 block w-full" :value="old('fname', $user->fname)" required autofocus autocomplete="fname" />
                <x-input-error class="mt-2" :messages="$errors->get('fname')" />
            </div>

            <div class="flex-1">
                <x-input-label for="lname" class="block text-xs font-bold text-gray-700 tracking-wide uppercase mb-1" :value="__('Last Name')" />
                <x-text-input id="lname" name="lname" type="text" class="mt-1 block w-full" :value="old('lname', $user->lname)" required autofocus autocomplete="lname" />
                <x-input-error class="mt-2" :messages="$errors->get('lname')" />
            </div>
        
        </div>


        <div>
            <x-input-label for="email" class="block text-xs font-bold text-gray-700 tracking-wide uppercase mb-1" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-gray-50 mt-6">
            <button type="submit" class="px-5 py-2.5 bg-lightMode-primary text-white text-sm font-bold 
                rounded-xl hover:bg-blue-700 shadow-sm transition-all duration-200">
                {{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }"
                     x-show="show"
                     x-init="setTimeout(() => show = false, 3000)"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-1"
                     class="flex items-center gap-2 text-sm text-green-600 font-semibold bg-green-50 px-3 py-2 rounded-xl border border-green-100">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 8" />
                    </svg>
                    <span>Saved.</span>
                </div>
            @endif
        </div>
    </form>
</section>
