<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-sm text-white dark:text-gray-800 hover:bg-gray-700 dark:hover:bg-white transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
