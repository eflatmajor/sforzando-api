<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, true)) {
            $request->session()->regenerate();

            $user = User::where('email', $request->email)->first();

            return response()->json([
                "user" => $user
            ]);
        }

        return response()->json([
            "message" => 'The provided credentials do not match our records.'
        ]);
    }

    public function register(Request $request): JsonResponse
    {
        $registerUserData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:8'
        ]);
        $user = User::create([
            'name' => $registerUserData['name'],
            'email' => $registerUserData['email'],
            'password' => Hash::make($registerUserData['password']),
        ]);
        event(new Registered($user));
        return response()->json([
            'message' => 'User Created',
        ]);
    }

    public function user(Request $request)
    {
        return $request->user();
    }

    // public function register()
    // {

    // }

    // public function login(Request $request): RedirectResponse
    // {
    //     $credentials = $request->validate([
    //         'email' => ['required', 'email'],
    //         'password' => ['required'],
    //     ]);
 
    //     if (Auth::attempt($credentials)) {
    //         $request->session()->regenerate();
 
    //         return response()->json(['test' => 'success']);;
    //     }
        
    //     return response()->json(['test' => 'failure']);
    // }
}
