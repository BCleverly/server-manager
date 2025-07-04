<div class="card bg-base-200 shadow-xl w-full">
    <div class="card-body">
        <h2 class="card-title">Folder Status</h2>
        <div class="mb-2">
            <span class="font-semibold">Path:</span>
            <span class="ml-2 badge badge-ghost badge-lg">{{ $path }}</span>
        </div>
        <div class="mb-2">
            <span class="font-semibold">System:</span>
            <span class="ml-2 badge badge-info badge-lg">{{ $system }}</span>
        </div>
        <div class="mb-4">
            <span class="font-semibold">Exists:</span>
            <span class="ml-2">
                @if($exists)
                    <span class="badge badge-success badge-lg">Yes</span>
                @else
                    <span class="badge badge-error badge-lg">No</span>
                @endif
            </span>
        </div>
        @if($exists)
            <div class="mb-2">
                <span class="font-semibold">Permissions:</span>
                <span class="ml-2 badge badge-outline badge-lg">{{ $permissions }}</span>
            </div>
            <div class="mb-2">
                <span class="font-semibold">Owner:</span>
                <span class="ml-2 badge badge-outline badge-lg">{{ $owner }}</span>
            </div>
            <div class="mb-2">
                <span class="font-semibold">Group:</span>
                <span class="ml-2 badge badge-outline badge-lg">{{ $group }}</span>
            </div>
        @else
            <div class="alert alert-error mt-4">
                <span>Folder does not exist on the server.</span>
            </div>
        @endif
    </div>
</div> 