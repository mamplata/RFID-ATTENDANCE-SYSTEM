<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    // Display a list of users
    public function index(): Response
    {
        $users = User::all();
        // Return the Inertia page with the users data
        return Inertia::render('Users/Index', [
            'users' => $users,
        ]);
    }

    // Show the form to create a new user
    public function create(): Response
    {
        // Return the Inertia page for creating a new user
        return Inertia::render('Users/Create');
    }

    // Store a new user
    public function store(Request $request): Response
    {
        // Validate the input data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        // Create a new user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Redirect to users index after creation
        return redirect()->route('users.index');
    }

    // Show the form to edit an existing user
    public function edit($id): Response
    {
        // Find the user to edit
        $user = User::findOrFail($id);
        // Return the Inertia page for editing the user
        return Inertia::render('Users/Edit', [
            'user' => $user,
        ]);
    }

    // Update an existing user
    public function update(Request $request, $id): Response
    {
        // Validate the input data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        // Find the user to update
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;

        // If a password is provided, hash it and update
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        // Save the updated user data
        $user->save();

        // Redirect to users index after updating
        return redirect()->route('users.index');
    }

    // Delete an existing user
    public function destroy($id): Response
    {
        // Find and delete the user
        $user = User::findOrFail($id);
        $user->delete();

        // Redirect to users index after deletion
        return redirect()->route('users.index');
    }
}
