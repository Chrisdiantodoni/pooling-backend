<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                "name" => 'required',
                'username' => 'required|unique:users',
                'password' => 'required',
                'nip' => 'required',
                'email' => 'required|unique:users'
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'nip' => $request->nip,
                'username' => $request->username,
                'password' => Hash::make('password'),
            ]);

            return ApiResponse::success($user, 201, 'User registered successfully');
        } catch (ValidationException $e) {
            return ApiResponse::error($e->validator->errors(), 422, 'Validation failed');
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 401, 'Registration failed');
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required',
                'password' => 'required'
            ]);

            $user = User::where('username', $request->username)->first();
            if (!empty($user)) {
                if (Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('access_token')->plainTextToken;
                    return ApiResponse::success($token, 200, 'User Login Successfully');
                } else {
                    return ApiResponse::error(null, 401, 'Login Failed');
                }
            }
        } catch (ValidationException $e) {
            return ApiResponse::error($e->validator->errors(), 422, 'Validation failed');
        } catch (\Exception $e) {
            return ApiResponse::error($e, 401, 'Login Failed');
        }
    }

    public function profile()
    {
        $user = Auth::user();
        return ApiResponse::success($user, 200);
    }

    public function logout()
    {
        $user = Auth::user();
        if (!empty($user)) {
            $user->tokens()->delete();
        }
        return ApiResponse::success('User Logout', 201);
    }
}
