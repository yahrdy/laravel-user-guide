<?php

namespace Hridoy\LaravelUserGuide\Policies;

use App\Models\User;
use Hridoy\LaravelUserGuide\Models\UserGuide;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserGuidePolicy
{
    use HandlesAuthorization;

    private $checkPermission;

    public function __construct()
    {
        $this->checkPermission = config('user_guide.user-guide-permissions.enabled');
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function viewAny(User $user)
    {
        return !$this->checkPermission || $user->can('view any user guide');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @return bool
     */
    public function view(User $user, UserGuide $userGuide): bool
    {
        return !$this->checkPermission || $user->can('view user guide');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return !$this->checkPermission || $user->can('create user guide');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @return Response|bool
     */
    public function update(User $user, UserGuide $userGuide)
    {
        return !$this->checkPermission || $user->can('edit user guide');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @return Response|bool
     */
    public function delete(User $user, UserGuide $userGuide)
    {
        return !$this->checkPermission || $user->can('delete user guide');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @return Response|bool
     */
    public function restore(User $user, UserGuide $userGuide)
    {
        return !$this->checkPermission || $user->can('view user guide');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @return Response|bool
     */
    public function forceDelete(User $user, UserGuide $userGuide)
    {
        return !$this->checkPermission || $user->can('view user guide');
    }
}
