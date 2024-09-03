<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function getAllUsersWithRoles()
    {
        $users = User::all();
        return $users->transform(function ($user) {
            $user->role = $this->getRoleName($user->role);
            return $user;
        });
    }

    public function toggleActiveStatus($id, array $data)
    {
        $user = User::findOrFail($id);
        $user->update(['is_active' => $data['is_active']]);
    }

    public function editUser($id, array $data)
    {
        $role = $data['role'] === "Admin" ? "1" : "2";
        $user = User::findOrFail($id);
        $user->update([
            'username' => $data['username'],
            'role' => $role
        ]);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    }

    private function getRoleName($roleId)
    {
        switch ($roleId) {
            case 1:
                return 'Admin';
            default:
                return 'User';
        }
    }
}
