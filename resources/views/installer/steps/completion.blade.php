<div class="text-center">
    <div class="mb-8">
        <svg class="mx-auto h-24 w-24 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    </div>

    <h3 class="text-2xl font-bold text-gray-900 mb-4">Installation Successful!</h3>

    <p class="text-gray-600 mb-8">
        Your OnlyLaravel installation has been completed successfully. You can now access your website.
    </p>

    <div class="flex justify-center space-x-4">
        <a href="{{ url('/') }}"
            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700">
            Go to Homepage
        </a>

        <a href="{{ url('/admin') }}"
            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
            Go to Admin Panel
        </a>
    </div>
</div>
