<?php

namespace App\Policies;

use App\Models\Profile;
use App\Models\Relation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProfilePolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function viewAny(User $user): bool
    {
        //
    }

    public function view(User $user, Profile $profile): Response
    {
        $follow = Relation::whereFollowerId($user->id)->whereFollowingId($profile->user_id)->exists();

        return ($user->id === $profile->user_id) || $follow
            ? Response::allow()
            : Response::deny('You must be an follower this user .');
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Profile $profile): bool
    {
        return ($user->id === $profile->user_id);
    }

    public function delete(User $user, Profile $profile): bool
    {
        return ($user->id === $profile->user_id);
    }

    public function restore(User $user, Profile $profile): bool
    {
        //
    }

    public function forceDelete(User $user, Profile $profile): bool
    {
        //
    }
}
