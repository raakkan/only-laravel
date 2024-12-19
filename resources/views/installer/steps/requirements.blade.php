<div class="mb-8 bg-purple-100 rounded-xl p-4 sm:p-6">
    <h3 class="text-lg sm:text-xl font-semibold mb-3 text-purple-700">PHP Version</h3>
    <p class="mb-3">Current: <span class="font-mono">{{ $phpVersion['current'] }}</span> (Minimum: <span
            class="font-mono">{{ $phpVersion['minimum'] }}</span>)</p>
    <div class="flex items-center">
        <span class="mr-3">Status:</span>
        @if ($phpVersion['supported'])
            <span class="text-green-600 font-semibold bg-green-100 px-3 py-1 rounded-full">✓ Supported</span>
        @else
            <span class="text-red-600 font-semibold bg-red-100 px-3 py-1 rounded-full">✗ Not Supported</span>
        @endif
    </div>
</div>

@foreach ($requirements as $type => $requirement)
    @if ($type !== 'errors')
        <div class="mb-8 bg-pink-100 rounded-xl p-4 sm:p-6">
            <h3 class="text-lg sm:text-xl font-semibold mb-3 text-pink-700">
                @if ($type === 'php')
                    PHP Extensions
                @elseif ($type === 'server')
                    Web Server
                @elseif ($type === 'database')
                    Database
                @else
                    {{ ucfirst($type) }} Requirements
                @endif
            </h3>
            <ul class="space-y-2">
                @foreach ($requirement as $extension => $enabled)
                    <li class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <span class="font-medium mb-1 sm:mb-0">
                            @if ($type === 'server')
                                @if ($extension === 'mod_rewrite')
                                    Rewrite Module
                                @elseif ($extension === 'mod_headers')
                                    Headers Module
                                @else
                                    {{ $extension }}
                                @endif
                            @elseif ($type === 'database' && $extension === 'mysql')
                                MySQL/MariaDB Version
                            @else
                                {{ $extension }}
                            @endif
                        </span>
                        @if ($enabled)
                            <span class="text-green-600 font-semibold bg-green-100 px-3 py-1 rounded-full">✓
                                @if ($type === 'php')
                                    Enabled
                                @else
                                    Supported
                                @endif
                            </span>
                        @else
                            <span class="text-red-600 font-semibold bg-red-100 px-3 py-1 rounded-full">✗
                                @if ($type === 'php')
                                    Not Enabled
                                @else
                                    Not Supported
                                @endif
                            </span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
@endforeach
