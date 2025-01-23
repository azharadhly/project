<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;

class UserUpdateController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    // Update a user's details by ID
    public function update(Request $request, $id)
    {
        // Delegate user update logic to AuthService
        return $this->authService->updateUser($request->all(), $id);
    }
}
