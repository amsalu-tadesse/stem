<?php

namespace App\Policies;

use App\Models\FAQ;
use App\Models\User;
 use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class FAQPolicy
{
    /**
     * Determine whether the user can view any models.
     */

    /**
     * @var string
     */
    use HandlesAuthorization;
     protected string $model = FAQ::class;
    public function viewAny(User $user): bool
    {
        return true;
    }


    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, FAQ $FAQ):  bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user):  bool
    {
        return true;
    }
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, FAQ $FAQ):  bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FAQ $FAQ): bool
    {
        return $user->id === $FAQ->created_by;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, FAQ $FAQ)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, FAQ $FAQ):  bool
    {
        return true;
    }
    public function toggleStatus(User $user, Faq $FAQ):  bool
    {
        return true;
    }
}
