<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        // Fetch all users with pagination
        $users = User::paginate(20);

        // Return the view with the users
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the view for creating a new user
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate and create a new user
        $newUser = User::create($request->validated());

        // Redirect to the users index with a success message
        $url = route('users.show', ['user' => $newUser]);
        $htmlMessage = "User <a href='$url'><strong>{$newUser->id}</strong>
                    - </a> New User has been created successfully!";
        return redirect()->route('users.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Return the view for showing a specific user
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Return the view for editing a specific user
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validate and update the user
        $user->update($request->validated());

        // Redirect back to the users index with a success message
        return redirect()->route('users.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Delete the user
        $user->delete();

        // Redirect back to the users index with a success message
        return redirect()->route('users.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'User deleted successfully!');
    }
}
