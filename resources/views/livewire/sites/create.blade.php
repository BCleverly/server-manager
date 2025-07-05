<section class="w-full min-h-[60vh] flex flex-col items-center justify-center p-6">
    <div class="w-full max-w-lg">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title mb-6">{{ __('Create Site') }}</h2>
                
                <form wire:submit.prevent="createSite" class="space-y-6">
                    <fieldset class="fieldset border-base-300 rounded-box p-4">
                        <legend class="fieldset-legend text-lg font-semibold mb-2">{{ __('Site Details') }}</legend>
                        
                        <label class="label" for="name">
                            <span class="label-text">{{ __('Site Name') }}</span>
                        </label>
                        <input id="name" type="text" wire:model.defer="form.name" class="input input-bordered w-full" required maxlength="255">
                        @error('form.name') <span class="text-error text-xs mt-1">{{ $message }}</span> @enderror

                        <label class="label mt-2" for="domain">
                            <span class="label-text">{{ __('Domain') }}</span>
                        </label>
                        <input id="domain" type="text" wire:model.defer="form.domain" class="input input-bordered w-full" required maxlength="255">
                        @error('form.domain') <span class="text-error text-xs mt-1">{{ $message }}</span> @enderror

                        <label class="label mt-2" for="folder">
                            <span class="label-text">{{ __('Folder Name') }}</span>
                        </label>
                        <input id="folder" type="text" wire:model.defer="form.folder" class="input input-bordered w-full" required maxlength="255">
                        <p class="text-xs text-zinc-500 mt-1">{{ __('This is the folder name used on disk.') }}</p>
                        @error('form.folder') <span class="text-error text-xs mt-1">{{ $message }}</span> @enderror

                        <label class="label mt-2" for="php_version">
                            <span class="label-text">{{ __('PHP Version') }}</span>
                        </label>
                        <select id="php_version" wire:model.defer="form.php_version" class="select select-primary w-full" required>
                            <option value="" disabled selected>-- {{ __('Select PHP Version') }} --</option>
                            @foreach($form->phpVersions as $version)
                                <option value="{{ $version }}">{{ $version }}</option>
                            @endforeach
                        </select>
                        @error('form.php_version') <span class="text-error text-xs mt-1">{{ $message }}</span> @enderror
                    </fieldset>

                    <fieldset class="fieldset border-base-300 rounded-box p-4">
                        <legend class="fieldset-legend text-lg font-semibold mb-2">{{ __('Repository (Optional)') }}</legend>
                        
                        <label class="label" for="repository">
                            <span class="label-text">{{ __('Repository URL') }}</span>
                        </label>
                        <input id="repository" type="url" wire:model.defer="form.repository" class="input input-bordered w-full" maxlength="255">
                        @error('form.repository') <span class="text-error text-xs mt-1">{{ $message }}</span> @enderror

                        <label class="label mt-2" for="repository_branch">
                            <span class="label-text">{{ __('Repository Branch') }}</span>
                        </label>
                        <input id="repository_branch" type="text" wire:model.defer="form.repository_branch" class="input input-bordered w-full" maxlength="255">
                        @error('form.repository_branch') <span class="text-error text-xs mt-1">{{ $message }}</span> @enderror
                    </fieldset>

                    <fieldset class="fieldset border-base-300 rounded-box p-4">
                        <legend class="fieldset-legend text-lg font-semibold mb-2">{{ __('HTTPS Configuration') }}</legend>
                        
                        <label class="label cursor-pointer">
                            <span class="label-text">{{ __('Enable Let\'s Encrypt HTTPS') }}</span>
                            <input type="checkbox" wire:model.defer="form.letsencrypt_https_enabled" class="toggle toggle-primary">
                        </label>
                        @error('form.letsencrypt_https_enabled') <span class="text-error text-xs mt-1">{{ $message }}</span> @enderror
                    </fieldset>

                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-primary w-full">{{ __('Create Site') }}</button>
                    </div>
                    
                    @if (session('success'))
                        <div class="alert alert-success mt-4">{{ session('success') }}</div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</section> 