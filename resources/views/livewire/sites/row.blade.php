<tr
    x-data="{ open: false }"
    @click="window.location = '{{ route('sites.show', $site) }}'"
    class="cursor-pointer hover:bg-base-200 transition-colors"
>
    <td>{{ $site->name }}</td>
    <td>{{ $site->domain }}</td>
    <td>{{ $site->folder }}</td>
    <td>
        <span class="badge badge-primary">{{ $site->php_version }}</span>
    </td>
    <td>
        @if($site->letsencrypt_https_enabled)
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
    </td>
    <td>{{ $site->created_at->diffForHumans() }}</td>
    <td class="relative" @click.stop>
        <div class="dropdown dropdown-end">
            <button
                @click="open = !open"
                class="btn btn-ghost btn-circle"
                aria-label="Actions"
                type="button"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="5" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="12" cy="19" r="1.5"/></svg>
            </button>
            <ul
                x-show="open"
                @click.away="open = false"
                @keydown.escape.window="open = false"
                class="menu menu-sm dropdown-content z-[1] p-2 shadow-lg border border-base-300 bg-base-100 rounded-box w-48"
                style="display: none;"
                x-transition
            >
                <li><a href="{{ route('sites.show', $site) }}" @click.stop>{{ __('View') }}</a></li>
                <li><a href="{{ route('sites.edit', $site) }}" @click.stop>{{ __('Edit') }}</a></li>
                <li>
                    <button type="button" class="w-full text-left" wire:click="toggleHttps" wire:loading.attr="disabled" wire:target="toggleHttps" @click.stop>
                        {{ $site->letsencrypt_https_enabled ? __('Disable HTTPS') : __('Enable HTTPS') }}
                    </button>
                </li>
                <li>
                    <button type="button" class="w-full text-left text-error" wire:click="confirmingDelete = true" @click.stop>
                        {{ __('Delete') }}
                    </button>
                </li>
            </ul>
        </div>
        <!-- Delete Confirmation Modal -->
        <div x-data="{ show: @entangle('confirmingDelete').defer }" x-show="show" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
            <div class="bg-base-100 p-6 rounded shadow-xl w-full max-w-sm">
                <h2 class="text-lg font-bold mb-2">{{ __('Delete Site?') }}</h2>
                <p class="mb-4 text-sm">{{ __('Are you sure you want to delete this site? This action cannot be undone.') }}</p>
                <div class="flex justify-end gap-2">
                    <button class="btn btn-outline btn-sm" @click="show = false">{{ __('Cancel') }}</button>
                    <button class="btn btn-error btn-sm" wire:click="delete" wire:loading.attr="disabled" wire:target="delete">{{ __('Confirm Delete') }}</button>
                </div>
            </div>
        </div>
    </td>
</tr> 