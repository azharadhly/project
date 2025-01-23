<?php

// app/Http/Controllers/RegisterController.php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {

        // Pass request data to AuthService for validation and registration
        return $this->authService->register($request->all());
    }
}
