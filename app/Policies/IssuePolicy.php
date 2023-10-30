<?php

namespace App\Policies;

use App\Models\Issue;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class IssuePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Issue $issue): bool
    {

        return true;
      /*  $own = $user->id == $issue->created_by;
        if($own) return $own;

        $own_level = false;
        $db_role = 'BMO-MDA-CSO';

        $userRoles = $user->getRoleNames();


        if ($userRoles->count() === 1 || $userRoles->first() === $db_role) {
            //do nothing. he should see his own records only.
        } else if ($user->hasRole('Working Groups')) //working groups.
        {
            $own_level = in_array($issue->issueWorkingGroup->workingGroup,$user?->workingGroups->pluck('id')->toArray());

        } else {
            $own_level = $user->organization->organization_level_id == $issue->level->id;
        }



        return $own_level;*/
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Issue $issue): bool
    {
        return true;
        /*$own = $user->id == $issue->created_by;
        if($own) return $own;

        $own_level = false;
        $db_role = 'BMO-MDA-CSO';

        $userRoles = $user->getRoleNames();


        if ($userRoles->count() === 1 || $userRoles->first() === $db_role) {
            //do nothing. he should see his own records only.
        } else if ($user->hasRole('Working Groups')) //working groups.
        {
            $own_level = in_array($issue->issueWorkingGroup->workingGroup,$user?->workingGroups->pluck('id')->toArray());

        } else {
            $own_level = $user->organization->organization_level_id == $issue->level->id;
        }



        return $own_level;*/
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Issue $issue): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Issue $issue): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Issue $issue): bool
    {
        //
    }
}
