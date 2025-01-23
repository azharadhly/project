<?php
namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        // Pass request data to AuthService for validation and login
        return $this->authService->login($request->all());
    }
}
