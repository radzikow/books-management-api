<?php

namespace App\Services\Users;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserService
{
    /**
     * Get user by id or auth user.
     *
     * @param int|null $id
     *
     * @return User
     */
    public function getUserByIdOrAuthUser(int $id = null): User
    {
        if ($id) {
            return User::find($id);
        }
        return auth()->user();
    }

    /**
     * Select specific fields from user model.
     *
     * @param object $query
     *
     * @return BelongsTo
     */
    public function selectUserFields($query): BelongsTo
    {
        return $query->select('id', 'first_name', 'last_name', 'email');
    }
}
