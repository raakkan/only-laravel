<div class="mb-8 bg-blue-100 rounded-xl p-4 sm:p-6">
    <h3 class="text-lg sm:text-xl font-semibold mb-3 text-blue-700">Environment Configuration</h3>

    @if ($isEnvWritable)
        <p class="mb-3 text-green-600">The .env file is writable. The installer will automatically create it for you.</p>
    @else
        <p class="mb-3 text-yellow-600">The .env file is not writable. Please create it manually with the following
            content:</p>
        <div class="bg-gray-100 p-4 rounded-lg mb-4">
            <pre class="whitespace-pre-wrap font-mono text-sm">{{ $envContent }}</pre>
        </div>
        <p class="text-sm text-gray-600">After creating the .env file, please ensure to set the appropriate values for
            your environment.</p>
    @endif
</div>

@if (!$isEnvWritable)
    <div class="mb-8 bg-yellow-100 rounded-xl p-4 sm:p-6">
        <h4 class="text-md font-semibold mb-2 text-yellow-700">Important Note</h4>
        <p>After creating the .env file, you need to generate an APP_KEY. Run the following command in your project
            root:</p>
        <div class="bg-gray-100 p-2 rounded-lg my-2">
            <code class="font-mono text-sm">php artisan key:generate</code>
        </div>
        <p class="text-sm text-gray-600">This command will set a random application key, which is crucial for encrypting
            your data.</p>
    </div>
@endif

<div class="flex justify-between items-center mt-6">
    <button type="button" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300"
        onclick="window.history.back()">Previous</button>
    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Next</button>
</div>
