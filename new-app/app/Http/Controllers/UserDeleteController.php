<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;

class UserDeleteController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    // Delete a user by ID
    public function destroy($id)
    {
        // Delegate user deletion logic to AuthService
        return $this->authService->deleteUser($id);
    }
}
