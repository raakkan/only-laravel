<div class="mb-8 bg-purple-100 rounded-xl p-4 sm:p-6">
    <h3 class="text-lg sm:text-xl font-semibold mb-3 text-purple-700">Submit Admin Account Details</h3>
    <div class="space-y-4">
        @foreach (['name' => 'Name', 'email' => 'Email', 'password' => 'Password', 'password_confirmation' => 'Confirm Password'] as $key => $label)
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <span class="font-medium mb-1 sm:mb-0">{{ $label }}</span>
                <input type="{{ in_array($key, ['password', 'password_confirmation']) ? 'password' : 'text' }}"
                    id="admin_{{ $key }}" wire:model="inputs.{{ $key }}"
                    placeholder="{{ $key === 'name' ? 'John Doe' : ($key === 'email' ? 'admin@example.com' : '••••••••') }}"
                    class="mt-1 block w-full sm:w-48 px-3 py-2 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md bg-white shadow-sm">
            </div>
        @endforeach
    </div>
</div>
