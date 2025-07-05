<div class="card bg-base-200 shadow-xl w-full">
    <div class="card-body">
        <h2 class="card-title mb-4">Folder Status</h2>
        
        <div class="space-y-3">
            <div class="flex items-center gap-2">
                <span class="font-medium">Path:</span>
                <span class="badge badge-secondary">{{ $path }}</span>
            </div>
            
            <div class="flex items-center gap-2">
                <span class="font-medium">System:</span>
                <span class="badge badge-info">{{ $system }}</span>
            </div>
            
            <div class="flex items-center gap-2">
                <span class="font-medium">Exists:</span>
                @if($exists)
                    <span class="badge badge-success">Yes</span>
                @else
                    <span class="badge badge-error">No</span>
                @endif
            </div>
            
            @if($exists)
                <div class="flex items-center gap-2">
                    <span class="font-medium">Permissions:</span>
                    <span class="badge badge-outline">{{ $permissions }}</span>
                </div>
                
                <div class="flex items-center gap-2">
                    <span class="font-medium">Owner:</span>
                    <span class="badge badge-outline">{{ $owner }}</span>
                </div>
                
                <div class="flex items-center gap-2">
                    <span class="font-medium">Group:</span>
                    <span class="badge badge-outline">{{ $group }}</span>
                </div>
            @else
                <div class="alert alert-error mt-4">
                    <span>Folder does not exist on the server.</span>
                </div>
            @endif
        </div>
    </div>
</div> 