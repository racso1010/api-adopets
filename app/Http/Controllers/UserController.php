<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    // Return all users in the system
    public function index($user_id = null)
    {
        $id = Auth::id(); // Current user ID

        // Only admins can execute this request
        if (User::isAdmin($id)) {

            // Get single user
            if (isset($user_id))
                return User::find($user_id);

            // Get all users
            return User::all();
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // Update user data
    public function update(Request $request, $user)
    {

        $data = $request->all();
        $updatedUser = User::find($user);

        $userValidation = [
            'first_name' => ['string'],
            'last_name' => ['string'],
            'phone_number' => ['string'],
            'role' => ['string'],
            'email' => ['string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['confirmed', Rules\Password::defaults()],
        ];


        // If user wants to reset password
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $request->validate($userValidation);

        $updatedUser->update($data);

        return response()->json(['success' => "User {$user} was updated"]);
    }

    // Soft delete is enable so just send user to trash
    public function destroy($request)
    {

        $user = User::find($request);

        $user->delete();

        return response()->json(["success" => "User ID: {$request} has been deleted"]);
    }
}