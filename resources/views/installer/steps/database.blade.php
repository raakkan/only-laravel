<div class="mb-8 bg-purple-100 rounded-xl p-4 sm:p-6">
    <h3 class="text-lg sm:text-xl font-semibold mb-3 text-purple-700">Submit Database Details</h3>
    <div class="space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <span class="font-medium mb-1 sm:mb-0">Database Connection</span>
            <select id="db_connection" wire:model="inputs.db_connection"
                class="mt-1 block w-full sm:w-48 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md bg-white shadow-sm">
                <option value="mysql">MySQL</option>
                <option value="pgsql">PostgreSQL</option>
                <option value="sqlite">SQLite</option>
                <option value="sqlsrv">SQL Server</option>
            </select>
        </div>
        @foreach (['db_host' => 'Database Host', 'db_port' => 'Database Port', 'db_database' => 'Database Name', 'db_username' => 'Database Username', 'db_password' => 'Database Password'] as $key => $label)
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <span class="font-medium mb-1 sm:mb-0">{{ $label }}</span>
                <input type="{{ $key === 'db_password' ? 'password' : 'text' }}" id="{{ $key }}"
                    wire:model="inputs.{{ $key }}"
                    placeholder="{{ $key === 'db_host' ? 'localhost' : ($key === 'db_port' ? '3306' : '') }}"
                    class="mt-1 block w-full sm:w-48 px-3 py-2 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md bg-white shadow-sm">
            </div>
        @endforeach
    </div>
</div>
