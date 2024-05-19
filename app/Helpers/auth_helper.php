<?php

use App\Models\GroupModel;
use Myth\Auth\Models\UserModel;

if (!function_exists('isAdmin')) {
    /**
     * Checks if the current user is an admin.
     *
     * @param int|null $userId The user ID to check. If null, checks the currently logged-in user.
     * @return bool True if the user is an admin, false otherwise.
     */
    function isAdmin($userId = null)
    {
        $auth       = service('authentication');
        $groupModel = new GroupModel();

        // If no user ID is provided, check the current logged-in user
        if ($userId === null) {
            if ($auth->check()) {
                $user   = $auth->user();
                $userId = $user->id;
            } else {
                return false;
            }
        }

        return $groupModel->inGroup($userId, 'admin');
    }
}
