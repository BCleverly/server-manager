<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Site;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SitePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any sites.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the site.
     */
    public function view(User $user, Site $site): bool
    {
        return $user->id === $site->user_id;
    }

    /**
     * Determine whether the user can create sites.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the site.
     */
    public function update(User $user, Site $site): bool
    {
        return $user->id === $site->user_id;
    }

    /**
     * Determine whether the user can delete the site.
     */
    public function delete(User $user, Site $site): bool
    {
        return $user->id === $site->user_id;
    }

    /**
     * Determine whether the user can restore the site.
     */
    public function restore(User $user, Site $site): bool
    {
        return $user->id === $site->user_id;
    }

    /**
     * Determine whether the user can permanently delete the site.
     */
    public function forceDelete(User $user, Site $site): bool
    {
        return $user->id === $site->user_id;
    }
} 