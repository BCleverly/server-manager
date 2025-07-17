<div class="flex flex-col h-full w-full justify-center items-center p-4 gap-2">
    <div class="text-lg font-semibold">Server Performance</div>
    <div class="flex flex-col gap-1 w-full">
        <div class="flex justify-between">
            <span>CPU Usage:</span>
            <span class="font-mono">{{ $stats['cpu'] !== null ? $stats['cpu'] . '%' : '—' }}</span>
        </div>
        <div class="flex justify-between">
            <span>Memory Usage:</span>
            <span class="font-mono">{{ $stats['memory'] !== null ? $stats['memory'] . ' MB' : '—' }}</span>
        </div>
        <div class="flex justify-between">
            <span>Load Average:</span>
            <span class="font-mono">{{ $stats['load'] !== null ? $stats['load'] : '—' }}</span>
        </div>
        <div class="flex justify-between text-xs text-gray-500 mt-2">
            <span>Last Updated:</span>
            <span>{{ $stats['updated_at'] ? \Carbon\Carbon::parse($stats['updated_at'])->diffForHumans() : '—' }}</span>
        </div>
    </div>
    <div wire:loading.flex wire:target="updateStats" class="mt-2 text-xs text-blue-500">Updating...</div>
</div> 