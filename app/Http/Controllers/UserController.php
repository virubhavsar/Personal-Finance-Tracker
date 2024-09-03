<?php

namespace App\Http\Controllers;

use App\Http\Requests\ToggleActiveStatusRequest;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\DeleteUserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function users_manage()
    {
        $users = $this->userService->getAllUsersWithRoles();
        return response()->json($users);
    }

    public function toggleActiveStatus($id, ToggleActiveStatusRequest $request)
    {
        $this->userService->toggleActiveStatus($id, $request->validated());
        return response()->json(['message' => 'User active status updated successfully']);
    }

    public function editUser($id, EditUserRequest $request)
    {
        $this->userService->editUser($id, $request->validated());
        return response()->json(['message' => 'User updated successfully']);
    }

    public function deleteUser($id, DeleteUserRequest $request)
    {
        $this->userService->deleteUser($id);
        return response()->json(['message' => 'User deleted successfully']);
    }
}
