<div class="mb-8 bg-blue-100 rounded-xl p-4 sm:p-6">
    <h3 class="text-lg sm:text-xl font-semibold mb-3 text-blue-700">Folder Permissions</h3>
    <ul class="space-y-2">
        @foreach ($folders as $folder => $isWritable)
            <li class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <span class="font-medium mb-1 sm:mb-0">{{ $folder }}</span>
                @if ($isWritable)
                    <span class="text-green-600 font-semibold bg-green-100 px-3 py-1 rounded-full">✓ Writable</span>
                @else
                    <span class="text-red-600 font-semibold bg-red-100 px-3 py-1 rounded-full">✗ Not Writable</span>
                @endif
            </li>
        @endforeach
    </ul>
</div>
