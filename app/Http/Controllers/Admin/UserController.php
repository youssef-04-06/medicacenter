<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function update(Request $request, User $user)
    {
        // Toggle admin access. Guard against an admin removing their own access by accident.
        if ($user->id === auth()->id()) {
            return back()->with('error', "You can't change your own admin status.");
        }

        $user->update(['is_admin' => $request->boolean('is_admin')]);

        return back()->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', "You can't delete your own account.");
        }

        $user->delete();

        return back()->with('success', 'User removed successfully.');
    }
}
