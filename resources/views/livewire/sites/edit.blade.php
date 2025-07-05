<div class="w-full min-h-[60vh] flex flex-col items-center justify-center p-6">
    <div class="w-full max-w-2xl">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold">{{ __('Edit Site') }}</h1>
                <p class="mt-2 text-base text-zinc-600 dark:text-zinc-300">{{ __('Update your site configuration.') }}</p>
            </div>
            <a href="{{ route('sites.index') }}" class="btn btn-outline">
                {{ __('Back to Sites') }}
            </a>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <form wire:submit="save">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Site Name -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">{{ __('Site Name') }}</span>
                            </label>
                            <input 
                                type="text" 
                                wire:model="form.name" 
                                class="input input-bordered @error('form.name') input-error @enderror"
                                placeholder="{{ __('Enter site name') }}"
                            />
                            @error('form.name')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <!-- Domain -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">{{ __('Domain') }}</span>
                            </label>
                            <input 
                                type="text" 
                                wire:model="form.domain" 
                                class="input input-bordered @error('form.domain') input-error @enderror"
                                placeholder="{{ __('example.com') }}"
                            />
                            @error('form.domain')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <!-- PHP Version -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">{{ __('PHP Version') }}</span>
                            </label>
                            <select wire:model="form.php_version" class="select select-bordered @error('form.php_version') select-error @enderror">
                                <option value="">{{ __('Select PHP version') }}</option>
                                @foreach($form->phpVersions as $version)
                                    <option value="{{ $version }}">PHP {{ $version }}</option>
                                @endforeach
                            </select>
                            @error('form.php_version')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <!-- Folder -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">{{ __('Folder') }}</span>
                            </label>
                            <input 
                                type="text" 
                                wire:model="form.folder" 
                                class="input input-bordered @error('form.folder') input-error @enderror"
                                placeholder="{{ __('/var/www/site') }}"
                            />
                            @error('form.folder')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <!-- Repository -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">{{ __('Repository URL') }}</span>
                            </label>
                            <input 
                                type="url" 
                                wire:model="form.repository" 
                                class="input input-bordered @error('form.repository') input-error @enderror"
                                placeholder="{{ __('https://github.com/user/repo') }}"
                            />
                            @error('form.repository')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <!-- Repository Branch -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">{{ __('Repository Branch') }}</span>
                            </label>
                            <input 
                                type="text" 
                                wire:model="form.repository_branch" 
                                class="input input-bordered @error('form.repository_branch') input-error @enderror"
                                placeholder="{{ __('main') }}"
                            />
                            @error('form.repository_branch')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>

                    <!-- Let's Encrypt HTTPS -->
                    <div class="form-control mt-6">
                        <label class="label cursor-pointer">
                            <span class="label-text">{{ __('Enable Let\'s Encrypt HTTPS') }}</span>
                            <input 
                                type="checkbox" 
                                wire:model="form.letsencrypt_https_enabled" 
                                class="toggle toggle-primary"
                            />
                        </label>
                        @error('form.letsencrypt_https_enabled')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end mt-6">
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                            <span wire:loading.remove>{{ __('Update Site') }}</span>
                            <span wire:loading>{{ __('Updating...') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 