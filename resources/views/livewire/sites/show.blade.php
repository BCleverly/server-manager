<div class="w-full min-h-[60vh] flex flex-col items-center justify-center p-6">
    <div class="w-full max-w-4xl">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold">{{ $this->site->name }}</h1>
                <p class="mt-2 text-base text-zinc-600 dark:text-zinc-300">{{ __('Site details and configuration.') }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('sites.edit', $this->site) }}" class="btn btn-primary">
                    {{ __('Edit Site') }}
                </a>
                <a href="{{ route('sites.index') }}" class="btn btn-outline">
                    {{ __('Back to Sites') }}
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Basic Information -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">{{ __('Basic Information') }}</h2>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="font-medium">{{ __('Domain') }}:</span>
                            <span class="text-sm">{{ $this->site->domain }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="font-medium">{{ __('PHP Version') }}:</span>
                            <span class="badge badge-primary">{{ $this->site->php_version }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="font-medium">{{ __('Folder') }}:</span>
                            <span class="text-sm font-mono">{{ $this->site->folder }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="font-medium">{{ __('Created') }}:</span>
                            <span class="text-sm">{{ $this->site->created_at->format('M j, Y \a\t g:i A') }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="font-medium">{{ __('Last Updated') }}:</span>
                            <span class="text-sm">{{ $this->site->updated_at->format('M j, Y \a\t g:i A') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- HTTPS Status -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">{{ __('HTTPS Configuration') }}</h2>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="font-medium">{{ __('Let\'s Encrypt HTTPS') }}:</span>
                            @if($this->isHttpsEnabled)
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                    <span class="text-sm text-green-600 dark:text-green-400">{{ __('Enabled') }}</span>
                                </div>
                            @else
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('Disabled') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Repository Information -->
            @if($this->hasRepository)
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">{{ __('Repository') }}</h2>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="font-medium">{{ __('Repository URL') }}:</span>
                            <a href="{{ $this->site->repository }}" target="_blank" class="text-sm text-primary hover:underline">
                                {{ $this->site->repository }}
                            </a>
                        </div>
                        
                        @if($this->site->repository_branch)
                        <div class="flex justify-between items-center">
                            <span class="font-medium">{{ __('Branch') }}:</span>
                            <span class="badge badge-outline">{{ $this->site->repository_branch }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Deployment Status -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">{{ __('Deployment Status') }}</h2>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="font-medium">{{ __('Status') }}:</span>
                            @if($this->site->deployment_status)
                                <span class="badge badge-{{ $this->site->deployment_status === 'success' ? 'success' : ($this->site->deployment_status === 'failed' ? 'error' : 'warning') }}">
                                    {{ ucfirst($this->site->deployment_status) }}
                                </span>
                            @else
                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('No deployments yet') }}</span>
                            @endif
                        </div>
                        
                        @if($this->site->deployments_count > 0)
                        <div class="flex justify-between items-center">
                            <span class="font-medium">{{ __('Total Deployments') }}:</span>
                            <span class="text-sm">{{ $this->site->deployments_count }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Deployments -->
        @if($this->hasDeployments)
        <div class="card bg-base-100 shadow-xl mt-6">
            <div class="card-body">
                <h2 class="card-title">{{ __('Recent Deployments') }}</h2>
                
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Deployed At') }}</th>
                                <th>{{ __('Duration') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($this->site->deployments->take(5) as $deployment)
                            <tr>
                                <td>
                                    <span class="badge badge-{{ $deployment->status === 'success' ? 'success' : ($deployment->status === 'failed' ? 'error' : 'warning') }}">
                                        {{ ucfirst($deployment->status) }}
                                    </span>
                                </td>
                                <td>{{ $deployment->created_at->diffForHumans() }}</td>
                                <td>{{ $deployment->duration ?? 'N/A' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div> 