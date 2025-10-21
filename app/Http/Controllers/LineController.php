<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LineController extends Controller
{
    public function lineCheckUser(Request $request, $userId)
    {
        try {
            // Handle the LINE authentication logic here
            if ($userId && User::where('line_user_id', $userId)->exists()) {
                $user = User::where('line_user_id', $userId)->first();
                Auth::login($user);
            } else {
                // User does not exist, handle accordingly
                return response()->json([
                    'error' => 'User not found or invalid LINE user ID.'
                ], 404);
            }
            // This is a placeholder for the actual implementation
            return response()->json([
                'message' => 'LINE authentication successful!'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'error' => 'An error occurred during LINE authentication'
            ], 500);
        }
    }

    public function lineAuth(Request $request, $lineUserId)
    {
        $request->validate([
            'username' => 'required|string|exists:users,username',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->input('username'))->firstOrFail();

        if ($user && Hash::check($request->input('password'), $user->password)) {
            $user->line_user_id = $lineUserId ?? null; // Assuming you want to store the LINE user ID
            $user->save();
            Auth::login($user);
        } else {
            return response()->json([
                'error' => 'Invalid username or password.'
            ], 401);
        }

        return response()->json([
            'message' => 'Login successful!'
        ]);
    }
}
