@php($hasSites = $sites->count() > 0)
<section class="w-full min-h-[60vh] flex flex-col items-center justify-center p-6">
    <flux:heading size="xl">{{ __('Sites') }}</flux:heading>
    <p class="mt-2 text-base text-zinc-600 dark:text-zinc-300">{{ __('Manage your server sites here.') }}</p>

    @if($hasSites)
        <div class="w-full mt-8">
            <div class="overflow-x-auto rounded-lg shadow bg-base-100">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Domain') }}</th>
                            <th>{{ __('Folder') }}</th>
                            <th>{{ __('PHP Version') }}</th>
                            <th>{{ __('Created') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sites as $site)
                            <tr>
                                <td>{{ $site->name }}</td>
                                <td>{{ $site->domain }}</td>
                                <td>{{ $site->folder }}</td>
                                <td>{{ $site->php_version }}</td>
                                <td>{{ $site->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="#" class="btn btn-xs btn-outline">{{ __('View') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $sites->links() }}</div>
        </div>
    @else
        <div class="flex flex-1 flex-col items-center justify-center min-h-[40vh]">
            <a href="{{ route('sites.create') }}" class="btn btn-primary btn-lg">{{ __('Create a new site now') }}</a>
        </div>
    @endif
</section> 