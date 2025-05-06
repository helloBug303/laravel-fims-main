<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserGroup;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Display all users with optional search and status filter
    public function index(Request $request)
{
    $query = User::query();

    // If there's a search term, filter by name or username
    if ($request->has('search') && $request->search != '') {
        $query->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('username', 'like', '%' . $request->search . '%');
    }

    // Optionally, filter by status if it's selected
    if ($request->has('status')) {
        $query->where('status', $request->status);
    }

    // Fetch the users
    $users = $query->paginate(10);  // or $query->get() for all users without pagination

    return view('users.index', compact('users'));
}


    // Store a new user in the database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = new User();
        $user->name = $validated['full_name'];
        $user->username = $validated['username'];
        $user->password = Hash::make($validated['password']);
        $user->status = 1; // Active by default
        $user->save();

        return redirect()->route('users.index')->with('msg', 'User created successfully!');
    }

    // Show the form to edit an existing user
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    // Update the user data
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'status' => 'required|boolean',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->name = $validated['name'];
        $user->username = $validated['username'];
        $user->status = $validated['status'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('users.index')->with('msg', 'User updated successfully!');
    }

    // Delete a user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('msg', 'User deleted successfully!');
    }
}
