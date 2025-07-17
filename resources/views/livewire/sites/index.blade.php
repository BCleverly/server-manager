@php($hasSites = $sites->count() > 0)
<section class="w-full min-h-[60vh] flex flex-col items-center justify-center p-6">
    <div class="w-full max-w-6xl">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold">{{ __('Sites') }}</h1>
                <p class="mt-2 text-base text-zinc-600 dark:text-zinc-300">{{ __('Manage your server sites here.') }}</p>
            </div>
            <a href="{{ route('sites.create') }}" class="btn btn-primary">
                {{ __('Create New Site') }}
            </a>
        </div>

        @if($hasSites)
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full">
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Domain') }}</th>
                                    <th>{{ __('Folder') }}</th>
                                    <th>{{ __('PHP Version') }}</th>
                                    <th>{{ __('HTTPS') }}</th>
                                    <th>{{ __('Created') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sites as $site)
                                    <livewire:sites.row :site="$site" :key="$site->id" />
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="mt-4">{{ $sites->links() }}</div>
        @else
            <div class="flex flex-1 flex-col items-center justify-center min-h-[40vh]">
                <div class="text-center">
                    <h3 class="text-lg font-semibold mb-4">{{ __('No sites found') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">{{ __('Get started by creating your first site.') }}</p>
                    <a href="{{ route('sites.create') }}" class="btn btn-primary btn-lg">{{ __('Create a new site now') }}</a>
                </div>
            </div>
        @endif
    </div>
</section> 