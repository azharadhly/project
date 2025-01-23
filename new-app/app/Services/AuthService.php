<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    // Validate and register a new user
    public function register(array $data)
    {
   
        $validate = $this->registervalidation($data);
        if(!empty($validate['error'])) return response()->json(['message'=> $validate['error']],$validate['code']);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']), // Hash the password
        ]);

        // Return success response
        return response()->json(['message' => 'User registered successfully!'], 201);
    }

    // Validate login credentials and generate token
    public function login(array $data)
    {
    
        $validate = $this->validation($data);
        if(!empty($validate)) return response()->json(['message'=> $validate['error']],$validate['code']);
   


        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            // Authentication successful, generate an API token
            $user = Auth::user();
            $token = $user->createToken('MyApp')->plainTextToken; // Generate token using Sanctum

            // Return the generated token with a success message
            return response()->json([
                'message' => 'Login successful',
                'token' => $token
            ], 200);
        } else {
            // Authentication failed, return error message
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }

    // Delete a user by ID
    public function deleteUser($id)
    {
        // Find the user by ID
        $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Delete the user
        $user->delete();

        // Return success message
        return response()->json(['message' => 'User deleted successfully'], 200);
    }

    // Update a user's details by ID
    public function updateUser(array $data, $id)
    {
       $this->validation($data);

        // Find the user by ID
        $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Update the user's details if provided
        if (isset($data['name'])) {
            $user->name = $data['name'];
        }
        if (isset($data['email'])) {
            $user->email = $data['email'];
        }
        if (isset($data['password'])) {
            $user->password = Hash::make($data['password']); // Hash the new password
        }

        // Save the updated user information
        $user->save();
        return response()->json(['message' => 'User updated successfully'], 200);
    }

    public function validation($data){
         // Validate the incoming data
         $validator = Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // If validation fails, return the error response with specific validation errors
        if ($validator->fails()) {
            return ['error' => $validator->errors(),'code' => 422];
        }
    }

    public function registervalidation($data){
        // Validate the incoming data
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
       ]);

       // If validation fails, return the error response with specific validation errors
       if ($validator->fails()) {
           return ['error' => $validator->errors(),'code' => 422];
       }
   }
}
